<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Registration;
use App\ModuleRegistration;
use App\AssessmentMark;
use App\Assessment;
use App\SubjectAllocation;
use App\AssessmentType;
use App\Module;
use Auth;
use Session;


class AssessmentMarkController extends Controller
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
        $subjects_allocated = SubjectAllocation::where('user_id', Auth::user()->id)->get();
        return view('Assessments.Enter-Marks.Index', compact('subjects_allocated'));
    }

    public function showAssessments($subjects_allocation_id)
    {
        $subjects_allocated = SubjectAllocation::find($subjects_allocation_id);
        $assessment_types = AssessmentType::where('subject_id', $subjects_allocated->module_id)
        ->where('academic_year_id', $subjects_allocated->academic_year_id)
        ->get();
        return view('Assessments.Enter-Marks.showAssessments', compact('assessment_types','subjects_allocated'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($assessment_id)
    {
        $user = Auth::user();
        $assessment = Assessment::find($assessment_id);
        $assessment_type = AssessmentType::find($assessment->assessment_type_id);
        
        // Fetch subject allocation with eager loading of academic year
        $subjects_allocated = SubjectAllocation::with('academicYear')
        ->where('user_id', $user->id)
        ->where('module_id',$assessment_type->subject_id)
        ->where('academic_year_id', $assessment_type->academic_year_id)
        ->first();

        // Fetch registered student IDs within the academic year and center
        $registeredStudents = Registration::where('center_id', $subjects_allocated->center_id)
            ->where('academic_year', $subjects_allocated->academicYear->academic_year)
            ->where('registration_status', 'Registered')
            ->pluck('student_id');

        // Fetch module registrations for registered students within the academic year
        $registered_students = ModuleRegistration::where('module_id', $subjects_allocated->module_id)
            ->where('academic_year', $subjects_allocated->academicYear->academic_year)
            ->whereIn('student_id', $registeredStudents)
            ->get();

        return view('Assessments.Enter-Marks.Create', compact('assessment','assessment_type','subjects_allocated','registered_students'));
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
     * @param  \App\AssessmentMark  $assessmentMark
     * @return \Illuminate\Http\Response
     */
    public function show(AssessmentMark $assessmentMark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AssessmentMark  $assessmentMark
     * @return \Illuminate\Http\Response
     */
    public function edit(AssessmentMark $assessmentMark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AssessmentMark  $assessmentMark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssessmentMark $assessmentMark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AssessmentMark  $assessmentMark
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssessmentMark $assessmentMark)
    {
        //
    }
}
