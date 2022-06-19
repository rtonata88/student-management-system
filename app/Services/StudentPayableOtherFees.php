<?php 

namespace App\Services;

use App\StudentExtraCharge;

class StudentPayableOtherFees {
    
    public function calculatePayableOtherFees($academic_year, $id, $debit_memos, $credit_memos)
    {
       
        $extra_fees = $this->getChargedExtraFees($id, $academic_year);

        $charged = $extra_fees->sum('amount');

        $paid = $extra_fees->sum('amount_paid');
        
        return ($charged + $debit_memos) - ($paid + $credit_memos);
    }

    private function getChargedExtraFees($student_id, $academic_year)
    {
        return StudentExtraCharge::whereYear('transaction_date', $academic_year)
                                ->where('student_id', $student_id)
                                ->get();
    }
}