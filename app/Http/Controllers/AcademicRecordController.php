<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\TestMark;
use App\ExamMark;
use App\CompanySetup;
use PDF;
use Carbon\Carbon;

class AcademicRecordController extends Controller
{
    /**
     * Display the search page for academic records
     */
    public function index()
    {
        return view('AcademicRecord.Search');
    }

    /**
     * Filter students for academic records
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

        return view('AcademicRecord.Search', compact('students'));
    }

    /**
     * Generate academic record for a student
     */
    public function generate($studentId)
    {
        $student = Student::with(['center', 'registered_modules.subject'])->findOrFail($studentId);
        
        // Get test marks for the student
        $testMarks = TestMark::where('student_id', $studentId)
                            ->with(['module', 'assessmentType', 'academicYear'])
                            ->orderBy('academic_year_id')
                            ->orderBy('module_id')
                            ->orderBy('assessment_type_id')
                            ->get();

        // Get exam marks for the student
        $examMarks = ExamMark::where('student_id', $studentId)
                            ->with(['module', 'examType', 'academicYear', 'examPaper'])
                            ->orderBy('academic_year_id')
                            ->orderBy('module_id')
                            ->orderBy('exam_type_id')
                            ->get();

        $company = CompanySetup::first();

        return view('AcademicRecord.Generate', compact('student', 'testMarks', 'examMarks', 'company'));
    }

    /**
     * Download academic record as PDF
     */
    public function download($studentId)
    {
        $student = Student::with(['center', 'registered_modules.subject'])->findOrFail($studentId);
        
        // Get test marks for the student
        $testMarks = TestMark::where('student_id', $studentId)
                            ->with(['module', 'assessmentType', 'academicYear'])
                            ->orderBy('academic_year_id')
                            ->orderBy('module_id')
                            ->orderBy('assessment_type_id')
                            ->get();

        // Get exam marks for the student
        $examMarks = ExamMark::where('student_id', $studentId)
                            ->with(['module', 'examType', 'academicYear', 'examPaper'])
                            ->orderBy('academic_year_id')
                            ->orderBy('module_id')
                            ->orderBy('exam_type_id')
                            ->get();

        $company = CompanySetup::first();

        // Return print view directly - PDF generation can be handled by browser print function
        return view('AcademicRecord.Print', compact('student', 'testMarks', 'examMarks', 'company'))
            ->with('download', true);
    }

    /**
     * Print view for academic record
     */
    public function print($studentId)
    {
        $student = Student::with(['center', 'registered_modules.subject'])->findOrFail($studentId);
        
        // Get test marks for the student
        $testMarks = TestMark::where('student_id', $studentId)
                            ->with(['module', 'assessmentType', 'academicYear'])
                            ->orderBy('academic_year_id')
                            ->orderBy('module_id')
                            ->orderBy('assessment_type_id')
                            ->get();

        // Get exam marks for the student
        $examMarks = ExamMark::where('student_id', $studentId)
                            ->with(['module', 'examType', 'academicYear', 'examPaper'])
                            ->orderBy('academic_year_id')
                            ->orderBy('module_id')
                            ->orderBy('exam_type_id')
                            ->get();

        $company = CompanySetup::first();

        return view('AcademicRecord.Print', compact('student', 'testMarks', 'examMarks', 'company'));
    }
}
