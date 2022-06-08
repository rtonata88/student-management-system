<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PaymentsReport implements FromView
{
    public function view(): View
    {
        return view('Reports.Payments.Export', [
            'payments' => session()->get('payments_report'),
            'guardians' => session()->get('guardians'),
            'users' => session()->get('users')
        ]);
    }
}
