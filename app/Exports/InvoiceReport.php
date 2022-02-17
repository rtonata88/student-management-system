<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InvoiceReport implements FromView
{
    public function view(): View
    {
        return view('Reports.Accounting.Export', [
            'invoices' => session()->get('invoices')
        ]);
    }
}
