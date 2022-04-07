<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Center;
use App\CreditMemo;
use App\DebitMemo;
use App\Exports\AccountSummaryReport;
use App\Invoice;
use App\Module;
use App\ModuleRegistration;
use App\Registration;
use App\StudentExtraCharge;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AccountSummaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $financial_years = AcademicYear::pluck('academic_year', 'academic_year');

        $centers = Center::pluck('center_name', 'id');
        
        $financial_year = AcademicYear::where('status', 1)->first()->academic_year;
        
        $registrations = Registration::with('student', 'center')->where('academic_year', $financial_year)->get();

        $registrations = $this->getAccountSummary($registrations, $financial_year);

        $modules = Module::select('id', 'subject_name')->get();

        session()->put('account_summary', $registrations);

        session()->put('modules', $modules);

        return view('Reports.AccountSummary.Index', compact('financial_years', 'centers', 'registrations'));
    }

    public function search(Request $request)
    {
        $financial_years = AcademicYear::pluck('academic_year', 'academic_year');

        $centers = Center::pluck('center_name', 'id');

        $financial_year = AcademicYear::where('status', 1)->first()->academic_year;

        $registrations = Registration::with('student', 'center');
        
        if(isset($request->financial_year)){
             $registrations =  $registrations->where('academic_year', $request->financial_year);
        }

        if (isset($request->center_id)) {
            $registrations =  $registrations->where('center_id', $request->center_id);
        }

        if (isset($request->registration_status)) {
            $registrations =  $registrations->where('registration_status', $request->registration_status);
        }

        $registrations = $registrations->get();

        $registrations = $this->getAccountSummary($registrations, $financial_year);

        $modules = Module::select('id','subject_name')->get();

        session()->put('account_summary', $registrations);

        session()->put('modules', $modules);

        return view('Reports.AccountSummary.Index', compact('financial_years', 'centers', 'registrations'));
    }

    private function getSubjectRegistration($academic_year){

        return ModuleRegistration::select('student_id','module_id', 'amount', 'registration_status', 'registration_date', 'cancellation_date')
            ->where('academic_year', $academic_year)
            ->get();
    }

    private function getRegisteredSubjects($subject_registration, $student_id){
        return $subject_registration->where('student_id', $student_id)
                                    ->where('registration_status', 'Registered');
    }

    private function getCanceledSubjects($subject_registration, $student_id){
        return $subject_registration->where('student_id', $student_id)
                                    ->where('registration_status', 'Canceled');
    }

    private function getPaymentsToDate(){
        return Invoice::select('student_id','credit_amount')
                        ->where('model', 'Payment')
                        ->whereBetween('transaction_date', [date('Y-01-01'), date('Y-m-d')])
                        ->get();
    }

    private function getCreditMemos($academic_year){
        return CreditMemo::whereYear('transaction_date', $academic_year)->get();
    }

    private function getDebitMemos($academic_year)
    {
        return DebitMemo::whereYear('transaction_date', $academic_year)->get();
    }

    private function getInvoices($academic_year){
        return Invoice::select('student_id','debit_amount', 'credit_amount')
                        ->where('financial_year', $academic_year)
                        ->get();
    }

    private function getAccountSummary($registrations, $academic_year){
        
        $subject_registrations = $this->getSubjectRegistration($academic_year);

        $extra_fees = $this->getChargedExtraFees($academic_year);

        $payments_to_date = $this->getPaymentsToDate();

        $credit_memos = $this->getCreditMemos($academic_year);

        $debit_memos = $this->getDebitMemos($academic_year);

        $invoices = $this->getInvoices($academic_year);

        foreach ($registrations as $key => $registration) {
            
                $registered_subjects = $this->getRegisteredSubjects($subject_registrations, $registration->student_id);
                
                $canceled_subjects = $this->getCanceledSubjects($subject_registrations, $registration->student_id);
                
                $tuition_fees = $this->calculateTuitionFeesPayable($academic_year, $registered_subjects, $canceled_subjects);
                
                $payments = $this->calculatePaymentsToDate($payments_to_date, $registration->student_id);
                
                $credit_memo = $this->calculateCreditMemos($credit_memos, $registration->student_id);
                
                $total_credit = $credit_memo + $payments;

                $debit_memo = $this->calculateDebitMemos($debit_memos, $registration->student_id);
                
                $total_debit = $tuition_fees + $debit_memo;

                $tuition_fees_payable = ($total_debit - $total_credit);

                $other_fees = $this->calculatePayableOtherFees($extra_fees, $registration->student_id);

                $payable_amount = $tuition_fees_payable +  $other_fees;
            
                $balance = $this->calculateBalance($invoices, $registration->student_id);

                $registrations[$key]->tuition_fees = $tuition_fees_payable;
                $registrations[$key]->other_fees = $other_fees;
                $registrations[$key]->payable_amount = $payable_amount;
                $registrations[$key]->course_balance = $balance;
            }
        
        return $registrations;
    }

    private function calculateBalance($invoices, $student_id)
    {
        $debits = $invoices->where('student_id', $student_id)->sum('debit_amount');

        $credits = $invoices->where('student_id', $student_id)->sum('credit_amount');
        
        return ($debits - $credits);
    }

    private function calculatePayableOtherFees($extra_fees, $student_id)
    {
        $extra_fees = $extra_fees->where('student_id', $student_id);

        $charged = $extra_fees->sum('amount');

        $paid = $extra_fees->sum('amount_paid');

        return ($charged - $paid);
    }

    private function getChargedExtraFees($academic_year)
    {
        return StudentExtraCharge::whereYear('transaction_date', $academic_year)->get();
    }

    private function calculateTuitionFeesPayable($academic_year, $registered_subjects, $canceled_subjects)
    {
        $registered_subjects_payable = $this->payableAmountForRegisteredSubjects($registered_subjects);
        
        $canceled_subjects_payable = $this->payableAmountForCanceledSubjects($canceled_subjects);

        $total_payable = $registered_subjects_payable + $canceled_subjects_payable;
        
        return $total_payable;
    }

    private function payableAmountForRegisteredSubjects($registered_subjects)
    {
        $payable = 0;

        if ($registered_subjects) {
            foreach ($registered_subjects as $registered_subject) {
                $number_of_months_date = $this->calculateNumberOfMonths($registered_subject->registration_date, date('Y-m-d'));
                $payable += $registered_subject->amount * $number_of_months_date;
            }
        }

        return $payable;
    }

    private function payableAmountForCanceledSubjects($cancelled_subjects)
    {
        $payable = 0;

        if ($cancelled_subjects) {
            foreach ($cancelled_subjects as $cancelled_subject) {
                $number_of_months_date = $this->calculateNumberOfMonths($cancelled_subject->registration_date, $cancelled_subject->cancellation_date);
                
                $payable += $cancelled_subject->amount * $number_of_months_date;
            }
        }

        return $payable;
    }

    private function calculatePaymentsToDate($payments_to_date, $student_id)
    {
       return $payments_to_date->where('student_id', $student_id)->sum('credit_amount');
    }

    private function calculateCreditMemos($credit_memos, $student_id)
    {
        return $credit_memos->where('student_id', $student_id)->sum('amount');
    }

    private function calculateDebitMemos($debit_memos, $student_id)
    {
        return $debit_memos->where('student_id', $student_id)->sum('amount');
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

    public function export()
    {
        return Excel::download(new AccountSummaryReport, 'Account_Summary_' . date('M') . '.xlsx');
    }

}
