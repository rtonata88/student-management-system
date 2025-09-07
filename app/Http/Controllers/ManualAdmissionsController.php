<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ManualAdmissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manual-admissions-view')->only(['index', 'filter']);
        $this->middleware('permission:manual-admissions-edit')->only(['updateAdmissionStatus', 'getAdmissionStatus']);
        $this->middleware('permission:manual-admissions-reports')->only(['generateAdmissionLetter']);
    }

    public function index()
    {
        $students = Student::with('center')
            ->join('student_admissions', 'students.id', '=', 'student_admissions.student_id')
            ->select('students.*', 'student_admissions.admission_status')
            ->where('student_admissions.admission_status', 'full_admission')
            ->paginate(50);
        
        return view('Management.ManualAdmissions.Index', compact('students'));
    }

    public function filter(Request $request)
    {
        $query = Student::with('center')
            ->join('student_admissions', 'students.id', '=', 'student_admissions.student_id')
            ->select('students.*', 'student_admissions.admission_status')
            ->where('student_admissions.admission_status', 'full_admission');

        if (isset($request->student_number) && !empty($request->student_number)) {
            $query->where(function($q) use ($request) {
                $q->where('students.student_number2', $request->student_number)
                  ->orWhere('students.student_number', $request->student_number);
            });
        }

        if (isset($request->names) && !empty($request->names)) {
            $query->where(function($q) use ($request) {
                $q->where('students.surname', 'like', '%' . $request->names . '%')
                  ->orWhere('students.student_names', 'like', '%' . $request->names . '%');
            });
        }

        $students = $query->paginate(100);

        return view('Management.ManualAdmissions.Index', compact('students'));
    }

    public function getAdmissionStatus($id)
    {
        $admission = DB::table('student_admissions')
            ->where('student_id', $id)
            ->orderBy('status_date', 'desc')
            ->first();

        return response()->json([
            'success' => true,
            'admission' => $admission
        ]);
    }

    public function updateAdmissionStatus(Request $request, $id)
    {
        $request->validate([
            'admission_status' => 'required|in:rejected,provisionally_admitted,full_admission',
            'remarks' => 'nullable|string|max:1000'
        ]);

        try {
            DB::table('student_admissions')->updateOrInsert(
                ['student_id' => $id],
                [
                    'admission_status' => $request->admission_status,
                    'remarks' => $request->remarks,
                    'status_date' => now(),
                    'updated_at' => now(),
                    'created_at' => now()
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Admission status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update admission status'
            ], 500);
        }
    }

    public function generateAdmissionLetter($id)
    {
        $student = Student::leftJoin('student_admissions', 'students.id', '=', 'student_admissions.student_id')
            ->select('students.*', 'student_admissions.admission_status', 'student_admissions.status_date', 'student_admissions.remarks')
            ->where('students.id', $id)
            ->where('student_admissions.admission_status', 'full_admission')
            ->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found or not fully admitted'
            ], 404);
        }

        // Get company information for letterhead
        $company = DB::table('company_setups')->first();

        try {
            $pdf = Pdf::loadView('Management.ManualAdmissions.AdmissionLetter', compact('student', 'company'));
            
            $filename = 'admission_letter_' . $student->student_number2 . '_' . date('Y-m-d') . '.pdf';
            
            return $pdf->download($filename);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate admission letter: ' . $e->getMessage()
            ], 500);
        }
    }
}
