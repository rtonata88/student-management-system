<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Center;
use App\CreditMemo;
use App\DebitMemo;
use App\Exports\AccountSummaryReport;
use App\Invoice;
use App\OtherFeesSummary;
use App\AccountSummary;
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
                
        $account_summary = $this->getAccountSummary($financial_year);
        
        $extra_charges = $this->getExtraCharges($financial_year);

        $payments = $this->getPaymentsToDate();

        $invoices = $this->getInvoices($financial_year);
        
        $totals = $this->totals($account_summary, $extra_charges, $payments, $invoices);
        
        $modules = Module::select('id', 'subject_name')->get();
        
        session()->put('account_summary', $account_summary);

        session()->put('extra_charges', $extra_charges);

        session()->put('payments', $payments);
        
        session()->put('modules', $modules);
        
        return view('Reports.AccountSummary.Index', compact('financial_years', 'centers', 'account_summary', 'extra_charges', 'payments', 'totals', 'invoices'));
    }

    private function totals($account_summary, $extra_charges, $payments, $invoices){
        
        $course_balance = $invoices->sum('debit') - $invoices->sum('credit');

        return [
            'tuition_fees' => ($account_summary->sum('tuition_fees_payable') + $extra_charges->sum('outstanding')) - $payments->sum('payments'),
            'other_fees' => $extra_charges->sum('outstanding'),
            'payable_amount' => $account_summary->sum('tuition_fees_payable'),
            'course_balance' => $course_balance
        ];
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

    private function getPaymentsToDate(){
        return Invoice::selectRaw('student_id, sum(credit_amount) payments')
                        ->where('model', 'Payment')
                        ->whereBetween('transaction_date', [date('Y-01-01'), date('Y-m-d')])
                        ->get();
    }

    private function getInvoices($academic_year){
        return Invoice::selectRaw('student_id, sum(debit_amount) debit, sum(credit_amount) credit')
                        ->where('financial_year', $academic_year)
                        ->groupBy('student_id')
                        ->get();
    }

    private function accountSummary($academic_year){
        return AccountSummary::selectRaw('student_id, center_id, student_number2, student_names, surname, sum((payable_to_date + debit_memos) - credit_memos) tuition_fees_payable')
                            ->where('academic_year', $academic_year)
                                ->groupBy('student_id', 'center_id', 'student_number2', 'student_names', 'surname')
                                ->get();
    }

    private function getExtraCharges($academic_year)
    {
        return OtherFeesSummary::selectRaw('student_id, sum((outstanding + debit_memos) - credit_memos) outstanding')
                                ->where('academic_year', $academic_year)
                                ->groupBy('student_id')
                                ->get();
    }

    private function getAccountSummary($academic_year){
        
        $account_summary = $this->accountSummary($academic_year);
        
        return $account_summary;
    }

    private function calculateBalance($invoices, $student_id)
    {
        $debits = $invoices->where('student_id', $student_id)->sum('debit');

        $credits = $invoices->where('student_id', $student_id)->sum('credit');
        
        return ($debits - $credits);
    }

    public function export()
    {
        return Excel::download(new AccountSummaryReport, 'Account_Summary_' . date('M') . '.xlsx');
    }

}
