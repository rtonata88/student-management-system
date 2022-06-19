<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\CreditMemo;
use App\DebitMemo;
use App\Invoice;
use App\ModuleRegistration;
use App\OtherFeesSummary;
use App\Payment;
use App\Services\StudentBalance;
use App\Services\StudentPayableAmount;
use App\Services\StudentPayableOtherFees;
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

        if (isset($request->names)) {
            $students = Student::where('surname', 'like', '%' . $request->names . '%')
                                ->orwhere('student_names', 'like', '%' . $request->names . '%')
                                ->get();

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

    public function edit($student_id, StudentPayableAmount $payableAmount, StudentPayableOtherFees $payableOtherFees, StudentBalance $studentBalance){
        $student = Student::find($student_id);

        $academic_year = AcademicYear::where('status', 1)->first();

        $debit_memos = $this->calculateDebitMemos($academic_year->academic_year, $student->id);

        $credit_memos = $this->calculateCreditMemos($academic_year->academic_year, $student->id);

        $fees_debit_memos = $debit_memos->where('debit_type', 'tuition')->sum('amount');

        $fees_credit_memos = $credit_memos->where('credit_type', 'tuition')->sum('amount');

        $tuition_fees = $payableAmount->calculatePayableAmount($academic_year->academic_year, $student->id, $fees_debit_memos, $fees_credit_memos);

        $extraFees_debit_memos = $debit_memos->where('debit_type', 'other_fees')->sum('amount');

        $extraFees_credit_memos = $credit_memos->where('credit_type', 'other_fees')->sum('amount');

        $registration = $student->registration->where('academic_year', $academic_year->academic_year)->first();
        
        $registration_status = (!is_null($registration)) ? $registration->registration_status : 'Not registered';

        $extra_fees = $this->getChargedExtraFees($student->id, $academic_year);

        
        return view('Finance.Payments.Create', compact('student', 'academic_year', 'registration_status', 'tuition_fees', 'extra_fees'));
    }

    private function getChargedExtraFees($student_id, $academic_year){
        return OtherFeesSummary::where('academic_year', $academic_year->academic_year)
                                ->where('student_id', $student_id)
                                ->get();
    }


    private function calculateCreditMemos($academic_year, $student_id){
        return CreditMemo::where('student_id', $student_id)
                            ->whereYear('transaction_date', $academic_year)
                            ->get();
    }

    private function calculateDebitMemos($academic_year, $student_id)
    {
        return DebitMemo::where('student_id', $student_id)
            ->whereYear('transaction_date', $academic_year)
            ->get();
    }

    public function show($id, StudentPayableAmount $payableAmount, StudentPayableOtherFees $payableOtherFees, StudentBalance $studentBalance)
    {
        $student = Student::find($id);

        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $debit_memos = $this->calculateDebitMemos($academic_year, $student->id);
        
        $credit_memos = $this->calculateCreditMemos($academic_year, $student->id);
        
        $fees_debit_memos = $debit_memos->where('debit_type', 'tuition')->sum('amount');

        $fees_credit_memos = $credit_memos->where('credit_type', 'tuition')->sum('amount');
        
        $tuition_fees = $payableAmount->calculatePayableAmount($academic_year, $student->id, $fees_debit_memos, $fees_credit_memos);
        
        $extraFees_debit_memos = $debit_memos->where('debit_type', 'other_fees')->sum('amount');

        $extraFees_credit_memos = $credit_memos->where('credit_type', 'other_fees')->sum('amount');

        $other_fees = $payableOtherFees->calculatePayableOtherFees($academic_year, $student->id, $extraFees_debit_memos, $extraFees_credit_memos);

        $payable_amount = $tuition_fees +  $other_fees;

        $balance = $studentBalance->calculateBalance($academic_year, $student->id);

        $registration = $student->registration->where('academic_year', $academic_year)->first();

        $registration_status = (!is_null($registration)) ? $registration->registration_status : 'Not registered';

        $payments = Payment::where('student_id', $id)
            ->whereYear('payment_date', $academic_year)
            ->get();

        return view('Finance.Payments.Show', compact('payments','student', 'academic_year','balance' ,'registration_status', 'payable_amount', 'other_fees', 'tuition_fees'));
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
                'payment_date' => 'required|date',
               // 'receipt_number' => 'required|unique:payments'
            ]);

        $payment_data = $request->all();
        $payment_data['received_by'] = Auth::user()->id;
        $payment_data['payment_amount'] = $request->receipt_amount;

        $payment = Payment::create($payment_data);

        $this->creditStudentInvoice($request, $payment);

        $this->updateExtraChargePayment($request);

        return redirect()->route('payments.show', $request->student_id);
    }

    public function creditStudentInvoice($request, $payment){
        
        if($request->tuition_fees > 0){ 
            Invoice::create([
                'student_id' => $request->student_id,
                'reference_number' => $request->receipt_number,
                'model' => "Payment",
                'model_id' => $payment->id,
                'financial_year' => $request->academic_year,
                'transaction_date' => $request->payment_date,
                'line_description' => "Tuition Fees - Payment",
                'debit_amount' => 0,
                'credit_amount' => $request->tuition_fees
            ]);
        }
        
        for ($i = 0; $i < count($request->fee_id); $i++) {
            $extra_charge_id = $request->fee_id[$i];
            
            if (isset($request->other_fee[$extra_charge_id])) {
                if($request->other_fee[$extra_charge_id] > 0){
                    Invoice::create(
                        [
                            'student_id' => $request->student_id,
                            'reference_number' => $request->receipt_number,
                            'model' => "StudentExtraCharge",
                            'model_id' => $extra_charge_id,
                            'financial_year' => $request->academic_year,
                            'transaction_date' => $request->payment_date,
                            'line_description' => $request->fee_description[$extra_charge_id]." - Payment",
                            'debit_amount' => 0,
                            'credit_amount' => $request->other_fee[$extra_charge_id]
                        ]
                    );
                }
            }
        }
    }

    public function updateExtraChargePayment($request){
        
        $extra_charges = StudentExtraCharge::where('student_id', $request->student_id)
                                            ->whereIn('fee_id', $request->fee_id)
                                            ->get();

        for($i=0; $i < count($request->fee_id); $i++){
            
            $extra_charge_id = $request->fee_id[$i];
            
            if (isset($request->other_fee[$extra_charge_id])) {

                if ($request->other_fee[$extra_charge_id] > 0) {
                    
                    $current_amount = $extra_charges->where('fee_id', $extra_charge_id)->first()->amount_paid;
                    
                    StudentExtraCharge::where('fee_id',$extra_charge_id)
                        ->update([
                            'amount_paid' => $current_amount + $request->other_fee[$extra_charge_id],
                        ]);
                }
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
            'transaction_date' => $request->payment_date,
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
