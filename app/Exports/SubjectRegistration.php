<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SubjectRegistration implements FromView
{
    use Exportable;

    public function view(): View
    {
        return view('Reports.Students.Export', [
            'subject_registration' => session()->get('subject_registration')
        ]);
    }
}
