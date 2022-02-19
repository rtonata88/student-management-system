<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\CompanySetup;
use App\Registration;
use App\Invoice;
use App\ModuleRegistration;
use App\Student;
use App\StudentExtraCharge;
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

        if (isset($request->surname)) {
            $students = Student::where('surname', 'like', '%' . $request->surname . '%')->get();
            
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

    public function show($id)
    {
        $student = Student::find($id);

        $aging_report = $this->agingReport($id);
        
        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;
        
        $invoices = Invoice::where('student_id', $id)
                            ->where('financial_year', $academic_year)
                            ->get();
        
        $student_center = $this->getStudentCenter($academic_year, $student->id);

        return view('Finance.Invoice.Show', compact('invoices', 'student', 'student_center', 'aging_report'));
    }

    private function getStudentCenter($academic_year, $student_id){

        $enrolment = Registration::where('academic_year',$academic_year)
                                ->where('student_id', $student_id)
                                ->first();
        
        return $enrolment->center;
    }

    public function print($student_id){
        $student = Student::find($student_id);

        $aging_report = $this->agingReport($student_id);

        $company = CompanySetup::find(1);

        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $invoices = Invoice::where('student_id', $student_id)
            ->where('financial_year', $academic_year)
            ->get();

            $student_center = $this->getStudentCenter($academic_year, $student->id);

        return view('Finance.Invoice.Print', compact('invoices', 'student', 'company', 'student_center', 'aging_report'));
    }

    public function agingReport($student_id)
    {
        $academic_year = AcademicYear::where('status', 1)->first();

        $number_of_months = $this->calculateNumberOfMonths($academic_year->start_date, $academic_year->end_date);

        $subject_fees = $this->getChargedSubjectFees($student_id, $academic_year->academic_year);

        $extra_charges = $this->getChargedExtraFees($student_id, $academic_year->academic_year);

        $credits = $this->getCreditsPerMonth($student_id, $academic_year->academic_year);

        $aging_busket = $this->constuctAgingBusket($number_of_months, $subject_fees, $extra_charges, $credits);

        $aging_report = $this->constructAgingReport($aging_busket, $academic_year);
        
        return $aging_report;
    }

    private function constructAgingReport($aging_busket, $academic_year){
        $aging_report = [
            "30" => 0,
            "60" => 0,
            "90" => 0,
        ];

        if(date('m') == 1){
            return  $aging_report;
        } else {
            $month = date('m');

            //30 Days
            $_30_days = ($aging_busket[$month - 1]["balance"] > 0) ? $aging_busket[$month - 1]["balance"] : 0;

            //60 Days
            $_60_days = 0;
            if(($month - 2) > 0){
                $balance = $aging_busket[$month]["balance"] + $aging_busket[$month - 2]["balance"];
                $_60_days = ($balance > 0) ? $balance : 0;
            }
            
            //90 Days
            $_90_days = 0;
            if (($month - 3) > 0) {
                for ($i = intval($month); $i > 0; $i--) {
                    $_90_days += $aging_busket[$i]["balance"];
                }
            }
           
            $aging_report = [
                "30" => $_30_days,
                "60" => $_60_days,
                "90" => $_90_days,
            ];
        }
        
        return $aging_report;
    }

    private function getCreditsPerMonth($student_id, $financial_year){

        return Invoice::selectRaw('month(transaction_date) month, sum(credit_amount) amount')
                                ->where('student_id', $student_id)
                                ->where('model', '<>','Module')
                                ->where('financial_year', $financial_year)
                                ->groupBy('month')
                                ->get();
    }

    private function constuctAgingBusket($number_of_months, $subject_fees, $extra_charges, $credits){
        $aging_busket = [];
        $debit_amount = 0;
        $credit_amount = 0;

        for ($i = 1; $i <= $number_of_months; $i++) {
            
            $subject_fee = $subject_fees->where('month', $i)->first();
            if($subject_fee){
                $debit_amount += $subject_fee->amount;
            }

            $credit_amount = ($credits->where('month', $i)->first()) ? $credits->where('month', $i)->first()->amount : 0;

            $aging_busket[$i] = [
                "debit" => $debit_amount,
                "credit" => $credit_amount,
            ];
        }

        $debit_amount = 0;
        foreach ($subject_fees as $subject_fee) {
            $debit_amount += $subject_fee->amount;
            $aging_busket[$subject_fee->month]["debit"] = $debit_amount;
        }

        foreach ($extra_charges as $extra_charge) {
            $aging_busket[$extra_charge->month]["debit"] += $extra_charge->amount;
        }

        for ($i = 1; $i <= $number_of_months; $i++) {
            $aging_busket[$i]["balance"] = $aging_busket[$i]["debit"] - $aging_busket[$i]["credit"];
        }

        return $aging_busket;
    }

    private function getChargedSubjectFees($student_id, $academic_year){

        return ModuleRegistration::selectRaw('month(registration_date) month, sum(amount) amount')
                                ->where('student_id', $student_id)
                                ->where('academic_year', $academic_year)
                                ->groupBy('month')
                                ->get();
    }

    private function getChargedExtraFees($student_id, $academic_year){
        
        return StudentExtraCharge::selectRaw('month(transaction_date) month, sum(amount) amount')
                                    ->where('student_id', $student_id)
                                    ->whereYear('transaction_date', $academic_year)
                                    ->groupBy('month')
                                    ->get();
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
