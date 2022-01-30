<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Payment;
use App\Student;
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
        return view('Finance.Payments.Index');
    }

    public function filter(Request $request)
    {
        $student = Student::where('student_number', $request->student_number)->first();

        if ($student) {
            return view('payments.index', compact('student'));
        }

        Session::flash('message', 'Student information not found, please make sure you have entered a correct student number.');

        return redirect()->back();
    }

    public function show($id)
    {
        $student = Student::find($id);

        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $payments = Payment::where('student_id', $id)
            ->whereYear('payment_date', $academic_year)
            ->get();

        return view('Finance.Payments.Show', compact('payments', 'student'));
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

        $payment_data = $request->all();
        $payment_data['payment_date'] = date('Y-m-d');
        $payment_data['received_by'] = Auth::user()->id;

        Payment::create($payment_data);

        Session::flash('message', 'Payment successfully recorded.');
        
        return redirect()->route('payments.show', $request->student_id);
    }
}
