<?php

namespace App\Services;

use App\Invoice;

class StudentBalance {
    
    public function calculateBalance($financial_year, $student_id)
    {

        $invoice = Invoice::select('debit_amount', 'credit_amount')
            ->where('financial_year', $financial_year)
            ->where('student_id', $student_id)
            ->get();

        $balance = $invoice->sum('debit_amount') - $invoice->sum('credit_amount');

        return $balance;
    }
}