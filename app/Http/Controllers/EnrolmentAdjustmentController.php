<?php

namespace App\Http\Controllers;

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
}
