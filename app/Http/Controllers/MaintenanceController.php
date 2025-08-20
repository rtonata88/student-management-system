<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceRequest;
use App\Models\MaintenanceWorkOrder;
use App\Models\MaintenanceCategory;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:maintenance-view')->only(['index', 'show']);
        $this->middleware('permission:maintenance-create-request')->only(['create', 'store']);
        $this->middleware('permission:maintenance-edit-request')->only(['edit', 'update']);
        $this->middleware('permission:maintenance-delete-request')->only(['destroy']);
        $this->middleware('permission:maintenance-approve-request')->only(['approve', 'reject']);
        $this->middleware('permission:maintenance-view-reports')->only(['reports', 'overdueRequests', 'completedRequests']);
    }

    public function index(Request $request)
    {
        $query = MaintenanceRequest::with(['category', 'requestedBy', 'approvedBy']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('request_number', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(20);
        $categories = MaintenanceCategory::active()->get();

        // Dashboard stats
        $stats = [
            'total_requests' => MaintenanceRequest::count(),
            'pending_requests' => MaintenanceRequest::where('status', 'pending')->count(),
            'in_progress_requests' => MaintenanceRequest::where('status', 'in_progress')->count(),
            'completed_requests' => MaintenanceRequest::where('status', 'completed')->count(),
            'overdue_requests' => MaintenanceRequest::overdue()->count()
        ];

        return view('maintenance.index', compact('requests', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = MaintenanceCategory::active()->get();
        return view('maintenance.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:maintenance_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high,critical',
            'required_completion_date' => 'nullable|date|after:today',
            'estimated_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        $maintenanceRequest = MaintenanceRequest::create([
            'category_id' => $request->category_id,
            'requested_by' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'priority' => $request->priority,
            'requested_date' => now()->toDateString(),
            'required_completion_date' => $request->required_completion_date,
            'estimated_cost' => $request->estimated_cost,
            'notes' => $request->notes
        ]);

        return redirect()->route('maintenance.show', $maintenanceRequest)
                        ->with('success', 'Maintenance request created successfully.');
    }

    public function show(MaintenanceRequest $maintenance)
    {
        $maintenance->load(['category', 'requestedBy', 'approvedBy', 'workOrders.assignedTo']);
        return view('maintenance.show', compact('maintenance'));
    }

    public function edit(MaintenanceRequest $maintenance)
    {
        // Only allow editing if request is pending or by the requester
        if ($maintenance->status !== 'pending' && $maintenance->requested_by !== Auth::id()) {
            abort(403, 'Cannot edit this maintenance request.');
        }

        $categories = MaintenanceCategory::active()->get();
        return view('maintenance.edit', compact('maintenance', 'categories'));
    }

    public function update(Request $request, MaintenanceRequest $maintenance)
    {
        // Only allow updating if request is pending or by the requester
        if ($maintenance->status !== 'pending' && $maintenance->requested_by !== Auth::id()) {
            abort(403, 'Cannot update this maintenance request.');
        }

        $request->validate([
            'category_id' => 'required|exists:maintenance_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high,critical',
            'required_completion_date' => 'nullable|date|after:today',
            'estimated_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        $maintenance->update($request->only([
            'category_id', 'title', 'description', 'location', 'priority',
            'required_completion_date', 'estimated_cost', 'notes'
        ]));

        return redirect()->route('maintenance.show', $maintenance)
                        ->with('success', 'Maintenance request updated successfully.');
    }

    public function destroy(MaintenanceRequest $maintenance)
    {
        // Only allow deletion if request is pending
        if ($maintenance->status !== 'pending') {
            abort(403, 'Cannot delete this maintenance request.');
        }

        $maintenance->delete();

        return redirect()->route('maintenance.index')
                        ->with('success', 'Maintenance request deleted successfully.');
    }

    public function approve(Request $request, MaintenanceRequest $maintenance)
    {
        $request->validate([
            'notes' => 'nullable|string'
        ]);

        $maintenance->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'notes' => $request->notes
        ]);

        return redirect()->route('maintenance.show', $maintenance)
                        ->with('success', 'Maintenance request approved successfully.');
    }

    public function reject(Request $request, MaintenanceRequest $maintenance)
    {
        $request->validate([
            'rejection_reason' => 'required|string'
        ]);

        $maintenance->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason
        ]);

        return redirect()->route('maintenance.show', $maintenance)
                        ->with('success', 'Maintenance request rejected.');
    }

    public function reports()
    {
        $stats = [
            'total_requests' => MaintenanceRequest::count(),
            'pending_requests' => MaintenanceRequest::where('status', 'pending')->count(),
            'approved_requests' => MaintenanceRequest::where('status', 'approved')->count(),
            'in_progress_requests' => MaintenanceRequest::where('status', 'in_progress')->count(),
            'completed_requests' => MaintenanceRequest::where('status', 'completed')->count(),
            'overdue_requests' => MaintenanceRequest::overdue()->count(),
            'total_work_orders' => MaintenanceWorkOrder::count(),
            'active_work_orders' => MaintenanceWorkOrder::whereIn('status', ['assigned', 'in_progress'])->count(),
            'completed_work_orders' => MaintenanceWorkOrder::where('status', 'completed')->count()
        ];

        return view('maintenance.reports', compact('stats'));
    }

    public function overdueRequests()
    {
        $overdueRequests = MaintenanceRequest::overdue()
                                           ->with(['category', 'requestedBy'])
                                           ->orderBy('required_completion_date', 'asc')
                                           ->paginate(20);

        return view('maintenance.overdue-requests', compact('overdueRequests'));
    }

    public function completedRequests()
    {
        $completedRequests = MaintenanceRequest::completed()
                                             ->with(['category', 'requestedBy', 'approvedBy'])
                                             ->orderBy('updated_at', 'desc')
                                             ->paginate(20);

        return view('maintenance.completed-requests', compact('completedRequests'));
    }
}
