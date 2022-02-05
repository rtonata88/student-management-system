<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\CompanySetup;
use App\Invoice;
use App\Student;
use Session;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('Finance.Invoice.Index');
    }

    public function filter(Request $request){
        $student = Student::where('student_number', $request->student_number)->first();

        if($student) {
            return redirect()->route('invoices.show', $student->id);
        }

        Session::flash('message', 'Student information not found, please make sure you have entered a correct student number.');

        return redirect()->back();
    }

    public function show($id)
    {
        $student = Student::find($id);
        
        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;
        
        $invoices = Invoice::where('student_id', $id)
                            ->where('financial_year', $academic_year)
                            ->get();
        
        return view('Finance.Invoice.Show', compact('invoices', 'student'));
    }

    public function print($student_id){
        $student = Student::find($student_id);
        $company = CompanySetup::find(1);

        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $invoices = Invoice::where('student_id', $student_id)
            ->where('financial_year', $academic_year)
            ->get();

        return view('Finance.Invoice.Print', compact('invoices', 'student', 'company'));
    }
}
