<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Registration;
use App\ModuleRegistration;
use App\AcademicYear;
use App\CompanySetup;
use PDF;
use Carbon\Carbon;

class ProofOfRegistrationController extends Controller
{
    /**
     * Display the search page for proof of registration
     */
    public function index()
    {
        return view('ProofOfRegistration.Search');
    }

    /**
     * Filter students for proof of registration
     */
    public function filter(Request $request)
    {
        $students = collect();

        if ($request->student_number) {
            $students = Student::where('student_number', 'like', '%' . $request->student_number . '%')
                             ->orWhere('student_number2', 'like', '%' . $request->student_number . '%')
                             ->with(['center', 'registration'])
                             ->get();
        } elseif ($request->names) {
            $students = Student::where('student_names', 'like', '%' . $request->names . '%')
                             ->orWhere('surname', 'like', '%' . $request->names . '%')
                             ->with(['center', 'registration'])
                             ->get();
        }

        if ($students->isEmpty()) {
            return redirect()->back()->with('message', 'No students found matching your search criteria.');
        }

        // Filter students to only show those with active registrations
        $currentYear = AcademicYear::where('status', 1)->first();
        $students = $students->filter(function ($student) use ($currentYear) {
            $registration = $student->registration->where('academic_year', $currentYear->academic_year)->first();
            return $registration && $registration->registration_status == 'Registered';
        });

        if ($students->isEmpty()) {
            return redirect()->back()->with('message', 'No registered students found matching your search criteria.');
        }

        return view('ProofOfRegistration.Search', compact('students'));
    }

    /**
     * Generate proof of registration for a student
     */
    public function generate($studentId)
    {
        $student = Student::with(['center', 'registration'])->findOrFail($studentId);
        $currentYear = AcademicYear::where('status', 1)->first();
        
        $registration = $student->registration->where('academic_year', $currentYear->academic_year)->first();
        
        if (!$registration || $registration->registration_status != 'Registered') {
            return redirect()->back()->with('error', 'Student is not registered for the current academic year.');
        }
        
        $registered_modules = ModuleRegistration::where('student_id', $student->id)
            ->where('academic_year', $currentYear->academic_year)
            ->with(['module', 'subject'])
            ->get();

        $company = CompanySetup::first();

        return view('ProofOfRegistration.Generate', compact('student', 'registration', 'registered_modules', 'currentYear', 'company'));
    }

    /**
     * Download proof of registration as PDF
     */
    public function download($studentId)
    {
        $student = Student::with(['center', 'registration'])->findOrFail($studentId);
        $currentYear = AcademicYear::where('status', 1)->first();
        
        $registration = $student->registration->where('academic_year', $currentYear->academic_year)->first();
        
        if (!$registration || $registration->registration_status != 'Registered') {
            return redirect()->back()->with('error', 'Student is not registered for the current academic year.');
        }
        
        $registered_modules = ModuleRegistration::where('student_id', $student->id)
            ->where('academic_year', $currentYear->academic_year)
            ->with(['module', 'subject'])
            ->get();

        $company = CompanySetup::first();

        try {
            $pdf = PDF::loadView('ProofOfRegistration.Print', compact('student', 'registration', 'registered_modules', 'currentYear', 'company'));
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'isRemoteEnabled' => false,
                'isHtml5ParserEnabled' => true,
                'isFontSubsettingEnabled' => true,
                'tempDir' => storage_path('app/temp'),
                'fontDir' => storage_path('fonts/'),
                'fontCache' => storage_path('fonts/'),
                'chroot' => storage_path('app/'),
            ]);
            
            $filename = 'proof_of_registration_' . $student->student_number . '_' . date('Y-m-d') . '.pdf';
            
            return $pdf->download($filename);
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to generate PDF. Error: ' . $e->getMessage());
        }
    }

    /**
     * Print view for proof of registration
     */
    public function print($studentId)
    {
        $student = Student::with(['center', 'registration'])->findOrFail($studentId);
        $currentYear = AcademicYear::where('status', 1)->first();
        
        $registration = $student->registration->where('academic_year', $currentYear->academic_year)->first();
        
        if (!$registration || $registration->registration_status != 'Registered') {
            return redirect()->back()->with('error', 'Student is not registered for the current academic year.');
        }
        
        $registered_modules = ModuleRegistration::where('student_id', $student->id)
            ->where('academic_year', $currentYear->academic_year)
            ->with(['module', 'subject'])
            ->get();

        $company = CompanySetup::first();

        return view('ProofOfRegistration.Print', compact('student', 'registration', 'registered_modules', 'currentYear', 'company'));
    }
}
