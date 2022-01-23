<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Center;
use Session;

class CenterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $centers = Center::all();
        return view('Setup.Centers.Index', compact('centers'));
    }

    public function create()
    {
        return view('Setup.Centers.Create');
    }

    public function edit($id)
    {
        $center = Center::find($id);
        return view('Setup.Centers.Edit', compact('center'));
    }

    public function store(Request $request)
    {
        $center = Center::create($request->all());
        Session::flash('message', 'Center successfully created!');

        return redirect()->route('centers.index');
    }

    public function update(Request $request, $id)
    {
        $center = Center::find($id);
        $center->update($request->all());
        Session::flash('message', 'Center successfully created!');
        return redirect()->route('centers.index');
    }

}
