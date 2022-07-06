<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Center;
use App\EducationSystem;
use App\Fees;
use App\Invoice;
use App\Module;
use App\ModuleRegistration;
use App\Student;
use Illuminate\Http\Request;

use Session;

class EnrolmentAdjustmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('Management.Enrolment-Adjustment.Search');
    }

    public function filter(Request $request)
    {

        if (isset($request->student_number)) {
            $student = Student::where('student_number2', $request->student_number)->first();
            if ($student) {
                return redirect()->route('enrolment.adjustment.showScreen', $student->id);
            }
        }

        if (isset($request->names)) {
            $students = Student::where('surname', 'like', '%' . $request->names . '%')
                ->orwhere('student_names', 'like', '%' . $request->names . '%')
                ->get();

            if (count($students)) {
                if (count($students) === 1) {
                    return redirect()->route('enrolment.adjustment.showScreen', $students->first()->id);
                } else {
                    return view('Management.Enrolment-Adjustment.Search', compact('students'));
                }
            }
        }

        Session::flash('not_found', 'The entered student number does not match any record. Please make sure you have entered a correct student number');

        return view('Management.Enrolment-Adjustment.Search', compact('students'));
    }

    public function showEnrollmentScreen($student_id)
    {
        $student = Student::find($student_id);

        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;
        $centers = Center::pluck('center_name', 'id');
        $registration = $student->registration->where('academic_year', $academic_year)->first();
        $registration_status = (!is_null($registration)) ? $registration->registration_status : 'Not registered';

        $subjects = ModuleRegistration::with('subject')->where('student_id', $student->id)
                                    ->where('academic_year', $academic_year)
                                    ->get();


        $invoice = Invoice::select('model_id','debit_amount')->where('model', 'Module')
            ->where('student_id', $student->id)
            ->where('financial_year', $academic_year)
            ->get();


        return view('Management.Enrolment-Adjustment.Index', compact('student', 'subjects', 'invoice', 'academic_year', 'centers', 'registration_status', 'registered_modules'));
    }

    public function edit($id){
        
        $subject = ModuleRegistration::find($id);

        if(!is_null($subject->cancellation_date)){
            return redirect()->back()->with('message', 'Cancelled subjects cannot be modified.');
        }

        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $invoice = Invoice::select('model_id', 'debit_amount')->where('model', 'Module')
            ->where('student_id', $subject->student_id)
            ->where('financial_year', $academic_year)
            ->get();

        return view('Management.Enrolment-Adjustment.Edit', compact('subject', 'invoice', 'academic_year'));
    }

    public function store(Request $request){
        $academic_year = AcademicYear::where('academic_year', $request->academic_year)->first();

        if($academic_year->status == 0){
            return redirect()->back()->with('message', 'The Academic Year is in active');
        }
        
        if(($request->registration_date < $academic_year->start_date) || ($request->registration_date > $academic_year->end_date)){
            return redirect()->back()->with('message', 'Registration must be between the academic period.');
        }

        ModuleRegistration::where('id',$request->module_registration_id)
                            ->update(['registration_date' => $request->registration_date]);
        
        Invoice::where('student_id', $request->student_id)
                ->where('model_id', $request->module_id)
                ->where('financial_year', $request->academic_year)
                ->delete();

        $reference_number = $this->generateInvoiceReferenceNumber();

        Invoice::create([
            'student_id' => $request->student_id,
            'reference_number' => $reference_number,
            'model' => "Module",
            'model_id' => $request->module_id,
            'financial_year' => $request->academic_year,
            'transaction_date' =>  $request->registration_date,
            'line_description' => $request->subject,
            'debit_amount' => $this->calculateAmount(
                $academic_year,
                $request->amount,
                $request->registration_date
            ),
            'credit_amount' => 0        
        ]);

        return redirect()->route('enrolment.adjustment.showScreen', $request->student_id)->with('message', 'Module successfully adjusted!');
        
    }

    private function generateInvoiceReferenceNumber()
    {
        $reference_number = rand(100000, 999999);

        $invoice = Invoice::where('reference_number', $reference_number)->first();
        if ($invoice) {
            $this->generateInvoiceReferenceNumber();
        }

        return $reference_number;
    }

    private function calculateAmount($year, $subject_fee, $registration_date)
    {

        $number_of_months = $this->calculateNumberOfMonths($registration_date, $year->end_date);

        $amount = $number_of_months * $subject_fee;

        return $amount;
    }

    private function calculateNumberOfMonths($start_date, $end_date)
    {
        $ts1 = strtotime($start_date);
        $ts2 = strtotime($end_date);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        return (($year2 - $year1) * 12) + ($month2 - $month1) + 1;
    }

}
