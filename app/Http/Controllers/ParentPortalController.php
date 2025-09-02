<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\User;
use Illuminate\Support\Facades\Auth;

class ParentPortalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Parent Portal Dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get children (students) linked to this parent
        $children = Student::where('guardian_contact_email', 'LIKE', '%' . $user->email . '%')
            ->orWhere('guardian_contact_email', $user->email)
            ->get();

        // Get statistics for all children
        $stats = [
            'total_children' => $children->count(),
            'total_subjects' => 0,
            'total_payments' => 0,
            'pending_applications' => 0
        ];

        foreach ($children as $child) {
            $stats['total_subjects'] += \App\ModuleRegistration::where('student_id', $child->id)->count();
            $stats['total_payments'] += \App\Payment::where('student_id', $child->id)->sum('amount_paid');
        }

        return view('parent-portal.dashboard', compact('children', 'stats'));
    }

    /**
     * View child's academic records
     */
    public function childAcademicRecords($studentId)
    {
        $user = Auth::user();
        $student = Student::where('id', $studentId)
            ->where(function($query) use ($user) {
                $query->where('guardian_contact_email', 'LIKE', '%' . $user->email . '%')
                      ->orWhere('guardian_contact_email', $user->email);
            })->firstOrFail();

        // Get academic records for this child
        $subjects = \App\ModuleRegistration::where('student_id', $student->id)
            ->with('subjectAllocation.subject')
            ->get();

        return view('parent-portal.child-academic-records', compact('student', 'subjects'));
    }

    /**
     * View child's payments
     */
    public function childPayments($studentId)
    {
        $user = Auth::user();
        $student = Student::where('id', $studentId)
            ->where(function($query) use ($user) {
                $query->where('guardian_contact_email', 'LIKE', '%' . $user->email . '%')
                      ->orWhere('guardian_contact_email', $user->email);
            })->firstOrFail();

        $payments = \App\Payment::where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('parent-portal.child-payments', compact('student', 'payments'));
    }
}
