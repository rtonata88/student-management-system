<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeaveRequest;
use App\LeaveType;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LeaveManagementController extends Controller
{
    /**
     * Display a listing of leave requests for admin approval.
     */
    public function index(Request $request)
    {
        $query = LeaveRequest::with(['user', 'leaveType', 'approver']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            })->orWhereHas('leaveType', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            })->orWhere('reason', 'LIKE', "%{$search}%");
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by leave type
        if ($request->filled('leave_type')) {
            $query->where('leave_type_id', $request->leave_type);
        }
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', $request->date_to);
        }
        
        $leaveRequests = $query->orderBy('created_at', 'desc')->paginate(15);
        $leaveTypes = LeaveType::active()->get();
        
        return view('leave-management.index', compact('leaveRequests', 'leaveTypes'));
    }

    /**
     * Show the form for creating a new leave request on behalf of an employee.
     */
    public function create()
    {
        $users = User::where('user_type', 'staff')->orderBy('name')->get();
        $leaveTypes = LeaveType::active()->get();
        
        return view('leave-management.create', compact('users', 'leaveTypes'));
    }

    /**
     * Store a newly created leave request on behalf of an employee.
     */
    public function store(Request $request)
    {
        // Debug: Log all request data
        \Log::info('Leave Management Store Request Data:', $request->all());
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
            'is_half_day' => 'boolean',
            'half_day_period' => 'nullable|required_if:is_half_day,true|in:morning,afternoon',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        
        // Calculate total days - database expects integer, so convert 0.5 to 1 for half days
        $totalDays = $startDate->diffInDays($endDate) + 1;
        if ($request->is_half_day) {
            $totalDays = 1; // Store as 1 in database, but track as half day with is_half_day flag
        }

        try {
            $leaveRequest = new LeaveRequest();
            $leaveRequest->user_id = $request->user_id;
            $leaveRequest->leave_type_id = $request->leave_type_id;
            $leaveRequest->start_date = $startDate;
            $leaveRequest->end_date = $endDate;
            $leaveRequest->total_days = $totalDays;
            $leaveRequest->reason = $request->reason;
            $leaveRequest->status = 'approved'; // Admin-created leaves are auto-approved
            $leaveRequest->approved_by = Auth::id();
            $leaveRequest->approved_at = now();
            $leaveRequest->created_by = Auth::id();
            $leaveRequest->is_half_day = $request->boolean('is_half_day');
            $leaveRequest->half_day_period = $request->half_day_period;

            // Handle file upload
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('leave_attachments', $filename, 'public');
                $leaveRequest->attachment = $path;
            }

            $leaveRequest->save();
            
            return redirect()->route('leave-management.index')
                            ->with('success', 'Leave request created successfully for ' . $leaveRequest->user->name);
        } catch (\Exception $e) {
            \Log::error('Leave request creation failed: ' . $e->getMessage());
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Failed to create leave request. Please try again.');
        }
    }

    /**
     * Display the specified leave request.
     */
    public function show(LeaveRequest $leaveRequest)
    {
        $leaveRequest->load(['user', 'leaveType', 'approver', 'creator']);
        
        return view('leave-management.show', compact('leaveRequest'));
    }

    /**
     * Approve a leave request.
     */
    public function approve(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'admin_comments' => 'nullable|string|max:1000'
        ]);

        $leaveRequest->status = 'approved';
        $leaveRequest->approved_by = Auth::id();
        $leaveRequest->approved_at = now();
        $leaveRequest->admin_comments = $request->admin_comments;
        $leaveRequest->save();

        return redirect()->back()->with('success', 'Leave request approved successfully.');
    }

    /**
     * Reject a leave request.
     */
    public function reject(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'admin_comments' => 'required|string|max:1000'
        ]);

        $leaveRequest->status = 'rejected';
        $leaveRequest->approved_by = Auth::id();
        $leaveRequest->approved_at = now();
        $leaveRequest->admin_comments = $request->admin_comments;
        $leaveRequest->save();

        return redirect()->back()->with('success', 'Leave request rejected.');
    }

    /**
     * Show the form for editing the specified leave request.
     */
    public function edit(LeaveRequest $leaveRequest)
    {
        $users = User::where('user_type', 'staff')->orderBy('name')->get();
        $leaveTypes = LeaveType::active()->get();
        
        return view('leave-management.edit', compact('leaveRequest', 'users', 'leaveTypes'));
    }

    /**
     * Update the specified leave request.
     */
    public function update(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
            'status' => 'required|in:pending,approved,rejected,cancelled',
            'admin_comments' => 'nullable|string|max:1000',
            'is_half_day' => 'boolean',
            'half_day_period' => 'required_if:is_half_day,1|in:morning,afternoon',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        
        // Calculate total days
        $totalDays = $startDate->diffInDays($endDate) + 1;
        if ($request->is_half_day) {
            $totalDays = 0.5;
        }

        $leaveRequest->user_id = $request->user_id;
        $leaveRequest->leave_type_id = $request->leave_type_id;
        $leaveRequest->start_date = $startDate;
        $leaveRequest->end_date = $endDate;
        $leaveRequest->total_days = $totalDays;
        $leaveRequest->reason = $request->reason;
        $leaveRequest->status = $request->status;
        $leaveRequest->admin_comments = $request->admin_comments;
        $leaveRequest->is_half_day = $request->boolean('is_half_day');
        $leaveRequest->half_day_period = $request->half_day_period;

        // Update approval info if status changed to approved
        if ($request->status === 'approved' && $leaveRequest->getOriginal('status') !== 'approved') {
            $leaveRequest->approved_by = Auth::id();
            $leaveRequest->approved_at = now();
        }

        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($leaveRequest->attachment) {
                Storage::disk('public')->delete($leaveRequest->attachment);
            }
            
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('leave_attachments', $filename, 'public');
            $leaveRequest->attachment = $path;
        }

        $leaveRequest->save();

        return redirect()->route('leave-management.index')
                        ->with('success', 'Leave request updated successfully.');
    }

    /**
     * Remove the specified leave request.
     */
    public function destroy(LeaveRequest $leaveRequest)
    {
        // Delete attachment if exists
        if ($leaveRequest->attachment) {
            Storage::disk('public')->delete($leaveRequest->attachment);
        }
        
        $leaveRequest->delete();

        return redirect()->route('leave-management.index')
                        ->with('success', 'Leave request deleted successfully.');
    }
}
