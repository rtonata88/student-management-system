<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AcademicYear;
use App\Center;
use App\Student;
use App\Fees;
use App\Invoice;
use App\Module;
use App\ModuleRegistration;
use App\Registration;
use App\StudentExtraCharge;

class CancelRegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('Management.Cancel.Index');
    }

    public function filter(Request $request)
    {
        $student = Student::where('student_number', $request->student_number)->first();

        if ($student) {
            $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

            $charged_fees = Invoice::where('model', 'Fees')
                                    ->where('student_id', $student->id)
                                    ->where('financial_year', $academic_year)
                                    ->get();

            return view('Management.Cancel.Index', compact('student', 'academic_year', 'charged_fees'));
        }

        return view('Management.Enrolment.Index', compact('student'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cancelation_reason' => 'required',
        ]);
        
        $academic_year = AcademicYear::where('status', 1)->first();

        $cancelation = ModuleRegistration::whereIn('module_id', $request->subject)
                            ->where('student_id', $request->student_id)
                            ->where('academic_year', $academic_year->academic_year)
                            ->update([
                                'cancellation_date' => date('Y-m-d'),
                                'cancellation_reason' => $request->cancelation_reason,
                                'registration_status' => 'Canceled'
                            ]);

        
        $this->cancelStudentEnrolment($academic_year, $request);

        $reference_number = $this->generateInvoiceReferenceNumber();
        $this->creditModuleFees($academic_year, $reference_number, $request);

        /**
         * TODO: Given to find out if extra fees charged can be canceled.
         **/
        //$this->creditExtraChargedFees($academic_year, $reference_number, $request);

        return redirect()->route('invoices.show', $request->student_id);
    }

    private function cancelStudentEnrolment($academic_year, $request){
        $registered_modules = ModuleRegistration::where('student_id', $request->student_id)
                                                ->where('academic_year', $academic_year->academic_year)
                                                ->whereNotNull('cancellation_date')
                                                ->get();
        
        if(count($registered_modules) == 0){
            Registration::where('student_id', $request->student_id)
                        ->where('academic_year', $academic_year->academic_year)
                        ->update([
                            'cancellation_date' => date('Y-m-d'),
                            'cancellation_reason' => $request->cancelation_reason,
                            'registration_status' => 'Canceled']);
        }

    }

    private function generateInvoiceReferenceNumber()
    {
        $reference_number = rand(100000, 999999);

        $invoice = Invoice::where('reference_number', $reference_number)->first();
        if (count($invoice) > 0) {
            $this->generateInvoiceReferenceNumber();
        }

        return $reference_number;
    }

    private function creditModuleFees($academic_year, $reference_number, $request)
    {
        $invoices = [];
        
        $subjects = Module::whereIn('id', $request->subject)->get();

        for ($i = 0; $i < count($request->subject); $i++) {
            array_push(
                $invoices,
                [
                    'student_id' => $request->student_id,
                    'reference_number' => $reference_number,
                    'model' => "Module",
                    'model_id' => $request->subject[$i],
                    'financial_year' => $academic_year->academic_year,
                    'transaction_date' => date('Y-m-d'),
                    'line_description' => 'CANCEL'.' - '.$subjects->where('id', $request->subject[$i])->first()->subject_name,
                    'debit_amount' => 0,
                    'credit_amount' => $this->calculateAmount(
                        $academic_year,
                        $subjects->where('id', $request->subject[$i])
                            ->first()
                            ->subject_fees
                    ),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );
        }

        Invoice::insert($invoices);

    }

    private function creditExtraChargedFees($academic_year, $reference_number, $request){
        $invoice = [];
        $charged_fees = Invoice::select('model_id')
            ->where('model', 'Fees')
            ->where('financial_year', $academic_year)
            ->whereIn('model_id', $request->other_fees)
            ->get();

        $student_extra_charges = StudentExtraCharge::where('student_id', $request->student_id)
                                                    ->whereYear('transaction_date', $academic_year)
                                                    ->whereIn('fee_id', $request->other_fees)
                                                    ->get();

        $fees = Fees::whereIn('id', $request->other_fees)->get();

        foreach($charged_fees as $charged_fee){
                array_push(
                $invoice,
                    [
                        'student_id' => $request->student_id,
                        'reference_number' => $reference_number,
                        'model' => "Fees",
                        'model_id' => $charged_fee->model_id,
                        'financial_year' => $charged_fee->financial_year,
                        'transaction_date' => date('Y-m-d'),
                        'line_description' => 'CANCEL'.' - '. $charged_fee->line_description,
                        'debit_amount' => 0,
                        'credit_amount' => $this->calculateExtraFeeAmount(
                        $academic_year,
                        $student_extra_charges->where('fee_id', $charged_fee->model_id)->first()->amount,
                        $fees->where('id', $charged_fee->model_id)->first()->charge_type),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]
                );
            }

        Invoice::insert($invoice);
    }

    private function calculateExtraFeeAmount($academic_year, $amount, $charge_type)
    {

        if ($charge_type === 'Once-off') {
            return $amount;
        } else {
            $number_of_months = $this->calculateNumberOfMonths(date('Y-m-d'), $academic_year->end_date);

            return $number_of_months * $amount;
        }
    }

    private function calculateAmount($year, $subject_fee)
    {

        $number_of_months = $this->calculateNumberOfMonths(date('Y-m-d'), $year->end_date);

        $amount = $number_of_months * $subject_fee;
        
        return $amount;
    }

    private function calculateNumberOfMonths($start_date, $end_date)
    {
        $ts1 = strtotime($start_date);
        $ts2 = strtotime($end_date);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        return (($year2 - $year1) * 12) + ($month2 - $month1);
    }
}
