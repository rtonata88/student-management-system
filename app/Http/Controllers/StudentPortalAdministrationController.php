<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentPortalAdministrationController extends Controller
{
    /**
     * Display the Student Portal Administration coming soon page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('student-portal-administration.coming-soon');
    }
}
