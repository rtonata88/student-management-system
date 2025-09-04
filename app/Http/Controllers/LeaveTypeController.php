<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveType;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LeaveTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-leave-types')->only(['index', 'show']);
        $this->middleware('permission:create-leave-types')->only(['create', 'store']);
        $this->middleware('permission:edit-leave-types')->only(['edit', 'update']);
        $this->middleware('permission:delete-leave-types')->only(['destroy']);
        $this->middleware('permission:toggle-leave-type-status')->only(['toggleStatus']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = LeaveType::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->get('status') === 'active') {
                $query->where('is_active', true);
            } elseif ($request->get('status') === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $leaveTypes = $query->orderBy('name')->paginate(15);

        return view('leave-types.index', compact('leaveTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leave-types.create');
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
            'name' => 'required|string|max:255|unique:leave_types,name',
            'description' => 'nullable|string',
            'max_days_per_year' => 'nullable|integer|min:1|max:365',
            'requires_approval' => 'nullable',
            'is_active' => 'nullable',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/'
        ]);

        try {
            DB::beginTransaction();

            $leaveType = LeaveType::create([
                'name' => $request->name,
                'description' => $request->description,
                'max_days_per_year' => $request->max_days_per_year,
                'requires_approval' => $request->has('requires_approval') ? true : false,
                'is_active' => $request->has('is_active') ? true : false,
                'color' => $request->color,
            ]);

            DB::commit();

            return redirect()->route('leave-types.index')
                           ->with('success', 'Leave type created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create leave type. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  LeaveType  $leaveType
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveType $leaveType)
    {
        return view('leave-types.show', compact('leaveType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  LeaveType  $leaveType
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveType $leaveType)
    {
        return view('leave-types.edit', compact('leaveType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  LeaveType  $leaveType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeaveType $leaveType)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('leave_types')->ignore($leaveType->id)],
            'description' => 'nullable|string',
            'max_days_per_year' => 'nullable|integer|min:1|max:365',
            'requires_approval' => 'nullable',
            'is_active' => 'nullable',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/'
        ]);

        try {
            DB::beginTransaction();

            $leaveType->update([
                'name' => $request->name,
                'description' => $request->description,
                'max_days_per_year' => $request->max_days_per_year,
                'requires_approval' => $request->has('requires_approval') ? true : false,
                'is_active' => $request->has('is_active') ? true : false,
                'color' => $request->color,
            ]);

            DB::commit();

            return redirect()->route('leave-types.index')
                           ->with('success', 'Leave type updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to update leave type. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  LeaveType  $leaveType
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeaveType $leaveType)
    {
        try {
            DB::beginTransaction();

            $leaveType->delete();

            DB::commit();

            return redirect()->route('leave-types.index')
                           ->with('success', 'Leave type deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Failed to delete leave type. Please try again.');
        }
    }

    /**
     * Toggle the status of the specified leave type.
     *
     * @param  LeaveType  $leaveType
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(LeaveType $leaveType)
    {
        try {
            DB::beginTransaction();

            $leaveType->update([
                'is_active' => !$leaveType->is_active
            ]);

            DB::commit();

            $status = $leaveType->is_active ? 'activated' : 'deactivated';
            return redirect()->route('leave-types.index')
                           ->with('success', "Leave type {$status} successfully.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Failed to update leave type status. Please try again.');
        }
    }
}
