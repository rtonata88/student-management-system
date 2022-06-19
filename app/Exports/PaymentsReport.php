<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PaymentsReport implements FromView
{
    use Exportable;
    
    public function view(): View
    {
        return view('Reports.Payments.Export', [
            'payments' => session()->get('payments_report'),
            'guardians' => session()->get('guardians'),
            'users' => session()->get('users')
        ]);
    }
}
