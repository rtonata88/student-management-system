<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OnlineApplication;
use App\ApplicationDocument;
use App\Student;
use App\User;
use Illuminate\Support\Facades\Auth;

class OnlineSubmissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-online-applications');
    }

    /**
     * Display listing of online applications
     */
    public function index()
    {
        $applications = OnlineApplication::with(['user', 'student', 'subjects', 'documents'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('online-submissions.index', compact('applications'));
    }

    /**
     * Filter applications
     */
    public function filter(Request $request)
    {
        $query = OnlineApplication::with(['user', 'student', 'subjects', 'documents']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('application_number')) {
            $query->where('application_number', 'like', '%' . $request->application_number . '%');
        }

        if ($request->filled('student_name')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->student_name . '%');
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('online-submissions.index', compact('applications'));
    }

    /**
     * Show application details
     */
    public function show($id)
    {
        $application = OnlineApplication::with(['user', 'student', 'subjects', 'documents', 'reviewer'])
            ->findOrFail($id);

        return view('online-submissions.show', compact('application'));
    }

    /**
     * Update application status
     */
    public function updateStatus(Request $request, $id)
    {
        $this->middleware('permission:review-online-applications');

        $application = OnlineApplication::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,under_review,approved,rejected',
            'admin_notes' => 'nullable|string'
        ]);

        $application->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id()
        ]);

        return redirect()->back()
            ->with('success', 'Application status updated successfully!');
    }

    /**
     * Download document
     */
    public function downloadDocument($id)
    {
        $this->middleware('permission:download-application-documents');

        $document = ApplicationDocument::findOrFail($id);

        if (!$document->exists()) {
            return redirect()->back()
                ->with('error', 'Document file not found.');
        }

        return response()->download(storage_path('app/public/' . $document->file_path));
    }

    /**
     * Verify document
     */
    public function verifyDocument(Request $request, $id)
    {
        $this->middleware('permission:verify-application-documents');

        $document = ApplicationDocument::findOrFail($id);

        $request->validate([
            'verified' => 'required|boolean',
            'verification_notes' => 'nullable|string'
        ]);

        $document->update([
            'verified' => $request->verified,
            'verification_notes' => $request->verification_notes,
            'verified_by' => Auth::id(),
            'verified_at' => now()
        ]);

        return redirect()->back()
            ->with('success', 'Document verification updated successfully!');
    }
}
