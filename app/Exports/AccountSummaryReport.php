<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AccountSummaryReport implements FromView
{
    public function view(): View
    {
        return view('Reports.AccountSummary.Export', [
            'registrations' => session()->get('account_summary'),
        ]);
    }
}
