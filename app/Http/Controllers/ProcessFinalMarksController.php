<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProcessFinalMarksController extends Controller
{
    /**
     * Display the Process Final Marks coming soon page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Assessments.process-final-marks.index');
    }
}
