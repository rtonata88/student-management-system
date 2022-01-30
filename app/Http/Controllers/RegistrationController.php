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

            $registered_modules = ModuleRegistration::where('student_id', $student->id)
                                                    ->where('academic_year', $academic_year)
                                                    ->where('registration_status', 'Registered')
                                                    ->pluck('module_id')
                                                    ->toArray();
            
            $charged_fees = Invoice::where('model', 'Fees')
                                    ->where('student_id', $student->id)
                                    ->where('financial_year', $academic_year)
                                    ->pluck('model_id')
                                    ->toArray();

            return view('Management.Enrolment.Index', compact('student', 'subjects', 'fees', 'academic_year', 'centers', 'registration_status', 'registered_modules', 'charged_fees'));
        }
        
        return view('Management.Enrolment.Index', compact('student'));
    }

    public function show($student_id){
        $student = Student::find($student_id);
        $invoice = Invoice::where('student_id', $student_id)->where('academic_year', 'Registered')->get();

        return view('Management.Enrolment.Show', compact('student', 'enrolment', 'extra_fees', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year' => 'required',
        ]);
        
        $subjects = Module::whereIn('id', $request->subject)->get();

        $this->enrol($request);
        $this->registerModules($subjects, $request);
        
        $this->createInvoice($subjects, $request);
        
        return redirect()->route('invoices.show', $request->student_id);
    }

    private function enrol($request){
        $enrolment = Registration::where('academic_year',$request->academic_year)
                                ->where('student_id', $request->student_id)
                                ->first();

        if(!$enrolment){
            $enrolment = new Registration;
            $enrolment->student_id = $request->student_id;
            $enrolment->center_id = $request->center_id;
            $enrolment->academic_year = $request->academic_year;
            $enrolment->registration_date = date('Y-m-d');
            $enrolment->registration_status = 'Registered';
            $enrolment->save();
        } else {
            $enrolment->center_id = $request->center_id;
            $enrolment->save();
        }
    }

    private function registerModules($subjects, $request){
        
        $registered_modules = ModuleRegistration::where('academic_year', $request->academic_year)
            ->where('student_id', $request->student_id)
            ->pluck('module_id')
            ->toArray();
        
        $enrolment = [];
        
        for ($i = 0; $i < count($request->subject); $i++) {
            
            if(!in_array($request->subject[$i], $registered_modules)){
                array_push($enrolment,
                            ['student_id' => $request->student_id,
                            'module_id' => $request->subject[$i],
                            'amount' => $subjects->where('id', $request->subject[$i])->first()->subject_fees,
                            'academic_year' => $request->academic_year,
                            'registration_date' => date('Y-m-d'),
                            'registration_status' => 'Registered',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                            ]
                        );
               
            }
        }
        
        ModuleRegistration::insert($enrolment);
    }

    private function createInvoice($subjects, $request){
        
        $academic_year = AcademicYear::where('academic_year', $request->academic_year)->first();
        $reference_number = $this->generateInvoiceReferenceNumber();
        $invoices = [];
        for ($i = 0; $i < count($request->subject); $i++) {
            array_push(
                $invoices,
                    [
                        'student_id' => $request->student_id,
                        'reference_number' => $reference_number,
                        'model' => "Module",
                        'model_id' => $request->subject[$i],
                        'financial_year' => $request->academic_year,
                        'transaction_date' => date('Y-m-d'),
                        'line_description' => $subjects->where('id', $request->subject[$i])->first()->subject_name,
                        'debit_amount' => $this->calculateAmount($academic_year, 
                                                                    $subjects->where('id', $request->subject[$i])
                                                                            ->first()
                                                                            ->subject_fees
                                                                ),
                        'credit_amount' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]
                );
        }

        Invoice::insert($invoices);

        $fees = Fees::all();
        $this->chargeModuleAttachedFees($subjects, $fees, $academic_year, $reference_number, $request);
        $this->chargeExtraSelectedFees($fees, $academic_year, $reference_number, $request);
        $this->chargeExtraMandatoryFees($fees, $academic_year, $reference_number, $request);
    }

    private function chargeModuleAttachedFees($subjects, $fees, $academic_year, $reference_number, $request){
        $extra_fee_ids = [];
        foreach($subjects as $extra_fee){
            foreach ($extra_fee->extra_fees as $key => $value) {
                array_push(
                    $extra_fee_ids,
                    $value->fee_id
                );
            }
        }

        $fees = $fees->where('automatic_charge', '<>','Yes')
                    ->whereIn('id', $extra_fee_ids);
        
        $invoices = [];
        foreach ($fees as $fee) {
            array_push($invoices, [
                'student_id' => $request->student_id,
                'reference_number' => $reference_number,
                'model' => "Fees",
                'model_id' => $fee->id,
                'financial_year' => $request->academic_year,
                'transaction_date' => date('Y-m-d'),
                'line_description' => $fee->fee_description,
                'debit_amount' => $this->calculateExtraFeeAmount($academic_year, $fee->amount, $fee->charge_type),
                'credit_amount' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        
        Invoice::insert($invoices);
    }

    private function chargeExtraSelectedFees($fees, $academic_year, $reference_number, $request)
    {
        $newInvoices = [];
        $invoices = Invoice::select('model_id')
                            ->where('reference_number', $reference_number)
                            ->where('model', 'Fees')
                            ->pluck('model_id')
                            ->toArray();

        
        for ($i = 0; $i < count($request->other_fees); $i++) {
            if(!in_array($request->other_fees[$i], $invoices)){
                array_push(
                    $newInvoices, 
                    [
                    'student_id' => $request->student_id,
                    'reference_number' => $reference_number,
                    'model' => "Fees",
                    'model_id' => $request->other_fees[$i],
                    'financial_year' => $request->academic_year,
                    'transaction_date' => date('Y-m-d'),
                    'line_description' => $fees->where('id', $request->other_fees[$i])->first()->fee_description,
                    'debit_amount' => $this->calculateExtraFeeAmount($academic_year, 
                                                                    $fees->where('id', $request->other_fees[$i])->first()->amount,
                                                                    $fees->where('id', $request->other_fees[$i])->first()->charge_type
                                                                ),
                    'credit_amount' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
        
        Invoice::insert($newInvoices);
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
        
        return (($year2 - $year1) * 12) + ($month2 - $month1) + 1;
    }

    private function generateInvoiceReferenceNumber(){
        $reference_number = rand(100000, 999999);

        $invoice = Invoice::where('reference_number', $reference_number)->first();
        if (count($invoice) > 0) {
            $this->generateInvoiceReferenceNumber();
        }

        return $reference_number;
    }

    private function chargeExtraMandatoryFees($fees, $academic_year, $reference_number, $request){
        $fees = $fees->where('automatic_charge', 'Yes');

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
