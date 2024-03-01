<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SubjectAllocation;
use App\AcademicYear;
use App\Registration;
use App\ModuleRegistration;

use Auth;
use Session;

class ClassListController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $class_lists = SubjectAllocation::where('user_id', $user->id)->get();
        return view('Assessments.Class-List.Index', compact('class_lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Fetch subject allocation with eager loading of academic year
        $classList = SubjectAllocation::with('academicYear')->find($id);

        // Fetch registered student IDs within the academic year and center
        $registeredStudents = Registration::where('center_id', $classList->center_id)
            ->where('academic_year', $classList->academicYear->academic_year)
            ->where('registration_status', 'Registered')
            ->pluck('student_id');

        // Fetch module registrations for registered students within the academic year
        $registered_students = ModuleRegistration::where('module_id', $classList->module_id)
            ->where('academic_year', $classList->academicYear->academic_year)
            ->whereIn('student_id', $registeredStudents)
            ->get();

        //dd($registered_students);

        return view('Assessments.Class-List.View', compact('registered_students'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
