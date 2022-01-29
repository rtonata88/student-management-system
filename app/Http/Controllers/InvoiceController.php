<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;
        
        $invoices = Invoice::where('student_id', $id)
                            ->where('academic_year', $academic_year)
                            ->get();
        
        return view('Finance.Invoice.Show', compact('invoices'));
    }
}
