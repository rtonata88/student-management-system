<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeaveRequest;
use App\LeaveType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LeaveApplicationController extends Controller
{
    /**
     * Display a listing of the user's leave applications.
     */
    public function index(Request $request)
    {
        $query = LeaveRequest::with(['leaveType', 'approver'])
                            ->where('user_id', Auth::id());
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('leaveType', function($q) use ($search) {
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
        
        $leaveApplications = $query->orderBy('created_at', 'desc')->paginate(15);
        $leaveTypes = LeaveType::active()->get();
        
        return view('leave-applications.index', compact('leaveApplications', 'leaveTypes'));
    }

    /**
     * Show the form for creating a new leave application.
     */
    public function create()
    {
        $leaveTypes = LeaveType::active()->get();
        
        return view('leave-applications.create', compact('leaveTypes'));
    }

    /**
     * Store a newly created leave application.
     */
    public function store(Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
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

        $leaveRequest = new LeaveRequest();
        $leaveRequest->user_id = Auth::id();
        $leaveRequest->leave_type_id = $request->leave_type_id;
        $leaveRequest->start_date = $startDate;
        $leaveRequest->end_date = $endDate;
        $leaveRequest->total_days = $totalDays;
        $leaveRequest->reason = $request->reason;
        $leaveRequest->status = 'pending';
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

        return redirect()->route('leave-applications.index')
                        ->with('success', 'Leave application submitted successfully.');
    }

    /**
     * Display the specified leave application.
     */
    public function show(LeaveRequest $leaveApplication)
    {
        // Ensure user can only view their own applications
        if ($leaveApplication->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }
        
        $leaveApplication->load(['leaveType', 'approver', 'creator']);
        
        return view('leave-applications.show', compact('leaveApplication'));
    }

    /**
     * Show the form for editing the specified leave application.
     */
    public function edit(LeaveRequest $leaveApplication)
    {
        // Ensure user can only edit their own applications and only if pending
        if ($leaveApplication->user_id !== Auth::id() || $leaveApplication->status !== 'pending') {
            abort(403, 'Unauthorized access or application cannot be edited.');
        }
        
        $leaveTypes = LeaveType::active()->get();
        
        return view('leave-applications.edit', compact('leaveApplication', 'leaveTypes'));
    }

    /**
     * Update the specified leave application.
     */
    public function update(Request $request, LeaveRequest $leaveApplication)
    {
        // Ensure user can only update their own applications and only if pending
        if ($leaveApplication->user_id !== Auth::id() || $leaveApplication->status !== 'pending') {
            abort(403, 'Unauthorized access or application cannot be edited.');
        }

        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
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

        $leaveApplication->leave_type_id = $request->leave_type_id;
        $leaveApplication->start_date = $startDate;
        $leaveApplication->end_date = $endDate;
        $leaveApplication->total_days = $totalDays;
        $leaveApplication->reason = $request->reason;
        $leaveApplication->is_half_day = $request->boolean('is_half_day');
        $leaveApplication->half_day_period = $request->half_day_period;

        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($leaveApplication->attachment) {
                Storage::disk('public')->delete($leaveApplication->attachment);
            }
            
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('leave_attachments', $filename, 'public');
            $leaveApplication->attachment = $path;
        }

        $leaveApplication->save();

        return redirect()->route('leave-applications.index')
                        ->with('success', 'Leave application updated successfully.');
    }

    /**
     * Cancel the specified leave application.
     */
    public function cancel(LeaveRequest $leaveApplication)
    {
        // Ensure user can only cancel their own applications and only if pending
        if ($leaveApplication->user_id !== Auth::id() || $leaveApplication->status !== 'pending') {
            abort(403, 'Unauthorized access or application cannot be cancelled.');
        }

        $leaveApplication->status = 'cancelled';
        $leaveApplication->save();

        return redirect()->back()->with('success', 'Leave application cancelled successfully.');
    }

    /**
     * Remove the specified leave application.
     */
    public function destroy(LeaveRequest $leaveApplication)
    {
        // Ensure user can only delete their own applications and only if pending
        if ($leaveApplication->user_id !== Auth::id() || $leaveApplication->status !== 'pending') {
            abort(403, 'Unauthorized access or application cannot be deleted.');
        }

        // Delete attachment if exists
        if ($leaveApplication->attachment) {
            Storage::disk('public')->delete($leaveApplication->attachment);
        }
        
        $leaveApplication->delete();

        return redirect()->route('leave-applications.index')
                        ->with('success', 'Leave application deleted successfully.');
    }
}
