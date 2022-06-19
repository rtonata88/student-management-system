<?php

namespace App\Services;

use App\CreditMemo;
use App\DebitMemo;
use App\Invoice;
use App\ModuleRegistration;

class StudentPayableAmount {

    public function calculatePayableAmount($academic_year, $id){
        $registered_subjects_payable = $this->payableAmountForRegisteredSubjects($academic_year, $id);

        $canceled_subjects_payable = $this->payableAmountForCanceledSubjects($academic_year, $id);

        $debit_memos = $this->calculateDebitMemos($academic_year, $id);

        $total_payable = $registered_subjects_payable + $canceled_subjects_payable + $debit_memos;

        $payments = $this->calculatePaymentsToDate($id);

        $credit_memos = $this->calculateCreditMemos($academic_year, $id);

        $total_payable = ($total_payable - $payments - $credit_memos);

        return $total_payable;
    }

    private function payableAmountForRegisteredSubjects($academic_year, $id)
    {

        $registered_subjects = ModuleRegistration::select('module_id', 'amount', 'registration_status', 'registration_date', 'cancellation_date')
        ->where('student_id', $id)
            ->where('academic_year', $academic_year)
            ->where('registration_status', 'Registered')
            ->get();

        $payable = 0;

        if ($registered_subjects) {
            foreach ($registered_subjects as $registered_subject) {
                $number_of_months_date = $this->calculateNumberOfMonths($registered_subject->registration_date, date('Y-m-d'));
                $payable += $registered_subject->amount * $number_of_months_date;
            }
        }

        return $payable;
    }

    private function payableAmountForCanceledSubjects($academic_year, $id)
    {

        $cancelled_subjects = ModuleRegistration::select('module_id', 'amount', 'registration_status', 'registration_date', 'cancellation_date')
        ->where('student_id', $id)
            ->where('academic_year', $academic_year)
            ->where('registration_status', 'Canceled')
            ->get();

        $payable = 0;

        if ($cancelled_subjects) {
            foreach ($cancelled_subjects as $cancelled_subject) {
                $number_of_months_date = $this->calculateNumberOfMonths($cancelled_subject->registration_date, $cancelled_subject->cancellation_date);
                $payable += $cancelled_subject->amount * $number_of_months_date;
            }
        }

        return $payable;
    }

    private function calculateDebitMemos($academic_year, $student_id)
    {
        return DebitMemo::where('student_id', $student_id)
            ->whereYear('transaction_date', $academic_year)
            ->sum('amount');
    }

    private function calculatePaymentsToDate($student_id)
    {
        return Invoice::select('credit_amount')
        ->where('model', 'Payment')
        ->where('student_id', $student_id)
            ->whereBetween('transaction_date', [date('Y-01-01'), date('Y-m-d')])
            ->sum('credit_amount');
    }

    private function calculateCreditMemos($academic_year, $student_id)
    {
        return CreditMemo::where('student_id', $student_id)
            ->whereYear('transaction_date', $academic_year)
            ->sum('amount');
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