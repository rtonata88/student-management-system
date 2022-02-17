<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Invoice;
use App\Module;
use Illuminate\Http\Request;

class AccountReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $academic_years = AcademicYear::pluck('academic_year', 'academic_year');

        $subjects = Module::pluck('subject_name', 'id');

        $invoices = Invoice::where('financial_year', $financial_year)
                            ->join('students', 'students.id', '=', 'invoices.student_id')
                            ->selectRaw('student_number2, surname, student_names, contact_number, sum(debit_amount) as debit_amount, sum(credit_amount) as credit_amount, sum(debit_amount - credit_amount) as balance')
                            ->groupBy('student_id')
                            ->get();

        session()->put('invoices', $invoices);

        return view('Reports.Accounting.Index', compact('invoices', 'academic_years', 'subjects'));
    }
}
