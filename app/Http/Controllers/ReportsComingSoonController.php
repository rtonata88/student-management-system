<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsComingSoonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($report)
    {
        // Convert kebab-case to title case for display
        $reportTitle = ucwords(str_replace('-', ' ', $report));
        
        return view('reports.coming-soon', compact('reportTitle', 'report'));
    }
}
