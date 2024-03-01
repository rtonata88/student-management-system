<?php

namespace App\Http\Controllers;

use App\SubjectAllocation;
use Illuminate\Http\Request;

use App\User;
use App\Module;
use App\AcademicYear;
use App\Center;

use Session;

class SubjectAllocationController extends Controller
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
        return view('assessments.subject-allocations.search');
    }

    public function filter(Request $request)
    {
        if(isset($request->name)) 
        {
            $users = User::where('name', 'like' ,'%'.$request->name.'%')->get();
            
            if (count($users)) 
            {
                if (count($users) === 1) 
                {
                    return redirect()->route('subject-allocations.showAllocationScreen', $users->first()->id);
                } else 
                {
                    return view('Assessments.Subject-Allocations.Search', compact('user'));
                }
            }
        }

        if(isset($request->username))
        {
            $users = User::where('username', $request->username)->first();
            if ($users)
            {
                return redirect()->route('subject-allocations.showAllocationScreen', $users->first()->id);
            }
        }

        if(isset($request->email))
        {
            $users = User::where('email', $request->email)->first();
            if ($users)
            {
                return redirect()->route('subject-allocations.showAllocationScreen', $users->first()->id);
            }
        }
        
        Session::flash('error','The entered name does not match any record. Please make sure you have entered a correct name');
        return view('Assessments.Subject-Allocations.Search', compact('users'));
    }

    public function showAllocationScreen($user_id)
    {
        $user = User::find($user_id);
        $subjects = Module::all();
        $academic_years = AcademicYear::all();
        $centers = Center::all();
        $subject_allocations = SubjectAllocation::where('user_id',$user->id)->get();

        return view('Assessments.Subject-Allocations.Index', compact('user', 'subjects','academic_years', 'centers','subject_allocations'));
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
        $request->validate([
            'user_id' => 'required',
            'subject' => 'required',
            'center' => 'required',
            'academic_year' => 'required'
        ]);

        //dd($request->subject);

        //go through each subject submitted and check whether its already allocated
        foreach($request->subject as $subject)
        {
            //check allocation already exists
            $subject_allocations = SubjectAllocation::where('user_id',$request->user_id)
            ->where('module_id',$subject)
            ->where('center_id',$request->center[$subject])
            ->where('academic_year_id',$request->academic_year[$subject])
            ->doesntExist();

            //if it does not exist, then allocate
            if($subject_allocations)
            {
                $allocate_subject                   = new SubjectAllocation;
                $allocate_subject->user_id          = $request->user_id;
                $allocate_subject->module_id        = $subject;
                $allocate_subject->center_id        = $request->center[$subject];
                $allocate_subject->academic_year_id = $request->academic_year[$subject];
                $allocate_subject->save();
            }
            else
            {
                Session::flash('error','Subject allocation was not successful! You cannot allocate duplicates');
                return redirect()->back();
            }

            Session::flash('success','Subject allocation was successful!');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubjectAllocation  $subjectAllocation
     * @return \Illuminate\Http\Response
     */
    public function show(SubjectAllocation $subjectAllocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubjectAllocation  $subjectAllocation
     * @return \Illuminate\Http\Response
     */
    public function edit(SubjectAllocation $subjectAllocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubjectAllocation  $subjectAllocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubjectAllocation $subjectAllocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubjectAllocation  $subjectAllocation
     * @return \Illuminate\Http\Response
     */
    public function unAllocate($id)
    {
        SubjectAllocation::find($id)->delete();
        Session::flash('success','The subject has been successfully un-allocated.');
        return redirect()->back();
    }
}
