<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;
class ModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $subjects = Module::all();

        return view('Setup.Subjects.Index', compact('subjects'));
    }

    public function create(){
        return view('Setup.Subjects.Create');
    }

    public function edit($id)
    {
        $subject = Module::find($id);
        return view('Setup.Subjects.Edit', compact('subject'));
    }

    public function store(Request $request){
        Module::create($request->all());

        return redirect()->route('subjects.index');
    }
}
