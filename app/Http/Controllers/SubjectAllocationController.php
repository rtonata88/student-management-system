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
     */
    public function index()
    {
        return view('Assessments.Subject-Allocations.search');
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
                    return view('Assessments.Subject-Allocations.Search', compact('users'));
                }
            }
        }

        if(isset($request->username))
        {
            $users = User::where('username', $request->username)->first();
            if ($users)
            {
                return redirect()->route('subject-allocations.showAllocationScreen', $users->id);
            }
        }

        if(isset($request->email))
        {
            $users = User::where('email', $request->email)->first();
            if ($users)
            {
                return redirect()->route('subject-allocations.showAllocationScreen', $users->id);
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'subject' => 'required',
            'center' => 'required',
            'academic_year' => 'required'
        ]);

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
        }
        
        Session::flash('success','Subject allocation was successful!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function unAllocate($id)
    {
        SubjectAllocation::find($id)->delete();
        Session::flash('success','The subject has been successfully un-allocated.');
        return redirect()->back();
    }
}