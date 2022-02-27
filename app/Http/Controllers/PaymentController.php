<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Invoice;
use App\ModuleRegistration;
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
        return view('Finance.Payments.Search');
    }

    public function filter(Request $request)
    {
        if (isset($request->student_number)) {
            $student = Student::where('student_number2', $request->student_number)->first();
            if ($student) {
                return redirect()->route('payments.edit', $student->id);
            }
        }

        if (isset($request->surname)) {
            $students = Student::where('surname', 'like', '%' . $request->surname . '%')->get();

            if (count($students)) {

                if (count($students) === 1) {
                    return redirect()->route('payments.edit', $students->first()->id);
                } else {
                    return view('Finance.Payments.Search', compact('students'));
                }
            }
        }

        Session::flash('message', 'Student information not found, please make sure you have entered a correct student number.');

        return redirect()->back();
    }

    public function edit($student_id){
        $student = Student::find($student_id);
        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $payable_amount = $this->calculatePayableAmount($academic_year, $student->id);

        $registration = $student->registration->where('academic_year', $academic_year)->first();

        $registration_status = (!is_null($registration)) ? $registration->registration_status : 'Not registered';

        return view('Finance.Payments.Create', compact('student', 'academic_year', 'registration_status', 'payable_amount'));
    }

    private function calculatePayableAmount($academic_year, $id)
    {
        return ModuleRegistration::where('student_id', $id)
            ->where('academic_year', $academic_year)
            ->where('registration_status', 'Registered')
            ->sum('amount');
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
        
        $request->validate([
            'payment_amount' => 'required|numeric|min:1',
        ]);
        
        $payment_data = $request->all();
        $payment_data['payment_date'] = date('Y-m-d');
        $payment_data['received_by'] = Auth::user()->id;

        if($request->payment_amount > 0){

            $payment = Payment::create($payment_data);
            
            $this->creditStudentAccount($request, $payment);
            
            Session::flash('message', 'Payment successfully recorded.');
            
        }
        return redirect()->route('payments.show', $request->student_id);
    }

    public function creditStudentAccount($request, $payment){
        $reference_number  = $this->generateInvoiceReferenceNumber();

        if($request->document_type === 'Payment'){
            $line_description = 'Payment - Thank you';
        } else {
            $line_description = 'Credit Memo';
        }

        Invoice::create([
            'student_id' => $request->student_id,
            'reference_number' => $reference_number,
            'model' => "Payment",
            'model_id' => $payment->id,
            'financial_year' => $request->academic_year,
            'transaction_date' => date('Y-m-d'),
            'line_description' => $line_description,
            'debit_amount' => 0,
            'credit_amount' =>  $payment->payment_amount
        ]);
    }

    private function generateInvoiceReferenceNumber()
    {
        $reference_number = rand(10000, 999999);

        $invoice = Invoice::where('reference_number', $reference_number)->first();
        if (count($invoice) > 0) {
            $this->generateInvoiceReferenceNumber();
        }

        return $reference_number;
    }
}
