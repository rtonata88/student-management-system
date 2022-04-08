<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\CompanySetup;
use App\CreditMemo;
use App\DebitMemo;
use App\Registration;
use App\Invoice;
use App\ModuleRegistration;
use App\Student;
use App\StudentExtraCharge;
use Session;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('Finance.Invoice.Search');
    }

    public function filter(Request $request){
        if (isset($request->student_number)) {
            $student = Student::where('student_number2', $request->student_number)->first();
            if ($student) {
                return redirect()->route('invoices.show', $student->id);
            }
        }

        if (isset($request->names)) {
            $students = Student::where('surname', 'like', '%' . $request->names . '%')
                                ->orwhere('student_names', 'like', '%' . $request->names . '%')
                                ->get();
            
            if (count($students)) {
                
                if (count($students) === 1) {
                    
                    return redirect()->route('invoices.show', $students->first()->id);
                } else {
                    
                    return view('Finance.Invoice.Search', compact('students'));
                }
            }
        }

        Session::flash('message', 'Student information not found, please make sure you have entered a correct student number.');

        return redirect()->back();
    }

    public function show($id)
    {
        $student = Student::find($id);
        
        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;
        
        $invoices = Invoice::where('student_id', $id)
                            ->where('financial_year', $academic_year)
                            ->get();
        
        $student_center = $this->getStudentCenter($academic_year, $student->id);

        $tuition_fees = $this->calculatePayableAmount($academic_year, $student->id);
        
        
        $other_fees = $this->calculatePayableOtherFees($academic_year, $student->id);
        
        $payable_amount = $tuition_fees +  $other_fees;

        $course_balance = $this->calculateBalance($academic_year, $student->id);

        return view('Finance.Invoice.Show', compact('invoices', 'student', 'student_center', 'tuition_fees', 'other_fees', 'course_balance', 'payable_amount'));
    }
    private function getChargedExtraFees($student_id, $academic_year)
    {
        return StudentExtraCharge::whereYear('transaction_date', $academic_year)
            ->where('student_id', $student_id)
            ->get();
    }

    private function calculatePayableAmount($academic_year, $id)
    {
        $registered_subjects_payable = $this->payableAmountForRegisteredSubjects($academic_year, $id);
        
        $canceled_subjects_payable = $this->payableAmountForCanceledSubjects($academic_year, $id);
        
        $debit_memos = $this->calculateDebitMemos($academic_year, $id);
        
        $total_payable = $registered_subjects_payable + $canceled_subjects_payable + $debit_memos;
        
        $payments = $this->calculatePaymentsToDate($id);
        
        $credit_memos = $this->calculateCreditMemos($academic_year, $id);

        $total_payable = ($total_payable - $payments - $credit_memos);

        return $total_payable;
    }

    private function calculatePayableOtherFees($academic_year, $student_id)
    {
        $extra_fees = $this->getChargedExtraFees($student_id, $academic_year);
        $charged = $extra_fees->sum('amount');
        $paid = $extra_fees->sum('amount_paid');
        return ($charged - $paid);
    }

    private function calculateBalance($financial_year, $student_id)
    {
        
        $invoice = Invoice::select('debit_amount', 'credit_amount')
        ->where('financial_year', $financial_year)
            ->where('student_id', $student_id)
            ->get();

        $balance = $invoice->sum('debit_amount') - $invoice->sum('credit_amount');

        return $balance;
    }


    private function payableAmountForRegisteredSubjects($academic_year, $id)
    {

        $registered_subjects = ModuleRegistration::select('module_id', 'amount', 'registration_status', 'registration_date', 'cancellation_date')
        ->where('student_id', $id)
            ->where('academic_year', $academic_year)
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

    private function payableAmountForCanceledSubjects($academic_year, $id)
    {

        $cancelled_subjects = ModuleRegistration::select('module_id', 'amount', 'registration_status', 'registration_date', 'cancellation_date')
        ->where('student_id', $id)
            ->where('academic_year', $academic_year)
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

    private function calculatePaymentsToDate($student_id)
    {
        return Invoice::select('credit_amount')
        ->where('model', 'Payment')
        ->where('student_id', $student_id)
            ->whereBetween('transaction_date', [date('Y-01-01'), date('Y-m-d')])
            ->sum('credit_amount');
    }

    private function calculateCreditMemos($academic_year, $student_id)
    {
        return CreditMemo::where('student_id', $student_id)
            ->whereYear('transaction_date', $academic_year)
            ->sum('amount');
    }

    private function calculateDebitMemos($academic_year, $student_id)
    {
        return DebitMemo::where('student_id', $student_id)
            ->whereYear('transaction_date', $academic_year)
            ->sum('amount');
    }

    private function getStudentCenter($academic_year, $student_id){

        $enrolment = Registration::where('academic_year',$academic_year)
                                ->where('student_id', $student_id)
                                ->first();
        
        return $enrolment->center;
    }

    public function print($student_id){
        $student = Student::find($student_id);

        $company = CompanySetup::find(1);

        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $invoices = Invoice::where('student_id', $student_id)
            ->where('financial_year', $academic_year)
            ->get();

        $student_center = $this->getStudentCenter($academic_year, $student->id);

        $tuition_fees = $this->calculatePayableAmount($academic_year, $student->id);

        $other_fees = $this->calculatePayableOtherFees($academic_year, $student->id);

        $payable_amount = $tuition_fees +  $other_fees;

        $course_balance = $this->calculateBalance($academic_year, $student->id);

        return view('Finance.Invoice.Print', compact('invoices', 'student', 'company', 'student_center', 'tuition_fees', 'other_fees', 'payable_amount', 'course_balance'));
    }

}
