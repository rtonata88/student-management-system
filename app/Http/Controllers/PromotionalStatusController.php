<?php

namespace App\Http\Controllers;

use App\PromotionalStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PromotionalStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermission('promotional-statuses')) {
            abort(403, 'Unauthorized access to promotional statuses.');
        }
        
        $search = $request->get('search');
        
        $promotionalStatuses = PromotionalStatus::when($search, function ($query, $search) {
            return $query->where('description', 'like', "%{$search}%")
                        ->orWhere('promoted', 'like', "%{$search}%");
        })
        ->orderBy('promoted', 'desc')
        ->orderBy('description')
        ->paginate(10);

        return view('PromotionalStatuses.Index', compact('promotionalStatuses', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermission('add-promotional-statuses')) {
            abort(403, 'Unauthorized access to create promotional statuses.');
        }
        
        return view('PromotionalStatuses.Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('add-promotional-statuses')) {
            abort(403, 'Unauthorized access to create promotional statuses.');
        }
        
        $request->validate([
            'promoted' => 'required|in:Yes,No',
            'description' => 'required|string|max:255|unique:promotional_statuses,description',
            'active' => 'boolean'
        ]);

        PromotionalStatus::create([
            'promoted' => $request->promoted,
            'description' => $request->description,
            'active' => $request->has('active')
        ]);

        return redirect()->route('promotional-statuses.index')->with('success', 'Promotional status created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PromotionalStatus  $promotionalStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(PromotionalStatus $promotionalStatus)
    {
        if (!Auth::user()->hasPermission('edit-promotional-statuses')) {
            abort(403, 'Unauthorized access to edit promotional statuses.');
        }
        
        return view('PromotionalStatuses.Edit', compact('promotionalStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PromotionalStatus  $promotionalStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PromotionalStatus $promotionalStatus)
    {
        if (!Auth::user()->hasPermission('edit-promotional-statuses')) {
            abort(403, 'Unauthorized access to update promotional statuses.');
        }
        
        $request->validate([
            'promoted' => 'required|in:Yes,No',
            'description' => 'required|string|max:255|unique:promotional_statuses,description,' . $promotionalStatus->id,
            'active' => 'boolean'
        ]);

        $promotionalStatus->update([
            'promoted' => $request->promoted,
            'description' => $request->description,
            'active' => $request->has('active')
        ]);

        Session::flash('success', 'Promotional status updated successfully');
        return redirect()->route('promotional-statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PromotionalStatus  $promotionalStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(PromotionalStatus $promotionalStatus)
    {
        if (!Auth::user()->hasPermission('delete-promotional-statuses')) {
            abort(403, 'Unauthorized access to delete promotional statuses.');
        }
        
        $promotionalStatus->delete();
        
        Session::flash('success', 'Promotional status deleted successfully');
        return redirect()->route('promotional-statuses.index');
    }
}
