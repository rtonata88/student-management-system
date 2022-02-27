<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AcademicYear;
use App\Student;
use App\Invoice;
use App\Module;
use App\ModuleRegistration;
use App\Registration;

use Session;

class CancelRegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('Management.Cancel.Search');
    }

    public function filter(Request $request)
    {

        if (isset($request->student_number)) {
            $student = Student::with('currentRegistration')->where('student_number2', $request->student_number)->first();
            if ($student) {
                return redirect()->route('cancellation.showCancellationScreen', $student->id);
            }
        }

        if (isset($request->surname)) {
            $students = Student::with('currentRegistration')->where('surname', 'like', '%' . $request->surname . '%')->get();

            if (count($students)) {
                if (count($students) === 1) {
                    return redirect()->route('cancellation.showCancellationScreen', $students->first()->id);
                } else {
                    return view('Management.Cancel.Search', compact('students'));
                }
            }
        }

        Session::flash('not_found', 'The entered student number does not match any record. Please make sure you have entered a correct student number');

        return view('Management.Enrolment.Search', compact('student'));
    }

    public function showCancellationScreen($student_id)
    {
        $student = Student::find($student_id);

        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $charged_fees = Invoice::where('model', 'Fees')
            ->where('student_id', $student->id)
            ->where('financial_year', $academic_year)
            ->get();

        return view('Management.Cancel.Index', compact('student', 'academic_year', 'charged_fees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cancelation_reason' => 'required',
        ]);
        
        $academic_year = AcademicYear::where('status', 1)->first();

        ModuleRegistration::whereIn('module_id', $request->subject)
                            ->where('student_id', $request->student_id)
                            ->where('academic_year', $academic_year->academic_year)
                            ->update([
                                'cancellation_date' => date('Y-m-d'),
                                'cancellation_reason' => $request->cancelation_reason,
                                'registration_status' => 'Canceled'
                            ]);

        
        $this->cancelStudentEnrolment($academic_year, $request);

        $reference_number = $this->generateInvoiceReferenceNumber();

        $this->creditModuleFees($academic_year, $reference_number, $request);

        return redirect()->route('invoices.show', $request->student_id);
    }

    private function cancelStudentEnrolment($academic_year, $request){
        $registered_modules = ModuleRegistration::where('student_id', $request->student_id)
                                                ->where('academic_year', $academic_year->academic_year)
                                                ->whereNotNull('cancellation_date')
                                                ->get();
        
        if(count($registered_modules) == 0){
            Registration::where('student_id', $request->student_id)
                        ->where('academic_year', $academic_year->academic_year)
                        ->update([
                            'cancellation_date' => date('Y-m-d'),
                            'cancellation_reason' => $request->cancelation_reason,
                            'registration_status' => 'Canceled']);
        }

    }

    private function generateInvoiceReferenceNumber()
    {
        $reference_number = rand(100000, 999999);

        $invoice = Invoice::where('reference_number', $reference_number)->first();
        if (count($invoice) > 0) {
            $this->generateInvoiceReferenceNumber();
        }

        return $reference_number;
    }

    private function creditModuleFees($academic_year, $reference_number, $request)
    {
        $invoices = [];
        
        $subjects = Module::whereIn('id', $request->subject)->get();
        
        for ($i = 0; $i < count($request->subject); $i++) {
            array_push(
                $invoices,
                [
                    'student_id' => $request->student_id,
                    'reference_number' => $reference_number,
                    'model' => "Module",
                    'model_id' => $request->subject[$i],
                    'financial_year' => $academic_year->academic_year,
                    'transaction_date' => date('Y-m-d'),
                    'line_description' => 'CANCEL'.' - '.$subjects->where('id', $request->subject[$i])->first()->subject_name,
                    'debit_amount' => 0,
                    'credit_amount' => $this->calculateAmount(
                        $academic_year,
                        $subjects->where('id', $request->subject[$i])
                            ->first()
                            ->subject_fees
                    ),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );
        }

        Invoice::insert($invoices);

    }

    public function removeCancellation($student_id, $module_id){

        $subject = Module::where('id', $module_id)->first();

        $module_registration = ModuleRegistration::where('student_id', $student_id)
                                                    ->where('module_id', $module_id)
                                                    ->first();


        $module_registration->registration_status = 'Registered';
        $module_registration->cancellation_reason = null;
        $module_registration->cancellation_date = null;
        $module_registration->save();

        Registration::where('student_id', $student_id)
                    ->where('academic_year',date('Y'))
                    ->update(['registration_status' => 'Registered', 
                                'cancellation_reason' => null, 
                                'cancellation_date' => null]);    


        $this->debitStudentAccount($module_registration);

        Session::flash('message', 'Subject cancellation successfuly removed.');

        return redirect()->back();
    }

    private function debitStudentAccount($module_registration){
        $academic_year = AcademicYear::where('status', 1)->first();

        $reference_number = $this->generateInvoiceReferenceNumber();

        $subject = Module::find($module_registration->module_id);

         $invoices = [];
        array_push(
            $invoices,
            [
                'student_id' => $module_registration->student_id,
                'reference_number' => $reference_number,
                'model' => "Module",
                'model_id' => $module_registration->module_id,
                'financial_year' => $academic_year->academic_year,
                'transaction_date' => date('Y-m-d'),
                'line_description' => $subject->subject_name,
                'debit_amount' => $this->calculateAmount(
                    $academic_year,
                    $module_registration->amount
                ),
                'credit_amount' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );

        Invoice::insert($invoices);
    }

    private function calculateAmount($year, $subject_fee)
    {

        $number_of_months = $this->calculateNumberOfMonths(date('Y-m-d'), $year->end_date);

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

        return (($year2 - $year1) * 12) + ($month2 - $month1);
    }
}
