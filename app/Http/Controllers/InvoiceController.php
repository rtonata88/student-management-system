<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\CompanySetup;
use App\Registration;
use App\Invoice;
use App\Services\StudentBalance;
use App\Services\StudentPayableAmount;
use App\Services\StudentPayableOtherFees;
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
        return view('Finance.Invoice.Search');
    }

    public function filter(Request $request){
        if (isset($request->student_number)) {
            $student = Student::where('student_number2', $request->student_number)->first();
            if ($student) {
                return redirect()->route('invoices.show', $student->id);
            }
        }

        if (isset($request->names)) {
            $students = Student::where('surname', 'like', '%' . $request->names . '%')
                                ->orwhere('student_names', 'like', '%' . $request->names . '%')
                                ->get();
            
            if (count($students)) {
                
                if (count($students) === 1) {
                    
                    return redirect()->route('invoices.show', $students->first()->id);
                } else {
                    
                    return view('Finance.Invoice.Search', compact('students'));
                }
            }
        }

        Session::flash('message', 'Student information not found, please make sure you have entered a correct student number.');

        return redirect()->back();
    }

    public function show($id, StudentPayableAmount $payableAmount, StudentPayableOtherFees $payableOtherFees, StudentBalance $studentBalance)
    {
        $student = Student::find($id);
        
        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;
        
        $invoices = Invoice::where('student_id', $id)
                            ->where('financial_year', $academic_year)
                            ->get();
        
        $student_center = $this->getStudentCenter($academic_year, $student->id);

        $tuition_fees = $payableAmount->calculatePayableAmount($academic_year, $student->id);
        
        $other_fees = $payableOtherFees->calculatePayableOtherFees($academic_year, $student->id);
        
        $payable_amount = $tuition_fees +  $other_fees;

        $course_balance = $studentBalance->calculateBalance($academic_year, $student->id);

        return view('Finance.Invoice.Show', compact('invoices', 'student', 'student_center', 'tuition_fees', 'other_fees', 'course_balance', 'payable_amount'));
    }

    private function getStudentCenter($academic_year, $student_id){

        $enrolment = Registration::where('academic_year',$academic_year)
                                ->where('student_id', $student_id)
                                ->first();
        
        return $enrolment->center;
    }

    public function print($student_id, StudentPayableAmount $payableAmount, StudentPayableOtherFees $payableOtherFees, StudentBalance $studentBalance)
    {
        $student = Student::find($student_id);

        $company = CompanySetup::find(1);

        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $invoices = Invoice::where('student_id', $student_id)
                            ->where('financial_year', $academic_year)
                            ->get();

        $student_center = $this->getStudentCenter($academic_year, $student->id);

        $tuition_fees = $payableAmount->calculatePayableAmount($academic_year, $student->id);

        $other_fees = $payableOtherFees->calculatePayableOtherFees($academic_year, $student->id);

        $payable_amount = $tuition_fees +  $other_fees;

        $course_balance = $studentBalance->calculateBalance($academic_year, $student->id);

        return view('Finance.Invoice.Print', compact('invoices', 'student', 'company', 'student_center', 'tuition_fees', 'other_fees', 'payable_amount', 'course_balance'));
    }

}
