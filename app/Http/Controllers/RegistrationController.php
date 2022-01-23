<?php

namespace App\Http\Controllers;

use App\Fees;
use App\Module;
use App\Registration;
use App\StudentExtraCharge;
use Illuminate\Http\Request;
use App\Student;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('Management.Enrolment.Index');
    }

    public function filter(Request $request){
        $student = Student::where('student_number', $request->student_number)->first();
        
        if($student){   
            $subjects = Module::all();
            $fees = Fees::all();

            return view('Management.Enrolment.Index', compact('student', 'subjects', 'fees'));
        }
        
        return view('Management.Enrolment.Index', compact('student'));
    }

    public function show($student_id){
        $student = Student::find($student_id);
        $enrolment = Registration::where('student_id', $student_id)->where('registration_status', 'Registered')->get();
        $extra_fees = StudentExtraCharge::where('student_id', $student_id)->where('status', 'Active')->get();

        $total = $this->calculateTotal($enrolment, $extra_fees);

        return view('Management.Enrolment.Show', compact('student', 'enrolment', 'extra_fees', 'total'));
    }

    private function calculateTotal($enrolment, $extra_fees){
        $total = 0;
        $total += $extra_fees->sum('amount');
        foreach ($enrolment as $value) {
            $total += $value->subject->subject_fees;
        }
        return $total;
    }

    public function store(Request $request)
    {
        $this->enrol($request);
        $this->chargeExtraSelectedFees($request);
        $this->chargeExtraMandatoryFees($request);
        
        return redirect()->route('enrolment.show', $request->student_id);
    }

    private function enrol($request){
        for ($i = 0; $i < count($request->subject); $i++) {
            $enrolment = new Registration;
            $enrolment->student_id = $request->student_id;
            $enrolment->registration_date = date('Y-m-d H:i:s');
            $enrolment->registration_status = 'Registered';
            $enrolment->module_id = $request->subject[$i];
            $enrolment->save();
        }
    }

    private function chargeExtraSelectedFees($request) {
        for ($i = 0; count($request->other_fees); $i++) {
            $other_charges = new StudentExtraCharge;
            $other_charges->transaction_date = date('Y-m-d');
            $other_charges->student_id = $request->student_id;
            $other_charges->fee_id = $request->other_fees[$i];
            $other_charges->fee_description = $request->fee_description[$i];
            $other_charges->status = 'Active';
            $other_charges->save();
        }
    }

    private function chargeExtraMandatoryFees($request){
        $fees = Fees::where('automatic_charge', 'Yes')->get();

        foreach ($fees as $fee) {
            $other_charges = new StudentExtraCharge;
            $other_charges->transaction_date = date('Y-m-d');
            $other_charges->student_id = $request->student_id;
            $other_charges->fee_id = $fee->id;
            $other_charges->fee_description = $fee->fee_description;
            $other_charges->amount = $fee->amount;
            $other_charges->status = 'Active';
            $other_charges->save();
        }
    }
}
