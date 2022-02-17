<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Exports\InvoiceReport;
use App\Invoice;
use App\Module;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $financial_year = AcademicYear::where('status', 1)->first()->academic_year;

        $academic_years = AcademicYear::pluck('academic_year', 'academic_year');

        $subjects = Module::pluck('subject_name', 'id');

        $invoices = Invoice::where('financial_year', $financial_year)
            ->join('students', 'students.id', '=', 'invoices.student_id')
            ->selectRaw('student_number2, surname, student_names, contact_number, sum(debit_amount) as debit_amount, sum(credit_amount) as credit_amount, sum(debit_amount - credit_amount) as balance')
            ->groupBy('student_id')
            ->paginate(100);


        session()->put('invoices', $invoices);

        return view('Reports.Accounting.Index', compact('invoices', 'academic_years', 'subjects'));
    }

    public function search(Request $request)
    {
        $academic_years = AcademicYear::pluck('academic_year', 'academic_year');
        $subjects = Module::pluck('subject_name', 'id');


        $invoices = Invoice::join('students', 'students.id', '=', 'invoices.student_id')
            ->selectRaw('student_number2, surname, student_names, contact_number, sum(debit_amount) as debit_amount, sum(credit_amount) as credit_amount, sum(debit_amount - credit_amount) as balance')
            ->groupBy('student_id');

        if (isset($request->financial_year)) {
            $invoices = $invoices->where('financial_year', $request->financial_year);
        }

        if (isset($request->fee_type)) {
            if($request->fee_type === 'Subject'){
                $invoices = $invoices->where('model', 'Module');
            }

            if ($request->fee_type === 'Other fees') {
                $invoices = $invoices->where('model', 'Fees');
            }
        }

        if (isset($request->subject_id)) {
            $invoices = $invoices->where('module_id', $request->subject_id)
                                ->where('model', 'Module');
        }

        $invoices = $invoices->paginate(100);

        session()->put('invoices', $invoices);

        return view('Reports.Accounting.Index', compact('invoices', 'academic_years', 'subjects'));
    }

    public function export()
    {
        return Excel::download(new InvoiceReport, 'Finance_report_' . date('Y-m-d') . '.xlsx');
    }

}
