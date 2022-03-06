<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Center;
use App\Payment;
use Illuminate\Http\Request;

class PaymentReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $academic_years = AcademicYear::pluck('academic_year', 'academic_year');

        $payments = Payment::with('student')->where('transaction_date', date('Y-m-d'))->get();

        session()->put('payments_report', $payments);

        return view('Reports.Payments.Index', compact('payments'));
    }

    public function search(Request $request)
    {
        $centers = Center::pluck('center_name', 'id');
        $academic_years = AcademicYear::pluck('academic_year', 'academic_year');

        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $payments = Payment::with('student')->whereBetween('transaction_date', $date_from, $date_to);

        if (isset($request->receipt_number)) {
            $payments = $payments->where('receipt_number', $request->receipt_number);
        }

        if (isset($request->student_id)) {
            $payments = $payments->where('student_id', $request->student_id);
        }

        $payments = $payments->paginate(100);

        session()->put('payments_report', $payments);

        return view('Reports.Payments.Index', compact('payments'));
    }

    public function export()
    {
        return Excel::download(new SubjectRegistration, 'student_report_' . date('Y-m-d') . '.xlsx');
    }
}
