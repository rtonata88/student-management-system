<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SubjectRegistration implements FromView
{
    public function view(): View
    {
        return view('Reports.Students.Export', [
            'subject_registration' => session()->get('subject_registration')
        ]);
    }
}
