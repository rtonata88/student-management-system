<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-departments')->only(['index', 'show']);
        $this->middleware('permission:create-departments')->only(['create', 'store']);
        $this->middleware('permission:edit-departments')->only(['edit', 'update']);
        $this->middleware('permission:delete-departments')->only(['destroy']);
        $this->middleware('permission:toggle-department-status')->only(['toggleStatus']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Department::with(['creator', 'updater']);

        // Search functionality
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('code', 'LIKE', "%{$search}%")
                  ->orWhere('head_of_department', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $departments = $query->orderBy('name')->paginate(15);

        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staffUsers = User::where('user_type', 'staff')->orderBy('name')->get();
        return view('departments.create', compact('staffUsers'));
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
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:departments,code',
            'head_of_department' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255'
        ]);

        try {
            DB::beginTransaction();

            $department = Department::create([
                'name' => $request->name,
                'code' => strtoupper($request->code),
                'head_of_department' => $request->head_of_department,
                'location' => $request->location,
                'is_active' => $request->has('is_active') ? 1 : 0,
                'created_by' => Auth::id()
            ]);

            DB::commit();

            return redirect()->route('departments.index')
                           ->with('success', 'Department created successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error creating department: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        $department->load(['creator', 'updater']);
        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        $staffUsers = User::where('user_type', 'staff')->orderBy('name')->get();
        return view('departments.edit', compact('department', 'staffUsers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:departments,code,' . $department->id,
            'head_of_department' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255'
        ]);

        try {
            DB::beginTransaction();

            $department->update([
                'name' => $request->name,
                'code' => strtoupper($request->code),
                'head_of_department' => $request->head_of_department,
                'location' => $request->location,
                'is_active' => $request->has('is_active') ? 1 : 0,
                'updated_by' => Auth::id()
            ]);

            DB::commit();

            return redirect()->route('departments.index')
                           ->with('success', 'Department updated successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error updating department: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        try {
            $department->delete();
            return redirect()->route('departments.index')
                           ->with('success', 'Department deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error deleting department: ' . $e->getMessage());
        }
    }

    /**
     * Toggle department status
     *
     * @param  Department  $department
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(Department $department)
    {
        try {
            $department->update([
                'is_active' => !$department->is_active,
                'updated_by' => Auth::id()
            ]);

            $status = $department->is_active ? 'activated' : 'deactivated';
            return redirect()->back()
                           ->with('success', "Department {$status} successfully.");

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error updating department status: ' . $e->getMessage());
        }
    }
}
