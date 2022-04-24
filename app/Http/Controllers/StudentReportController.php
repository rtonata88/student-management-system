<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Center;
use App\Exports\Students;
use App\Exports\SubjectRegistration;
use App\Module;
use App\ModuleRegistration;
use App\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $academic_years = AcademicYear::pluck('academic_year', 'academic_year');

        $subjects = Module::pluck('subject_name', 'id');

        $subject_registration = ModuleRegistration::with(['student', 'subject', 'registration'])->where('academic_year', $academic_year)->get();
        
        session()->put('subject_registration', $subject_registration);

        return view('Reports.Students.Index', compact('subject_registration', 'academic_years', 'subjects'));
    }

    public function search(Request $request){
        $centers = Center::pluck('center_name', 'id');
        $students = Student::all();
        $academic_years = AcademicYear::pluck('academic_year', 'academic_year');
        $subjects = Module::pluck('subject_name', 'id');


        $subject_registration = ModuleRegistration::with(['student', 'subject', 'registration']);

        if(isset($request->academic_year)){
            $subject_registration = $subject_registration->where('academic_year', $request->academic_year);
        }

        if (isset($request->registration_status)) {
            $subject_registration = $subject_registration->where('registration_status', $request->registration_status);
        }

        if (isset($request->subject_id)) {
            $subject_registration = $subject_registration->where('module_id', $request->subject_id);
        }

        $subject_registration = $subject_registration->get();

        session()->put('subject_registration', $subject_registration);

        return view('Reports.Students.Index', compact('centers', 'subject_registration', 'academic_years', 'subjects'));
    }

    public function export(){
        return Excel::download(new SubjectRegistration, 'student_report_'.date('Y-m-d'). '.xlsx');
    }
    
}
