<?php

namespace App\Http\Controllers;

use App\SubjectAllocation;
use Illuminate\Http\Request;

use App\User;
use App\Module;
use App\AcademicYear;
use App\Center;

use Session;

class ModuleAllocationController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
        $this->middleware('permission:view-module-allocations', ['only' => ['index']]);
        $this->middleware('permission:create-module-allocations', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-module-allocations', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-module-allocations', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allocations = SubjectAllocation::with(['module', 'academicYear', 'center'])
            ->join('users', 'subject_allocations.user_id', '=', 'users.id')
            ->select('subject_allocations.*', 'users.name as teacher_name')
            ->paginate(15);
            
        return view('ModuleAllocations.index', compact('allocations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = Module::all();
        $academicYears = AcademicYear::all();
        $centers = Center::all();
        $teachers = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['Teacher', 'Lecturer', 'Instructor']);
        })->orWhereDoesntHave('roles')->get();
        
        return view('ModuleAllocations.create', compact('modules', 'academicYears', 'centers', 'teachers'));
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'module_id' => 'required|exists:modules,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'center_id' => 'required|exists:centers,id'
        ]);

        // Check if allocation already exists
        $existingAllocation = SubjectAllocation::where('user_id', $request->teacher_id)
            ->where('subject_id', $request->module_id)
            ->where('center_id', $request->center_id)
            ->where('academic_year_id', $request->academic_year_id)
            ->first();

        if ($existingAllocation) {
            Session::flash('error', 'This module allocation already exists for the selected teacher, academic year, and center.');
            return redirect()->back()->withInput();
        }

        SubjectAllocation::create([
            'user_id' => $request->teacher_id,
            'subject_id' => $request->module_id,
            'center_id' => $request->center_id,
            'academic_year_id' => $request->academic_year_id
        ]);

        Session::flash('success', 'Module allocation created successfully!');
        return redirect()->route('module-allocations.index');
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
    public function edit($id)
    {
        $allocation = SubjectAllocation::findOrFail($id);
        $modules = Module::all();
        $academicYears = AcademicYear::all();
        $centers = Center::all();
        $teachers = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['Teacher', 'Lecturer', 'Instructor']);
        })->orWhereDoesntHave('roles')->get();
        
        return view('ModuleAllocations.edit', compact('allocation', 'modules', 'academicYears', 'centers', 'teachers'));
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
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'module_id' => 'required|exists:modules,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'center_id' => 'required|exists:centers,id'
        ]);

        $allocation = SubjectAllocation::findOrFail($id);

        // Check if allocation already exists (excluding current record)
        $existingAllocation = SubjectAllocation::where('user_id', $request->teacher_id)
            ->where('subject_id', $request->module_id)
            ->where('center_id', $request->center_id)
            ->where('academic_year_id', $request->academic_year_id)
            ->where('id', '!=', $id)
            ->first();

        if ($existingAllocation) {
            Session::flash('error', 'This module allocation already exists for the selected teacher, academic year, and center.');
            return redirect()->back()->withInput();
        }

        $allocation->update([
            'user_id' => $request->teacher_id,
            'subject_id' => $request->module_id,
            'center_id' => $request->center_id,
            'academic_year_id' => $request->academic_year_id
        ]);

        Session::flash('success', 'Module allocation updated successfully!');
        return redirect()->route('module-allocations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SubjectAllocation::findOrFail($id)->delete();
        Session::flash('success', 'Module allocation deleted successfully.');
        return redirect()->route('module-allocations.index');
    }
}
