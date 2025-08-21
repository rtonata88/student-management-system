<?php

namespace App\Http\Controllers;

use App\SubjectAllocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyModulesController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
        $this->middleware('permission:view-my-modules', ['only' => ['index']]);
        $this->middleware('permission:view-class-list', ['only' => ['classList']]);
        $this->middleware('permission:view-attendance', ['only' => ['attendance']]);
        $this->middleware('permission:view-class-notes', ['only' => ['classNotes']]);
    }

    /**
     * Display modules allocated to the current user
     */
    public function index()
    {
        $myModules = SubjectAllocation::with(['module', 'academicYear', 'center'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('MyModules.index', compact('myModules'));
    }

    /**
     * Display class list for a specific module allocation
     */
    public function classList($allocationId)
    {
        $allocation = SubjectAllocation::with(['module', 'academicYear', 'center'])
            ->where('id', $allocationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        // Here you would fetch students enrolled in this module
        // For now, we'll just pass the allocation
        return view('MyModules.class-list', compact('allocation'));
    }

    /**
     * Display attendance for a specific module allocation
     */
    public function attendance($allocationId)
    {
        $allocation = SubjectAllocation::with(['module', 'academicYear', 'center'])
            ->where('id', $allocationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        return view('MyModules.attendance', compact('allocation'));
    }

    /**
     * Display class notes for a specific module allocation
     */
    public function classNotes($allocationId)
    {
        $allocation = SubjectAllocation::with(['module', 'academicYear', 'center'])
            ->where('id', $allocationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        return view('MyModules.class-notes', compact('allocation'));
    }
}
