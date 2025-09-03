<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MarksSuppression;
use App\AcademicYear;
use App\Module;
use Illuminate\Support\Facades\Auth;

class MarksSuppressionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-marks-suppression')->only(['index', 'show']);
        $this->middleware('permission:create-marks-suppression')->only(['create', 'store']);
        $this->middleware('permission:edit-marks-suppression')->only(['edit', 'update', 'toggleSuppression']);
        $this->middleware('permission:delete-marks-suppression')->only(['destroy']);
    }

    /**
     * Display a listing of marks suppressions.
     */
    public function index(Request $request)
    {

        $query = MarksSuppression::with(['academicYear', 'creator']);

        // Apply filters
        if ($request->filled('academic_year')) {
            $query->byAcademicYear($request->academic_year);
        }

        if ($request->filled('campus')) {
            $query->byCampus($request->campus);
        }

        if ($request->filled('mark_type')) {
            $query->byMarkType($request->mark_type);
        }


        $suppressions = $query->orderBy('created_at', 'desc')->paginate(15);

        $academicYears = AcademicYear::orderBy('academic_year', 'desc')->get();
        $campuses = \DB::table('centers')->distinct()->pluck('center_name')->filter()->sort();
        $markTypes = \DB::table('examinations')->where('active', 1)->pluck('name')->toArray();

        return view('assessments.marks-suppression.index', compact(
            'suppressions', 
            'academicYears', 
            'campuses', 
            'markTypes'
        ));
    }

    /**
     * Show the form for creating a new marks suppression.
     */
    public function create()
    {

        $academicYears = AcademicYear::orderBy('academic_year', 'desc')->get();
        $campuses = \DB::table('centers')->distinct()->pluck('center_name')->filter()->sort();
        $markTypes = \DB::table('examinations')->where('active', 1)->pluck('name')->toArray();

        return view('assessments.marks-suppression.create', compact(
            'academicYears', 
            'campuses', 
            'markTypes'
        ));
    }

    /**
     * Store a newly created marks suppression.
     */
    public function store(Request $request)
    {

        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'campus' => 'required|string',
            'mark_type' => 'required|string',
            'reason' => 'nullable|string|max:1000'
        ]);

        // Check if suppression already exists
        $existing = MarksSuppression::where([
            'academic_year_id' => $request->academic_year_id,
            'campus' => $request->campus,
            'mark_type' => $request->mark_type
        ])->first();

        if ($existing) {
            return redirect()->back()->withErrors(['error' => 'A suppression with these criteria already exists.'])->withInput();
        }

        MarksSuppression::create([
            'academic_year_id' => $request->academic_year_id,
            'intake' => '',
            'campus' => $request->campus,
            'mark_type' => $request->mark_type,
            'study_mode' => '',
            'is_suppressed' => true,
            'reason' => $request->reason,
            'created_by' => auth()->id()
        ]);

        return redirect()->route('marks-suppression.index')->with('success', 'Marks suppression created successfully.');
    }

    /**
     * Display the specified marks suppression.
     */
    public function show(MarksSuppression $marksSuppression)
    {

        return view('assessments.marks-suppression.show', compact('marksSuppression'));
    }

    /**
     * Show the form for editing the specified marks suppression.
     */
    public function edit(MarksSuppression $marksSuppression)
    {

        $academicYears = AcademicYear::orderBy('academic_year', 'desc')->get();
        $campuses = \DB::table('centers')->distinct()->pluck('center_name')->filter()->sort();
        $markTypes = \DB::table('examinations')->where('active', 1)->pluck('name')->toArray();

        return view('assessments.marks-suppression.edit', compact(
            'marksSuppression',
            'academicYears', 
            'campuses', 
            'markTypes'
        ));
    }

    /**
     * Update the specified marks suppression.
     */
    public function update(Request $request, MarksSuppression $marksSuppression)
    {

        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'campus' => 'required|string',
            'mark_type' => 'required|string',
            'is_suppressed' => 'required|boolean',
            'reason' => 'nullable|string|max:1000'
        ]);

        $marksSuppression->update($request->all());

        return redirect()->route('marks-suppression.index')->with('success', 'Marks suppression updated successfully.');
    }

    /**
     * Remove the specified marks suppression.
     */
    public function destroy(MarksSuppression $marksSuppression)
    {

        $marksSuppression->delete();

        return redirect()->route('marks-suppression.index')->with('success', 'Marks suppression deleted successfully.');
    }

    /**
     * Toggle suppression status
     */
    public function toggleSuppression(MarksSuppression $marksSuppression)
    {

        $marksSuppression->update([
            'is_suppressed' => !$marksSuppression->is_suppressed
        ]);

        $status = $marksSuppression->is_suppressed ? 'activated' : 'deactivated';
        
        return redirect()->back()->with('success', "Marks suppression {$status} successfully.");
    }
}
