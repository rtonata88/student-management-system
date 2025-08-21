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

    //a list of assessment types
    public function index(Request $request)
    {
        // Check if user has permission to view assessments
        if (!Auth::user()->hasPermission('assessments')) {
            abort(403, 'Unauthorized access to assessment types.');
        }
        
        $search = $request->get('search');
        
        $assessmentTypes = AssessmentType::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
        })
        ->orderBy('name')
        ->paginate(10);

        return view('Assessments.Assessments.Index', compact('assessmentTypes', 'search'));
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
    public function create()
    {   
        // Check if user has permission to add assessment types
        if (!Auth::user()->hasPermission('add-assessment-types')) {
            abort(403, 'Unauthorized access to create assessment types.');
        }
        
        return view('Assessments.Assessments.Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check if user has permission to add assessment types
        if (!Auth::user()->hasPermission('add-assessment-types')) {
            abort(403, 'Unauthorized access to create assessment types.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:assessment_types,code',
            'mark_cap' => 'required|numeric|min:0|max:100',
            'active' => 'boolean'
        ]);

        AssessmentType::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'mark_cap' => $request->mark_cap,
            'active' => $request->has('active')
        ]);

        Session::flash('success', 'Assessment type created successfully');
        return redirect()->route('assessments.index');
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
        // Check if user has permission to edit assessment types
        if (!Auth::user()->hasPermission('edit-assessment-types')) {
            abort(403, 'Unauthorized access to edit assessment types.');
        }
        
        $assessmentType = AssessmentType::findOrFail($id);
        return view('Assessments.Assessments.Edit', compact('assessmentType'));
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
        // Check if user has permission to edit assessment types
        if (!Auth::user()->hasPermission('edit-assessment-types')) {
            abort(403, 'Unauthorized access to update assessment types.');
        }
        
        $assessmentType = AssessmentType::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:assessment_types,code,' . $id,
            'mark_cap' => 'required|numeric|min:0|max:100',
            'active' => 'boolean'
        ]);

        $assessmentType->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'mark_cap' => $request->mark_cap,
            'active' => $request->has('active')
        ]);

        Session::flash('success', 'Assessment type updated successfully');
        return redirect()->route('assessments.index');
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
