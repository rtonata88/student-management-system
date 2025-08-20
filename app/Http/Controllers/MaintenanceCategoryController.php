<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceCategory;

class MaintenanceCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:maintenance-manage-categories');
    }

    public function index()
    {
        $categories = MaintenanceCategory::withCount('requests')->paginate(20);
        return view('maintenance.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('maintenance.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:maintenance_categories',
            'description' => 'nullable|string',
            'color' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'priority_level' => 'required|in:low,medium,high,critical',
            'expected_completion_hours' => 'nullable|integer|min:1',
            'requires_approval' => 'boolean',
            'active' => 'boolean'
        ]);

        MaintenanceCategory::create($request->all());

        return redirect()->route('maintenance-categories.index')
                        ->with('success', 'Maintenance category created successfully.');
    }

    public function show(MaintenanceCategory $maintenanceCategory)
    {
        $maintenanceCategory->load(['requests' => function($query) {
            $query->latest()->take(10);
        }]);
        
        return view('maintenance.categories.show', compact('maintenanceCategory'));
    }

    public function edit(MaintenanceCategory $maintenanceCategory)
    {
        return view('maintenance.categories.edit', compact('maintenanceCategory'));
    }

    public function update(Request $request, MaintenanceCategory $maintenanceCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:maintenance_categories,name,' . $maintenanceCategory->id,
            'description' => 'nullable|string',
            'color' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'priority_level' => 'required|in:low,medium,high,critical',
            'expected_completion_hours' => 'nullable|integer|min:1',
            'requires_approval' => 'boolean',
            'active' => 'boolean'
        ]);

        $maintenanceCategory->update($request->all());

        return redirect()->route('maintenance-categories.index')
                        ->with('success', 'Maintenance category updated successfully.');
    }

    public function destroy(MaintenanceCategory $maintenanceCategory)
    {
        // Check if category has any requests
        if ($maintenanceCategory->requests()->count() > 0) {
            return redirect()->route('maintenance-categories.index')
                            ->with('error', 'Cannot delete category with existing maintenance requests.');
        }

        $maintenanceCategory->delete();

        return redirect()->route('maintenance-categories.index')
                        ->with('success', 'Maintenance category deleted successfully.');
    }
}
