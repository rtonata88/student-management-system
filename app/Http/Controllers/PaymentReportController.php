<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Center;
use App\Exports\PaymentsReport;
use App\Invoice;
use App\Payment;
use App\Student;
use App\StudentGuardian;
use App\User;
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

        $payments = Invoice::with('student', 'capturedBy')
                            ->where('transaction_date', date('Y-m-d'))
                            ->whereIn('model', ['StudentExtraCharge', 'Payment'])
                            ->get();

        session()->put('payments_report', $payments);

        $users = User::select('id', 'name')->get();

        session()->put('users', $users);

        $guardians = StudentGuardian::whereIn('student_id', $payments->pluck('student_id'))->get();
        
        session()->put('guardians', $guardians);

        return view('Reports.Payments.Index', compact('payments', 'users'));
    }

    public function search(Request $request)
    {
        $centers = Center::pluck('center_name', 'id');
        $academic_years = AcademicYear::pluck('academic_year', 'academic_year');

        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $payments = Invoice::with('capturedBy', 'student')->whereIn('model', ['StudentExtraCharge', 'Payment'])
                            ->whereBetween('transaction_date', [$date_from, $date_to]);
        
        if (isset($request->receipt_number)) {
            $payments = $payments->where('reference_number', $request->receipt_number);
        }

        if (isset($request->student_number)) {
            $student = Student::where('student_number2', $request->student_number)->first();
            $payments = $payments->where('student_id', $student->id);
        }

        $payments = $payments->get();
        
        $guardians = StudentGuardian::whereIn('student_id', $payments->pluck('student_id'))->get();
        
        $users = User::select('id','name')->get();

        session()->put('payments_report', $payments);

        session()->put('guardians', $guardians);

        session()->put('users', $users);
        
        return view('Reports.Payments.Index', compact('payments', 'users'));
    }

    public function export()
    {
        (new PaymentsReport)->queue('payments_report_' . date('Y-m-d') . '.xlsx');

        return response()->download(storage_path('app') .'/payments_report_' . date('Y-m-d') . '.xlsx');
    }
}
