<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\ExaminationSchedule;
use App\SubjectAllocation;
use App\CompanySetup;
use PDF;
use Carbon\Carbon;

class ExamPermitsController extends Controller
{
    /**
     * Display the search page for exam permits
     */
    public function index()
    {
        return view('ExamPermits.Search');
    }

    /**
     * Search for students to generate exam permits
     */
    public function filter(Request $request)
    {
        $students = collect();
        
        if ($request->student_number) {
            $students = Student::where('student_number', 'like', '%' . $request->student_number . '%')
                             ->orWhere('student_number2', 'like', '%' . $request->student_number . '%')
                             ->with(['center', 'registered_modules.subject'])
                             ->get();
        } elseif ($request->names) {
            $students = Student::where('student_names', 'like', '%' . $request->names . '%')
                             ->orWhere('surname', 'like', '%' . $request->names . '%')
                             ->with(['center', 'registered_modules.subject'])
                             ->get();
        }

        if ($students->isEmpty()) {
            return redirect()->back()->with('message', 'No students found matching your search criteria.');
        }

        return view('ExamPermits.Search', compact('students'));
    }

    /**
     * Generate exam permit for a specific student
     */
    public function generate($studentId)
    {
        $student = Student::with(['center', 'registered_modules.subject'])->findOrFail($studentId);
        
        // Get examination schedules for the student's registered modules
        $moduleIds = $student->registered_modules->pluck('module_id');
        $examSchedules = ExaminationSchedule::where(function($query) use ($moduleIds) {
            $query->whereIn('subject_id', $moduleIds)
                  ->orWhereHas('subjectAllocation', function($subQuery) use ($moduleIds) {
                      $subQuery->whereIn('subject_id', $moduleIds);
                  });
        })
        ->with(['subject', 'subjectAllocation.module', 'venue', 'classDuration', 'examination', 'center'])
        ->orderBy('exam_date')
        ->orderBy('class_duration_id')
        ->get();

        $company = CompanySetup::first();

        return view('ExamPermits.Generate', compact('student', 'examSchedules', 'company'));
    }

    /**
     * Download exam permit as PDF
     */
    public function download($studentId)
    {
        $student = Student::with(['center', 'registered_modules.subject'])->findOrFail($studentId);
        
        // Get examination schedules for the student's registered modules
        $moduleIds = $student->registered_modules->pluck('module_id');
        $examSchedules = ExaminationSchedule::where(function($query) use ($moduleIds) {
            $query->whereIn('subject_id', $moduleIds)
                  ->orWhereHas('subjectAllocation', function($subQuery) use ($moduleIds) {
                      $subQuery->whereIn('subject_id', $moduleIds);
                  });
        })
        ->with(['subject', 'subjectAllocation.module', 'venue', 'classDuration', 'examination', 'center'])
        ->orderBy('exam_date')
        ->orderBy('class_duration_id')
        ->get();

        $company = CompanySetup::first();

        $pdf = PDF::loadView('ExamPermits.Print', compact('student', 'examSchedules', 'company'));
        
        $filename = 'exam_permit_' . $student->student_number . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Print view for exam permit
     */
    public function print($studentId)
    {
        $student = Student::with(['center', 'registered_modules.subject'])->findOrFail($studentId);
        
        // Get examination schedules for the student's registered modules
        $moduleIds = $student->registered_modules->pluck('module_id');
        $examSchedules = ExaminationSchedule::where(function($query) use ($moduleIds) {
            $query->whereIn('subject_id', $moduleIds)
                  ->orWhereHas('subjectAllocation', function($subQuery) use ($moduleIds) {
                      $subQuery->whereIn('subject_id', $moduleIds);
                  });
        })
        ->with(['subject', 'subjectAllocation.module', 'venue', 'classDuration', 'examination', 'center'])
        ->orderBy('exam_date')
        ->orderBy('class_duration_id')
        ->get();

        $company = CompanySetup::first();

        return view('ExamPermits.Print', compact('student', 'examSchedules', 'company'));
    }
}
