<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(){
        return view('appointments.index');
    }

    public function create(){
        return redirect()->away('https://calendar.google.com/calendar/u/0/r');
    }
}
