<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Center;
use App\Exports\AccountSummaryReport;
use App\Invoice;
use App\OtherFeesSummary;
use App\AccountSummary;
use App\CompanySetup;
use App\Fees;
use App\Jobs\NotifyUserOfCompletedExport;
use App\Module;
use App\ModuleRegistration;
use App\Registration;
use App\ReportRequest;
use App\StudentGuardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        
        $report_request = ReportRequest::where('report_type', 'AccountSummary')->first();
        
        return view('Reports.AccountSummary.Index', compact('financial_years', 'centers', 'account_summary', 'extra_charges', 'payments', 'totals', 'invoices', 'report_request'));
    }

    private function totals($account_summary, $extra_charges, $payments, $invoices){
        
        $course_balance = $invoices->sum('debit') - $invoices->sum('credit');

        return [
            'tuition_fees' => $account_summary->sum('tuition_fees_payable') - $payments->sum('payments'), 
            'other_fees' => $extra_charges->sum('outstanding'),
            'payable_amount' => (($account_summary->sum('tuition_fees_payable') -$payments->sum('payments')) + $extra_charges->sum('outstanding')),
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
                        ->groupBy('student_id')
                        ->get();
    }

    private function getInvoices($academic_year){
        return Invoice::selectRaw('student_id, sum(debit_amount) debit, sum(credit_amount) credit')
                        ->where('financial_year', $academic_year)
                        ->groupBy('student_id')
                        ->get();
    }

    private function accountSummary($academic_year){
        return AccountSummary::selectRaw('student_id, center_id, student_number2, student_names, contact_number, surname, sum((payable_to_date + debit_memos) - credit_memos) tuition_fees_payable')
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

    private function getExtraChargesDetails($academic_year)
    {
        return OtherFeesSummary::selectRaw('student_id, fee_id, fee_description, (amount_paid + credit_memos) as amount_paid, (outstanding + debit_memos) as outstanding')
            ->where('academic_year', $academic_year)
            ->get();
    }

    private function getAccountSummary($academic_year){
        
        $account_summary = $this->accountSummary($academic_year);

        return $account_summary;
    }

    public function export()
    {
        $centers = Center::pluck('center_name', 'id');

        $financial_year = AcademicYear::where('status', 1)->first()->academic_year;

        $account_summary = $this->getAccountSummary($financial_year);

        $extra_charges = $this->getExtraCharges($financial_year);

        $extra_charges_details = $this->getExtraChargesDetails($financial_year);

        $payments = $this->getPaymentsToDate();

        $invoices = $this->getInvoices($financial_year);

        $totals = $this->totals($account_summary, $extra_charges, $payments, $invoices);

        $modules = Module::select('id', 'subject_name')->get();

        $fees = Fees::select('id', 'fee_description')->get();

        $module_registrations = ModuleRegistration::select('student_id', 'module_id', 'subject_name')
                                                    ->join('modules', 'modules.id', '=', 'module_registrations.module_id')
                                                    ->where('academic_year', $financial_year)
                                                    ->get();

        $guardians = StudentGuardian::whereIn('student_id', $account_summary->pluck('student_id'))->get();

        $fileName = 'Account_Summary_' . date('M') . '.xlsx';

        $company = CompanySetup::find(1);

        ReportRequest::where('report_type', 'AccountSummary')->delete();

        $report_request = ReportRequest::create([
            'report_type' => "AccountSummary",
            'request_datetime' => now(),
            'document_path' => $fileName,
            'status' => "Busy",
            'requested_by' => auth()->user()->name ?? 'System'
        ]);
        
        (new AccountSummaryReport($centers, $financial_year, $account_summary, $extra_charges, $extra_charges_details, $payments, $invoices, $totals, $modules, $fees, $module_registrations, $guardians, $company))->store($fileName)->chain([
            new NotifyUserOfCompletedExport(request()->user(), $fileName, $report_request),
        ]);

        return back()->withSuccess('Export started and report will be ready in 10-15 minutes.');

    }

    public function download(){
        $report_request = ReportRequest::where('report_type', 'AccountSummary')->first();

        return Storage::download($report_request->document_path);
    }

}
