<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Center;
use App\EducationSystem;
use App\Fees;
use App\Invoice;
use App\Module;
use App\ModuleRegistration;
use App\Student;
use Illuminate\Http\Request;

use Session;

class EnrolmentAdjustmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('Management.Enrolment-Adjustment.Search');
    }

    public function filter(Request $request)
    {

        if (isset($request->student_number)) {
            $student = Student::where('student_number2', $request->student_number)->first();
            if ($student) {
                return redirect()->route('enrolment.adjustment.showScreen', $student->id);
            }
        }

        if (isset($request->names)) {
            $students = Student::where('surname', 'like', '%' . $request->names . '%')
                ->orwhere('student_names', 'like', '%' . $request->names . '%')
                ->get();

            if (count($students)) {
                if (count($students) === 1) {
                    return redirect()->route('enrolment.adjustment.showScreen', $students->first()->id);
                } else {
                    return view('Management.Enrolment-Adjustment.Search', compact('students'));
                }
            }
        }

        Session::flash('not_found', 'The entered student number does not match any record. Please make sure you have entered a correct student number');

        return view('Management.Enrolment-Adjustment.Search', compact('students'));
    }

    public function showEnrollmentScreen($student_id)
    {
        $student = Student::find($student_id);

        $subjects = Module::all();
        $fees = Fees::all();
        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;
        $centers = Center::pluck('center_name', 'id');
        $registration = $student->registration->where('academic_year', $academic_year)->first();
        $registration_status = (!is_null($registration)) ? $registration->registration_status : 'Not registered';

        $registered_modules = ModuleRegistration::where('student_id', $student->id)
            ->where('academic_year', $academic_year);

        $symbols = $registered_modules->get();

        $registered_modules = $registered_modules->pluck('module_id')->toArray();

        $charged_fees = Invoice::where('model', 'Fees')
            ->where('student_id', $student->id)
            ->where('financial_year', $academic_year)
            ->pluck('model_id')
            ->toArray();


        $education_system = EducationSystem::all();

        return view('Management.Enrolment-Adjustment.Index', compact('education_system', 'student', 'subjects', 'fees', 'academic_year', 'centers', 'registration_status', 'registered_modules', 'charged_fees', 'symbols'));
    }

}
