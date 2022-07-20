<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AcademicYear;
use App\Center;
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

        if (isset($request->names)) {
            $students = Student::with('currentRegistration')->where('surname', 'like', '%' . $request->names . '%')
                                        ->orwhere('student_names', 'like', '%' . $request->names . '%')
                                        ->get();

            if (count($students)) {
                if (count($students) === 1) {
                    return redirect()->route('cancellation.showCancellationScreen', $students->first()->id);
                } else {
                    return view('Management.Cancel.Search', compact('students'));
                }
            }
        }

        Session::flash('not_found', 'The entered student number does not match any record. Please make sure you have entered a correct student number');

        return view('Management.Cancel.Search');
    }

    public function showCancellationScreen($student_id)
    {
        $student = Student::find($student_id);

        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;
        $centers = Center::pluck('center_name', 'id');
        $registration = $student->registration->where('academic_year', $academic_year)->first();
        $registration_status = (!is_null($registration)) ? $registration->registration_status : 'Not registered';

        $subjects = ModuleRegistration::with('subject')->where('student_id', $student->id)
            ->where('academic_year', $academic_year)
            ->get();


        $invoice = Invoice::select('model_id', 'debit_amount')->where('model', 'Module')
                            ->where('student_id', $student->id)
                            ->where('financial_year', $academic_year)
                            ->get();

        return view('Management.Cancel.Index', compact('student', 'subjects', 'invoice', 'academic_year', 'centers', 'registration_status', 'registered_modules'));
    }

    public function edit($id)
    {

        $subject = ModuleRegistration::find($id);

        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $invoice = Invoice::select('model_id', 'debit_amount')->where('model', 'Module')
                            ->where('student_id', $subject->student_id)
                            ->where('financial_year', $academic_year)
                            ->get();

        return view('Management.Cancel.Edit', compact('subject', 'invoice', 'academic_year'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'cancelation_reason' => 'required',
        ]);

        $module_registration = ModuleRegistration::find($id);

        $academic_year = AcademicYear::where('academic_year', $request->academic_year)->first();

        if ($academic_year->status == 0) {
            return redirect()->back()->with('message', 'The Academic Year is not active');
        }

        if (($request->cancellation_date < $academic_year->start_date) || ($request->cancellation_date > $academic_year->end_date)) {
            return redirect()->back()->with('message', 'Cancellation date must be between the academic period.');
        }

        if (($request->cancellation_date < $module_registration->registration_date)) {
            return redirect()->back()->with('message', 'Cancellation date cannot be less than registration date of the module.');
        }

        ModuleRegistration::where('id', $id)
                            ->update([
                                'cancellation_date' => $request->cancellation_date,
                                'cancellation_reason' => $request->cancelation_reason,
                                'registration_status' => 'Canceled'
                            ]);

        Invoice::where('student_id', $request->student_id)
            ->where('model', 'Module')
            ->where('model_id', $request->module_id)
            ->where('debit_amount', '<=', 0)
            ->where('financial_year', $request->academic_year)
            ->delete();

        //$this->cancelStudentEnrolment($academic_year, $request);

        $reference_number = $this->generateInvoiceReferenceNumber();

        $this->creditModuleFees($academic_year, $reference_number, $request, $module_registration);

        return redirect()->route('cancellation.showCancellationScreen', $request->student_id);
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
                            'cancellation_date' => $request->cancelation_date,
                            'cancellation_reason' => $request->cancelation_reason,
                            'registration_status' => 'Canceled']);
        }

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

    private function creditModuleFees($academic_year, $reference_number, $request, $module_registration)
    {
       return Invoice::create([
            'student_id' => $request->student_id,
            'reference_number' => $reference_number,
            'model' => "Module",
            'model_id' => $request->module_id,
            'financial_year' => $academic_year->academic_year,
            'transaction_date' => $request->cancellation_date,
            'line_description' => 'CANCEL'.' - '.$request->subject,
            'debit_amount' => 0,
            'credit_amount' => $this->calculateAmount(
                $academic_year,
                $module_registration->amount,
                $request->cancellation_date
            ),
        ]);
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
                    $module_registration->amount,
                    date('Y-m-d')
                ),
                'credit_amount' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );

        Invoice::insert($invoices);
    }

    private function calculateAmount($year, $subject_fee, $start_date)
    {

        $number_of_months = $this->calculateNumberOfMonths($start_date, $year->end_date) + 1;

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
