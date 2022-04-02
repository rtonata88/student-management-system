<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\CreditMemo;
use App\Invoice;
use App\ModuleRegistration;
use App\Payment;
use App\Student;
use App\StudentExtraCharge;
use Session;
use Auth;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('Finance.Payments.Search');
    }

    public function filter(Request $request)
    {
        if (isset($request->student_number)) {
            $student = Student::where('student_number2', $request->student_number)->first();
            if ($student) {
                return redirect()->route('payments.show', $student->id);
            }
        }

        if (isset($request->surname)) {
            $students = Student::where('surname', 'like', '%' . $request->surname . '%')->get();

            if (count($students)) {

                if (count($students) === 1) {
                    return redirect()->route('payments.show', $students->first()->id);
                } else {
                    return view('Finance.Payments.Search', compact('students'));
                }
            }
        }

        Session::flash('message', 'Student information not found, please make sure you have entered a correct student number.');

        return redirect()->back();
    }

    public function edit($student_id){
        $student = Student::find($student_id);
        $academic_year = AcademicYear::where('status', 1)->first();

        $tuition_fees = $this->calculatePayableAmount($academic_year, $student->id);

        $registration = $student->registration->where('academic_year', $academic_year->academic_year)->first();
        
        $registration_status = (!is_null($registration)) ? $registration->registration_status : 'Not registered';

        $extra_fees = $this->getChargedExtraFees($student->id, $academic_year);

        
        return view('Finance.Payments.Create', compact('student', 'academic_year', 'registration_status', 'tuition_fees', 'extra_fees'));
    }

    private function getChargedExtraFees($student_id, $academic_year){
        return StudentExtraCharge::whereYear('transaction_date', $academic_year->academic_year)
                                ->where('student_id', $student_id)
                                ->get();
    }

    private function calculateBalance($financial_year, $student_id){
        $invoice = Invoice::select('debit_amount', 'credit_amount')
                            ->where('financial_year', $financial_year)
                            ->where('student_id', $student_id)
                            ->get();
        $balance = $invoice->sum('debit_amount') - $invoice->sum('credit_amount');

        return $balance;
    }

    private function calculatePayableAmount($academic_year, $id)
    {
        $registered_subjects_payable = $this->payableAmountForRegisteredSubjects($academic_year, $id);

        $canceled_subjects_payable = $this->payableAmountForCanceledSubjects($academic_year, $id);

        $total_payable = $registered_subjects_payable + $canceled_subjects_payable;
                        
        $payments = $this->calculatePaymentsToDate($id);
        
        $credit_memos = $this->calculateCreditMemos($academic_year, $id);

        $total_payable = ($total_payable - $payments - $credit_memos);

        return $total_payable;
    }

    private function payableAmountForRegisteredSubjects($academic_year, $id){

        $registered_subjects = ModuleRegistration::select('module_id', 'amount', 'registration_status', 'registration_date', 'cancellation_date')
                                ->where('student_id', $id)
                                ->where('academic_year', $academic_year->academic_year)
                                ->where('registration_status', 'Registered')
                                ->get();

        $payable = 0;

        if ($registered_subjects) {
            foreach ($registered_subjects as $registered_subject) {
                $number_of_months_date = $this->calculateNumberOfMonths($registered_subject->registration_date, date('Y-m-d'));
                $payable += $registered_subject->amount * $number_of_months_date;
            }
        }

        return $payable;
    }

    private function payableAmountForCanceledSubjects($academic_year, $id){

        $cancelled_subjects = ModuleRegistration::select('module_id', 'amount', 'registration_status', 'registration_date', 'cancellation_date')
            ->where('student_id', $id)
            ->where('academic_year', $academic_year->academic_year)
            ->where('registration_status', 'Canceled')
            ->get();
        
        $payable = 0;

        if ($cancelled_subjects) {
            foreach ($cancelled_subjects as $cancelled_subject) {
                $number_of_months_date = $this->calculateNumberOfMonths($cancelled_subject->registration_date, $cancelled_subject->cancellation_date);
                $payable += $cancelled_subject->amount * $number_of_months_date;
            }
        }

        return $payable;
    }

    private function calculatePaymentsToDate($student_id){
        return Invoice::select('credit_amount')
                        ->where('model', 'Payment')
                        ->where('student_id', $student_id)
                        ->whereBetween('transaction_date', [date('Y-01-01'), date('Y-m-d')])
                        ->sum('credit_amount');
    }

    private function calculateCreditMemos($academic_year, $student_id){
        return CreditMemo::where('student_id', $student_id)
                            ->whereYear('transaction_date', $academic_year->academic_year)
                            ->sum('amount');
    }

    private function calculateNumberOfMonths($start_date, $end_date)
    {
        $ts1 = strtotime($start_date);
        $ts2 = strtotime($end_date);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        return (($year2 - $year1) * 12) + ($month2 - $month1) + 1;
    }

    public function show($id)
    {
        $student = Student::find($id);

        $academic_year = AcademicYear::where('status', 1)->first();

        $tuition_fees = $this->calculatePayableAmount($academic_year, $student->id);

        $other_fees = $this->calculatePayableOtherFees($academic_year, $student->id);

        $payable_amount = $tuition_fees +  $other_fees;

        $balance = $this->calculateBalance($academic_year->academic_year, $student->id);

        $registration = $student->registration->where('academic_year', $academic_year->academic_year)->first();

        $registration_status = (!is_null($registration)) ? $registration->registration_status : 'Not registered';

        $payments = Payment::where('student_id', $id)
            ->whereYear('payment_date', $academic_year->academic_year)
            ->get();

        return view('Finance.Payments.Show', compact('payments','student', 'academic_year','balance' ,'registration_status', 'payable_amount', 'other_fees', 'tuition_fees', 'extra_fees', 'monthly_amount'));
    }

    private function calculatePayableOtherFees($academic_year, $student_id){
        $extra_fees = $this->getChargedExtraFees($student_id, $academic_year);
        $charged = $extra_fees->sum('amount');
        $paid = $extra_fees->sum('amount_paid');
        return ($charged - $paid);
    }

    public function print($student_id)
    {
        $student = Student::find($student_id);

        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $payments = Payment::where('student_id', $student_id)
            ->whereYear('payment_date', $academic_year)
            ->get();

        return view('Finance.Payments.Print', compact('payments', 'student'));
    }

    public function store(Request $request){
        
        $request->validate([
            'receipt_amount' => 'required|numeric',
            'receipt_number' => 'required|unique:payments'
        ]);

        $payment_data = $request->all();
        $payment_data['payment_date'] = date('Y-m-d');
        $payment_data['received_by'] = Auth::user()->id;
        $payment_data['payment_amount'] = $request->receipt_amount;

        $payment = Payment::create($payment_data);

        $this->creditStudentInvoice($request, $payment);

        $this->updateExtraChargePayment($request);

        return redirect()->route('payments.show', $request->student_id);
    }

    public function creditStudentInvoice($request, $payment){
        $invoice_items = [];
        if($request->tuition_fees > 0){ 
            array_push(
                $invoice_items,
                [
                    'student_id' => $request->student_id,
                    'reference_number' => $request->receipt_number,
                    'model' => "Payment",
                    'model_id' => $payment->id,
                    'financial_year' => $request->academic_year,
                    'transaction_date' => date('Y-m-d'),
                    'line_description' => "Tuition Fees - Payment",
                    'debit_amount' => 0,
                    'credit_amount' => $request->tuition_fees,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );
        }

        for ($i = 0; $i < count($request->fee_id); $i++) {
            $extra_charge_id = $request->fee_id[$i];

            if ($request->other_fee[$extra_charge_id] > 0) {
                array_push(
                    $invoice_items,
                    [
                        'student_id' => $request->student_id,
                        'reference_number' => $request->receipt_number,
                        'model' => "StudentExtraCharge",
                        'model_id' => $extra_charge_id,
                        'financial_year' => $request->academic_year,
                        'transaction_date' => date('Y-m-d'),
                        'line_description' => $request->fee_description[$extra_charge_id]." - Payment",
                        'debit_amount' => 0,
                        'credit_amount' => $request->other_fee[$extra_charge_id],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]
                );
            }
        }

        if (count($invoice_items) > 0) {
            Invoice::insert($invoice_items);
        }
    }

    public function updateExtraChargePayment($request){
        
        $extra_charges = StudentExtraCharge::whereIn('id', $request->fee_id)->get();
        
        for($i=0; $i<count($request->fee_id); $i++){
            $extra_charge_id = $request->fee_id[$i];

            if ($request->other_fee[$extra_charge_id] > 0) {
                $current_amount = $extra_charges->where('id', $extra_charge_id)->first()->amount_paid;
                StudentExtraCharge::where('id',$extra_charge_id)
                    ->update([
                        'amount_paid' => $current_amount + $request->other_fee[$extra_charge_id],
                    ]);
            }
        }
    }

    public function creditStudentAccount($request, $payment){
        $reference_number  = $this->generateInvoiceReferenceNumber();

        if($request->document_type === 'Payment'){
            $line_description = 'Tuition fees payment - Receipt number '.$request->receipt_number;
        } else {
            $line_description = 'Credit Memo';
        }

        Invoice::create([
            'student_id' => $request->student_id,
            'reference_number' => $reference_number,
            'model' => "Payment",
            'model_id' => $payment->id,
            'financial_year' => $request->academic_year,
            'transaction_date' => date('Y-m-d'),
            'line_description' => $line_description,
            'debit_amount' => 0,
            'credit_amount' =>  $payment->payment_amount
        ]);
    }

    private function generateInvoiceReferenceNumber()
    {
        $reference_number = rand(10000, 999999);

        $invoice = Invoice::where('reference_number', $reference_number)->first();
        if (count($invoice) > 0) {
            $this->generateInvoiceReferenceNumber();
        }

        return $reference_number;
    }
}
