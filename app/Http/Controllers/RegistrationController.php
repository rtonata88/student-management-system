<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Center;
use App\Fees;
use App\Invoice;
use App\Module;
use App\ModuleRegistration;
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
            $academic_year = AcademicYear::where('status', 1)->first()->academic_year;
            $centers = Center::pluck('center_name', 'id');
            $registration = $student->registration->where('academic_year', $academic_year)->first();
            $registration_status = (!is_null($registration)) ? $registration->registration_status : 'Not registered';
            
            return view('Management.Enrolment.Index', compact('student', 'subjects', 'fees', 'academic_year', 'centers', 'registration_status'));
        }
        
        return view('Management.Enrolment.Index', compact('student'));
    }

    public function show($student_id){
        $student = Student::find($student_id);
        $invoice = Invoice::where('student_id', $student_id)->where('academic_year', 'Registered')->get();

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
        $request->validate([
            'academic_year' => 'required',
        ]);
        $this->enrol($request);
        $this->registerModules($request);
        $this->createInvoice($request);
        
        return redirect()->route('invoice.show', $request->student_id);
    }

    private function enrol($request){
        $enrolment = Registration::where('academic_year',$request->academic_year)
                                ->where('student_id', $request->student_id)
                                ->first();

        if(!$enrolment){
            $enrolment = new Registration;
            $enrolment->student_id = $request->student_id;
            $enrolment->academic_year = $request->academic_year;
            $enrolment->registration_date = date('Y-m-d');
            $enrolment->registration_status = 'Registered';
            $enrolment->save();
        }
    }

    private function registerModules($request){
        for ($i = 0; $i < count($request->subject); $i++) {
            $enrolment = new ModuleRegistration;
            $enrolment->student_id = $request->student_id;
            $enrolment->module_id = $request->subject[$i];
            $enrolment->amount = $request->subject_fee[$i];
            $enrolment->academic_year = $request->academic_year;
            $enrolment->registration_date = date('Y-m-d H:i:s');
            $enrolment->registration_status = 'Registered';
            $enrolment->save();
        }
    }

    private function createInvoice($request){
        $academic_year = AcademicYear::where('academic_year', $request->academic_year)->first();
        $reference_number = $this->generateInvoiceReferenceNumber();

        for ($i = 0; $i < count($request->subject); $i++) {
            Invoice::create([
                'student_id' => $request->student_id,
                'reference_number' => $reference_number,
                'model' => "Module",
                'model_id' => $request->subject[$i],
                'financial_year' => $request->academic_year,
                'transaction_date' => date('Y-m-d'),
                'line_description' => $request->subject_name[$i],
                'debit_amount' => $this->calculateAmount($academic_year, $request->subject_fee[$i]),
                'credit_amount' => 0
            ]);
        }
    
        $this->chargeExtraSelectedFees($academic_year, $reference_number, $request);
        $this->chargeExtraMandatoryFees($academic_year, $reference_number, $request);
    }

    private function chargeExtraSelectedFees($academic_year, $reference_number, $request)
    {
        for ($i = 0; count($request->other_fees); $i++) {
            Invoice::create([
                'student_id' => $request->student_id,
                'reference_number' => $reference_number,
                'model' => "Fees",
                'model_id' => $request->other_fees[$i],
                'financial_year' => $request->academic_year,
                'transaction_date' => date('Y-m-d'),
                'line_description' => $request->fee_description[$i],
                'debit_amount' => $this->calculateExtraFeeAmount($academic_year, $request->fee_amount[$i], $request->charge_type[$i]),
                'credit_amount' => 0
            ]);
        }
    }

    private function calculateAmount($year, $subject_fee){
        
        $number_of_months = $this->calculateNumberOfMonths(date('Y-m-d'), $year->end_date);

        $amount = $number_of_months * $subject_fee;

        return $amount;
    }

    private function calculateExtraFeeAmount($academic_year, $amount, $charge_type){
        
        if($charge_type === 'Once-off'){
            return $amount;
        } else {
            $number_of_months = $this->calculateNumberOfMonths(date('Y-m-d'), $academic_year->end_date);

            return $number_of_months * $amount;
        }
    }

    private function calculateNumberOfMonths($start_date, $end_date){
        $ts1 = strtotime($start_date);
        $ts2 = strtotime($end_date);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        return (($year2 - $year1) * 12) + ($month2 - $month1);
    }

    private function generateInvoiceReferenceNumber(){
        $reference_number = rand(100000, 999999);

        $invoice = Invoice::where('reference_number', $reference_number)->first();
        if (count($invoice) > 0) {
            $this->generateInvoiceReferenceNumber();
        }

        return $reference_number;
    }

    private function chargeExtraMandatoryFees($academic_year, $reference_number, $request){
        $fees = Fees::where('automatic_charge', 'Yes')->get();

        foreach ($fees as $fee) {
            Invoice::create([
                'student_id' => $request->student_id,
                'reference_number' => $reference_number,
                'model' => "Fees",
                'model_id' => $fee->id,
                'financial_year' => $request->academic_year,
                'transaction_date' => date('Y-m-d'),
                'line_description' => $fee->fee_description,
                'debit_amount' => $this->calculateExtraFeeAmount($academic_year, $fee->amount, $fee->charge_type),
                'credit_amount' => 0
            ]);
        }
    }
}
