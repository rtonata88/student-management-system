<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnrolmentAdjustmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('Management.Enrolment-Adjustment.Search');
    }
}
