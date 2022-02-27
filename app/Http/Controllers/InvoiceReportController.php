<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Exports\AgingReport;
use App\Exports\InvoiceReport;
use App\Invoice;
use App\Module;
use App\ModuleRegistration;
use App\Registration;
use App\StudentExtraCharge;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $financial_year = AcademicYear::where('status', 1)->first()->academic_year;

        $academic_years = AcademicYear::pluck('academic_year', 'academic_year');

        $subjects = Module::pluck('subject_name', 'id');

        $invoices = Invoice::where('financial_year', $financial_year)
            ->join('students', 'students.id', '=', 'invoices.student_id')
            ->selectRaw('student_number2, surname, student_names, contact_number, sum(debit_amount) as debit_amount, sum(credit_amount) as credit_amount, sum(debit_amount - credit_amount) as balance')
            ->groupBy('student_id')
            ->paginate(100);


        session()->put('invoices', $invoices);

        return view('Reports.Accounting.Index', compact('invoices', 'academic_years', 'subjects'));
    }

    public function search(Request $request)
    {

        $academic_years = AcademicYear::pluck('academic_year', 'academic_year');
        $subjects = Module::pluck('subject_name', 'id');


        $invoices = Invoice::join('students', 'students.id', '=', 'invoices.student_id')
            ->selectRaw('student_number2, surname, student_names, contact_number, sum(debit_amount) as debit_amount, sum(credit_amount) as credit_amount, sum(debit_amount - credit_amount) as balance')
            ->groupBy('student_id');

        if (isset($request->financial_year)) {
            $invoices = $invoices->where('financial_year', $request->financial_year);
        }

        if (isset($request->fee_type)) {
            if ($request->fee_type === 'Subject') {
                $invoices = $invoices->where('model', 'Module');
            }

            if ($request->fee_type === 'Other') {
                $invoices = $invoices->where('model', 'Fees');
            }
        }

        if (isset($request->subject_id)) {
            $invoices = $invoices->where('model_id', $request->subject_id)
                ->where('model', 'Module');
        }

        $invoices = $invoices->paginate(100);

        session()->put('invoices', $invoices);

        return view('Reports.Accounting.Index', compact('invoices', 'academic_years', 'subjects'));
    }

    public function agingReport(){
        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;
        $registered_students = Registration::with('student')->select('student_id')
                                            ->where('academic_year',$academic_year)
                                            ->where('registration_status', 'Registered')
                                            ->get();
        foreach ($registered_students as $registered_student) {
            $aging_report[$registered_student->student_id] = $this->getAgingReport($registered_student->student_id);
        }

        session()->put('registered_students', $registered_students);
        session()->put('aging_report', $aging_report);

        return view('Reports.Accounting.Aging', compact('registered_students', 'aging_report'));
    }

    public function getAgingReport($student_id)
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

    private function constructAgingReport($aging_busket, $academic_year)
    {
        $aging_report = [
            "30" => 0,
            "60" => 0,
            "90" => 0,
        ];

        if (date('m') == 1) {
            return  $aging_report;
        } else {
            $month = date('m');

            //30 Days
            $_30_days = ($aging_busket[$month - 1]["balance"] > 0) ? $aging_busket[$month - 1]["balance"] : 0;

            //60 Days
            $_60_days = 0;
            if (($month - 2) > 0) {
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

    private function getCreditsPerMonth($student_id, $financial_year)
    {

        return Invoice::selectRaw('month(transaction_date) month, sum(credit_amount) amount')
        ->where('student_id', $student_id)
            ->where('model', '<>', 'Module')
            ->where('financial_year', $financial_year)
            ->groupBy('month')
            ->get();
    }

    private function constuctAgingBusket($number_of_months, $subject_fees, $extra_charges, $credits)
    {
        $aging_busket = [];
        $debit_amount = 0;
        $credit_amount = 0;

        for ($i = 1; $i <= $number_of_months; $i++) {

            $subject_fee = $subject_fees->where('month', $i)->first();
            if ($subject_fee) {
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

    private function getChargedSubjectFees($student_id, $academic_year)
    {

        return ModuleRegistration::selectRaw('month(registration_date) month, sum(amount) amount')
        ->where('student_id', $student_id)
            ->where('academic_year', $academic_year)
            ->groupBy('month')
            ->get();
    }

    private function getChargedExtraFees($student_id, $academic_year)
    {

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

    public function export()
    {
        return Excel::download(new AgingReport, 'Aging_report_' . date('Y-m-d') . '.xlsx');
    }
}