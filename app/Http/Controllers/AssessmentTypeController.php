<?php

namespace App\Http\Controllers;

use App\SubjectAllocation;
use App\AssessmentType;
use App\Module;
use Illuminate\Http\Request;
use Auth;
use Session;

class AssessmentTypeController extends Controller
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

    //a list of subjects allocated to user
    public function index()
    {
        $user = Auth::user();
        $subjects_allocated = SubjectAllocation::where('user_id', $user->id)->groupBy('module_id','academic_year_id')->get();
        return view('Assessments.Assessment-Types.Index', compact('subjects_allocated'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //then a list of assessments for that subject allocated to user
    public function showAssessmentTypes($subject_allocation_id)
    {
        $subject_allocation = SubjectAllocation::find($subject_allocation_id);
        $subject = Module::find($subject_allocation->module_id);

        $assessment_types = AssessmentType::where('subject_id',$subject->id)
        ->where('academic_year_id',$subject_allocation->academic_year_id)
        ->get();

        return view('Assessments.Assessment-Types.ShowAssessmentTypes', compact('subject_allocation','assessment_types'));
    }

    //create
    public function create($subject_allocation)
    {   
        $subject_allocation = SubjectAllocation::find($subject_allocation);
        return view('Assessments.Assessment-Types.Create', compact('subject_allocation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subject_allocation = SubjectAllocation::find($request->subject_allocation_id);
        $subject = Module::find($subject_allocation->module_id);

        //calc to make sure assessment types add upto 100%
        $assessment_types_weight = AssessmentType::where('subject_id', $subject->id)
        ->where('academic_year_id',$subject_allocation->academic_year_id)
        ->sum('weight');

        if(($assessment_types_weight + $request->weight) <= 100 )
        {
            $assessment_type = new AssessmentType;
            $assessment_type->name  = $request->name;
            $assessment_type->weight  = $request->weight;
            $assessment_type->subject_id  = $subject->id;
            $assessment_type->academic_year_id  = $subject_allocation->academic_year_id;
            $assessment_type->created_by  = Auth::user()->id;
            $assessment_type->save();

            Session::flash('success','Assessment type saved successfully');
            return redirect('assessment-types/'.$subject_allocation->id);
        }
        else
        {
            Session::flash('error','Assessment type not saved successfully. Total weight should be equal to 100%');
            return redirect('assessment-types/'.$subject_allocation->id);
        }
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\AssessmentType  $assessmentType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AssessmentType  $assessmentType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $assessment_type = AssessmentType::find($id);
        return view('Assessments.Assessment-Types.Edit', compact('assessment_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AssessmentType  $assessmentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //calc to make sure assessment types add upto 100%
        $assessment_type = AssessmentType::find($id);

        $assessment_types_weight = AssessmentType::where('subject_id', $assessment_type->subject_id)
        ->where('academic_year_id',$assessment_type->academic_year_id)
        ->sum('weight');

        if(($assessment_types_weight - $assessment_type->weight + $request->weight) <= 100 )
        {
            // $assessment_type = new AssessmentType;
            $assessment_type->name  = $request->name;
            $assessment_type->weight  = $request->weight;
            $assessment_type->created_by  = Auth::user()->id;
            $assessment_type->save();

            Session::flash('success','Assessment type saved successfully');
            return redirect('assessment-types/'.$subject_allocation->id);
        }
        else
        {
            Session::flash('error','Assessment type not saved successfully. Total weight should be equal to 100%');
            return redirect('assessment-types/'.$subject_allocation->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AssessmentType  $assessmentType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
