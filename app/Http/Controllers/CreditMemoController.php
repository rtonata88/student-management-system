<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\CreditMemo;
use App\Fees;
use App\Invoice;
use App\Module;
use App\Student;
use Illuminate\Http\Request;

use Auth;
use Session;

class CreditMemoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('Finance.CreditMemo.Search');
    }

    public function filter(Request $request)
    {
        if (isset($request->student_number)) {
            $student = Student::where('student_number2', $request->student_number)->first();
            if ($student) {
                return redirect()->route('credit-memos.edit', $student->id);
            }
        }

        if (isset($request->names)) {
            $students = Student::where('surname', 'like', '%' . $request->names . '%')
                                ->orwhere('student_names', 'like', '%' . $request->names . '%')
                                ->get();
            
            if (count($students)) {

                if (count($students) === 1) {
                    return redirect()->route('credit-memos.edit', $students->first()->id);
                } else {
                    return view('Finance.CreditMemo.Search', compact('students'));
                }
            }
        }

        Session::flash('message', 'Student information not found, please make sure you have entered a correct student number.');

        return redirect()->back();
    }

    public function edit($student_id)
    {
        $student = Student::find($student_id);
        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $balance = $this->calculateBalance($academic_year, $student->id);

        $registration = $student->registration->where('academic_year', $academic_year)->first();
        $registration_status = (!is_null($registration)) ? $registration->registration_status : 'Not registered';

        $student_registered_subjects = $student->registered_modules
                                                ->where('registration_status', 'Registered')
                                                ->pluck('module_id');

        $student_extra_charges = $student->extra_charges
            ->pluck('fee_description', 'fee_id');

        $subjects = Module::whereIn('id',$student_registered_subjects)->pluck('subject_name', 'id');

        return view('Finance.CreditMemo.Create', compact('student', 'academic_year', 'registration_status', 'balance', 'subjects', 'student_extra_charges'));
    }

    private function calculateBalance($academic_year, $id)
    {
        $invoices = Invoice::where('student_id', $id)
            ->where('financial_year', $academic_year)
            ->get();

        $balance = 0;

        foreach ($invoices as $invoice) {
            $balance = ($invoice->debit_amount > 0) ? $balance += $invoice->debit_amount : $balance -= $invoice->credit_amount;
        }

        return  $balance;
    }

    public function show($id)
    {
        $student = Student::find($id);

        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $credit_memos = CreditMemo::where('student_id', $id)
            ->whereYear('transaction_date', $academic_year)
            ->get();

        $subjects = Module::select('id', 'subject_name')->get();
        $other_fees = Fees::select('id', 'fee_description')->get();

        return view('Finance.CreditMemo.Show', compact('credit_memos', 'student', 'subjects', 'other_fees'));
    }

    public function print($student_id)
    {
        $student = Student::find($student_id);

        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $credit_memos = CreditMemo::where('student_id', $student_id)
            ->whereYear('transacion_date', $academic_year)
            ->get();

        return view('Finance.CreditMemo.Print', compact('credit_memos', 'student'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'reason' => 'required',
        ]);

        $data = $request->all();
        $data['transaction_date'] = date('Y-m-d');
        $data['captured_by'] = Auth::user()->id;

        if($request->credit_type == 'tuition'){
            $data['model'] = "Subject";
            $data['model_id'] = $request->subject_id;
        } else {
            $data['model'] = "StudentExtraCharge";
            $data['model_id'] = $request->fee_id;
        }

        $credit_memo = CreditMemo::create($data);

        $this->creditStudentAccount($request, $credit_memo);

        Session::flash('message', 'Credit Memo successfully recorded.');

        return redirect()->route('credit-memos.show', $request->student_id);
    }

    public function creditStudentAccount($request, $credit_memo)
    {
        $reference_number  = $this->generateInvoiceReferenceNumber();

        Invoice::create([
            'student_id' => $request->student_id,
            'reference_number' => $reference_number,
            'model' => "CreditMemo",
            'model_id' => $credit_memo->id,
            'financial_year' => $request->academic_year,
            'transaction_date' => date('Y-m-d'),
            'line_description' => 'Credit Memo - '.$request->reason,
            'debit_amount' =>  0,
            'credit_amount' => $credit_memo->amount,
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
