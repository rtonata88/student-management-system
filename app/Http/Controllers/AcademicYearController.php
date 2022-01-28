<?php

namespace App\Http\Controllers;

use Session;

use App\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $academic_years = AcademicYear::orderBy('academic_year', 'desc')->get();
        return view('Setup.AcademicYears.Index', compact('academic_years'));
    }

    public function create(){
        return view('Setup.AcademicYears.Create');
    }

    public function edit($id){
        $academic_year = AcademicYear::find($id);

        return view('Setup.AcademicYears.Edit', compact('academic_year'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'academic_year' => 'required|unique:academic_years',
        ]);

        AcademicYear::create($request->all());

        Session::flash('message', 'Academic year successfully created!');

        return redirect()->route('academic-year.index');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'academic_year' => 'required|unique:academic_years',
        ]);

        AcademicYear::find($id)->update($request->all());

        Session::flash('message', 'Academic year successfully updated!');

        return redirect()->route('academic-year.index');
    }

    public function updateStatus($id){
        AcademicYear::where('status', 1)->update(['status' => 0]);
        $academic_year = AcademicYear::find($id);
        
        $academic_year->status = 1;
        $academic_year->save();
        
        Session::flash('message', 'Academic year successfully updated!');

        return redirect()->back();
    }

}
