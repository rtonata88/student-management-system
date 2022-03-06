<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Center;
use App\Exports\PaymentsReport;
use App\Payment;
use App\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

        $payments = Payment::with('student')->where('payment_date', date('Y-m-d'))->get();

        session()->put('payments_report', $payments);

        

        return view('Reports.Payments.Index', compact('payments'));
    }

    public function search(Request $request)
    {
        $centers = Center::pluck('center_name', 'id');
        $academic_years = AcademicYear::pluck('academic_year', 'academic_year');

        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $payments = Payment::with('student')->whereBetween('payment_date', [$date_from, $date_to]);

        if (isset($request->receipt_number)) {
            $payments = $payments->where('receipt_number', $request->receipt_number);
        }

        if (isset($request->student_id)) {
            $student = Student::where('student_number2', 'OMA121')->first();
            $payments = $payments->where('student_id', $student->id);
        }

        $payments = $payments->get();

        session()->put('payments_report', $payments);

        return view('Reports.Payments.Index', compact('payments'));
    }

    public function export()
    {
        return Excel::download(new PaymentsReport, 'payments_report_' . date('Y-m-d') . '.xlsx');
    }
}
