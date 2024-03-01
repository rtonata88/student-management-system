<?php

namespace App\Http\Controllers;

use App\Assessment;
use App\SubjectAllocation;
use App\AssessmentType;
use App\Module;
use Illuminate\Http\Request;
use Auth;
use Session;

class AssessmentController extends Controller
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
        return view('Assessments.Assessments.Index', compact('subjects_allocated'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function showAssessmentTypes($subject_allocation_id)
    {
        $subject_allocation = SubjectAllocation::find($subject_allocation_id);
        $assessment_types = AssessmentType::where('subject_id',$subject_allocation->module_id)
        ->where('academic_year_id',$subject_allocation->academic_year_id)
        ->get();

        return view('Assessments.Assessments.ShowAssessmentTypes', compact('subject_allocation','assessment_types'));
    }


    public function showAssessments($assessment_type_id)
    {
        $assessment_type = AssessmentType::find($assessment_type_id);
        $subject_allocation = SubjectAllocation::where('module_id', $assessment_type->subject_id)
        ->where('academic_year_id', $assessment_type->academic_year_id)
        ->first();
        $assessments = Assessment::where('assessment_type_id', $assessment_type_id)->get();
        return view('Assessments.Assessments.ShowAssessments', compact('assessment_type','subject_allocation','assessments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($assessment_type_id)
    {
        $assessment_type = AssessmentType::find($assessment_type_id);
        $subject_allocation = SubjectAllocation::where('module_id', $assessment_type->subject_id)
        ->where('academic_year_id', $assessment_type->academic_year_id)
        ->first();
        return view('Assessments.Assessments.Create', compact('assessment_type','subject_allocation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //assessment type () -> assessments (100%)
        $assessment_weight = Assessment::where('assessment_type_id', $request->assessment_type)
        ->sum('weight');

        if(($assessment_weight + $request->weight) <= 100 )
        {
            $assessment = new Assessment;
            $assessment->assessment_type_id = $request->assessment_type;
            $assessment->name   = $request->name;
            $assessment->weight = $request->weight;
            $assessment->created_by = Auth::user()->id;
            $assessment->save();

            Session::flash('success','Assessment saved successfully');
            return redirect('assessments/show-assessments/'.$request->assessment_type);
        }
        else
        {
            Session::flash('error','Assessment not saved successfully. Total weight should be equal to 100%');
            return redirect('assessments/show-assessments/'.$request->assessment_type);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function edit($assessment_type_id, $assessment_id)
    {
        $assessment_type = AssessmentType::find($assessment_type_id);
        $subject_allocation = SubjectAllocation::where('module_id', $assessment_type->subject_id)
        ->where('academic_year_id', $assessment_type->academic_year_id)
        ->first();
        $assessment = Assessment::find($assessment_id);
        return view('Assessments.Assessments.Edit', compact('assessment','assessment_type','subject_allocation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //remove the one being edited
        $assessment = Assessment::find($id);

        //assessment type () -> assessments (100%)
        $assessment_weights = Assessment::where('assessment_type_id', $request->assessment_type)
        ->sum('weight');

        if(($assessment_weights - $assessment->weight + $request->weight) <= 100 )
        {
            $assessment->name   = $request->name;
            $assessment->weight = $request->weight;
            $assessment->created_by = Auth::user()->id;
            $assessment->save();

            Session::flash('success','Assessment saved successfully');
            return redirect('assessments/show-assessments/'.$request->assessment_type);
        }
        else
        {
            Session::flash('error','Assessment not saved successfully. Total weight should be equal to 100%');
            return redirect('assessments/show-assessments/'.$request->assessment_type);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
