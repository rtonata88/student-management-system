<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AgingReport implements FromView
{
    public function view(): View
    {
        return view('Reports.Accounting.AgingExport', [
            'registered_students' => session()->get('registered_students'),
            'aging_report' =>session()->get('aging_report'),
        ]);
    }
}
