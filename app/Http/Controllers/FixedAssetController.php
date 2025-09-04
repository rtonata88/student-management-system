<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FixedAsset;
use App\Models\AssetCategory;
use App\Models\Department;
use App\User;
use App\Center;
use App\Models\FixedAssetMaintenance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FixedAssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:fixed-assets-view')->only(['index', 'show', 'maintenanceDue', 'warrantyExpired']);
        $this->middleware('permission:fixed-assets-create')->only(['create', 'store']);
        $this->middleware('permission:fixed-assets-edit')->only(['edit', 'update']);
        $this->middleware('permission:fixed-assets-delete')->only(['destroy']);
        $this->middleware('permission:fixed-assets-maintenance')->only(['scheduleMaintenance', 'processMaintenanceSchedule']);
        $this->middleware('permission:fixed-assets-reports')->only(['maintenanceDue', 'warrantyExpired']);
    }

    /**
     * Display a listing of fixed assets.
     */
    public function index(Request $request)
    {
        $query = FixedAsset::with(['category', 'maintenanceRecords']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('asset_tag', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by condition
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        $assets = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = AssetCategory::active()->orderBy('name')->get();

        // Dashboard statistics
        $stats = [
            'total_assets' => FixedAsset::count(),
            'active_assets' => FixedAsset::where('status', 'active')->count(),
            'maintenance_due' => FixedAsset::maintenanceDue()->count(),
            'warranty_expired' => FixedAsset::warrantyExpired()->count(),
            'total_value' => FixedAsset::sum('current_value') ?: FixedAsset::sum('purchase_cost')
        ];

        return view('fixed-assets.index', compact('assets', 'categories', 'stats'));
    }

    /**
     * Show the form for creating a new asset.
     */
    public function create()
    {
        $categories = AssetCategory::active()->orderBy('name')->get();
        $staffUsers = User::where('user_type', 'staff')->orderBy('name')->get();
        $departments = Department::active()->orderBy('name')->get();
        $centers = Center::orderBy('center_name')->get();

        return view('fixed-assets.create', compact('categories', 'staffUsers', 'departments', 'centers'));
    }

    /**
     * Store a newly created asset.
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_tag' => 'required|string|unique:fixed_assets,asset_tag',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:asset_categories,id',
            'purchase_cost' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'location' => 'required|string|max:255|in:' . Center::pluck('center_name')->implode(','),
            'condition' => 'required|in:excellent,good,fair,poor,damaged',
            'status' => 'required|in:active,inactive,disposed,lost,stolen,maintenance',
            'assigned_to' => 'nullable|exists:users,id',
            'department' => 'nullable|exists:departments,id'
        ]);

        $asset = FixedAsset::create($request->all());

        return redirect()->route('fixed-assets.index')
                        ->with('success', 'Fixed asset created successfully.');
    }

    /**
     * Display the specified asset.
     */
    public function show(FixedAsset $fixedAsset)
    {
        $fixedAsset->load(['category', 'maintenanceRecords' => function($query) {
            $query->orderBy('maintenance_date', 'desc')->limit(10);
        }]);

        return view('fixed-assets.show', compact('fixedAsset'));
    }

    /**
     * Show the form for editing the specified asset.
     */
    public function edit(FixedAsset $fixedAsset)
    {
        $categories = AssetCategory::active()->orderBy('name')->get();
        $staffUsers = User::where('user_type', 'staff')->orderBy('name')->get();
        $departments = Department::active()->orderBy('name')->get();
        $centers = Center::orderBy('center_name')->get();

        return view('fixed-assets.edit', compact('fixedAsset', 'categories', 'staffUsers', 'departments', 'centers'));
    }

    /**
     * Update the specified asset.
     */
    public function update(Request $request, FixedAsset $fixedAsset)
    {
        $request->validate([
            'asset_tag' => 'required|string|unique:fixed_assets,asset_tag,' . $fixedAsset->id,
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:asset_categories,id',
            'purchase_cost' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'location' => 'required|string|max:255|in:' . Center::pluck('center_name')->implode(','),
            'condition' => 'required|in:excellent,good,fair,poor,damaged',
            'status' => 'required|in:active,inactive,disposed,lost,stolen,maintenance',
            'assigned_to' => 'nullable|exists:users,id',
            'department' => 'nullable|exists:departments,id'
        ]);

        $fixedAsset->update($request->all());

        return redirect()->route('fixed-assets.index')
                        ->with('success', 'Fixed asset updated successfully.');
    }

    /**
     * Remove the specified asset.
     */
    public function destroy(FixedAsset $fixedAsset)
    {
        $fixedAsset->delete();

        return redirect()->route('fixed-assets.index')
                        ->with('success', 'Fixed asset deleted successfully.');
    }

    /**
     * Show assets with maintenance due.
     */
    public function maintenanceDue()
    {
        $assets = FixedAsset::with('category')
                           ->maintenanceDue()
                           ->orderBy('next_maintenance')
                           ->paginate(15);

        return view('fixed-assets.maintenance-due', compact('assets'));
    }

    /**
     * Show assets with expired warranty.
     */
    public function warrantyExpired()
    {
        $assets = FixedAsset::with('category')
                           ->warrantyExpired()
                           ->orderBy('warranty_expiry')
                           ->paginate(15);

        return view('fixed-assets.warranty-expired', compact('assets'));
    }

    /**
     * Show maintenance scheduling form.
     */
    public function scheduleMaintenance(FixedAsset $fixedAsset)
    {
        return view('fixed-assets.schedule-maintenance', compact('fixedAsset'));
    }

    /**
     * Process maintenance scheduling.
     */
    public function processMaintenanceSchedule(Request $request, FixedAsset $fixedAsset)
    {
        $request->validate([
            'type' => 'required|in:preventive,corrective,emergency,inspection',
            'maintenance_date' => 'required|date',
            'performed_by' => 'required|string|max:255',
            'description' => 'required|string',
            'cost' => 'nullable|numeric|min:0',
            'next_due_date' => 'nullable|date|after:maintenance_date'
        ]);

        FixedAssetMaintenance::create([
            'asset_id' => $fixedAsset->id,
            'type' => $request->type,
            'maintenance_date' => $request->maintenance_date,
            'performed_by' => $request->performed_by,
            'service_provider' => $request->service_provider,
            'description' => $request->description,
            'cost' => $request->cost ?? 0,
            'status' => 'scheduled',
            'next_due_date' => $request->next_due_date,
            'notes' => $request->notes
        ]);

        // Update asset maintenance dates
        $fixedAsset->update([
            'last_maintenance' => $request->maintenance_date,
            'next_maintenance' => $request->next_due_date
        ]);

        return redirect()->route('fixed-assets.show', $fixedAsset)
                        ->with('success', 'Maintenance scheduled successfully.');
    }
}
