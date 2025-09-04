<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DesignationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-designations')->only(['index', 'show']);
        $this->middleware('permission:create-designations')->only(['create', 'store']);
        $this->middleware('permission:edit-designations')->only(['edit', 'update']);
        $this->middleware('permission:delete-designations')->only(['destroy']);
        $this->middleware('permission:toggle-designation-status')->only(['toggleStatus']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Designation::with(['creator', 'updater']);

        // Search functionality
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('code', 'LIKE', "%{$search}%")
                  ->orWhere('level', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $designations = $query->orderBy('name')->paginate(15);

        return view('designations.index', compact('designations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('designations.create');
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
            'code' => 'required|string|max:10|unique:designations,code',
            'level' => 'nullable|string|max:255',
            'description' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $designation = Designation::create([
                'name' => $request->name,
                'code' => strtoupper($request->code),
                'level' => $request->level,
                'description' => $request->description,
                'is_active' => $request->has('is_active') ? 1 : 0,
                'created_by' => Auth::id()
            ]);

            DB::commit();

            return redirect()->route('designations.index')
                           ->with('success', 'Designation created successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error creating designation: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function show(Designation $designation)
    {
        $designation->load(['creator', 'updater']);
        return view('designations.show', compact('designation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function edit(Designation $designation)
    {
        return view('designations.edit', compact('designation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Designation $designation)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:designations,code,' . $designation->id,
            'level' => 'nullable|string|max:255',
            'description' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $designation->update([
                'name' => $request->name,
                'code' => strtoupper($request->code),
                'level' => $request->level,
                'description' => $request->description,
                'is_active' => $request->has('is_active') ? 1 : 0,
                'updated_by' => Auth::id()
            ]);

            DB::commit();

            return redirect()->route('designations.index')
                           ->with('success', 'Designation updated successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error updating designation: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designation $designation)
    {
        try {
            $designation->delete();
            return redirect()->route('designations.index')
                           ->with('success', 'Designation deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error deleting designation: ' . $e->getMessage());
        }
    }

    /**
     * Toggle the status of the specified designation.
     *
     * @param  Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(Designation $designation)
    {
        try {
            $designation->update([
                'is_active' => !$designation->is_active,
                'updated_by' => Auth::id()
            ]);

            $status = $designation->is_active ? 'activated' : 'deactivated';
            return redirect()->back()
                           ->with('success', "Designation {$status} successfully.");

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error updating designation status: ' . $e->getMessage());
        }
    }
}
