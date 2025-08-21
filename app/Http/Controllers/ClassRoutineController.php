<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClassSchedule;
use App\Venue;
use App\ClassDuration;
use App\SubjectAllocation;
use App\AcademicYear;
use App\Center;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ClassRoutineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-class-routine')->only(['index', 'show']);
        $this->middleware('permission:create-class-routine')->only(['create', 'store']);
        $this->middleware('permission:edit-class-routine')->only(['edit', 'update']);
        $this->middleware('permission:delete-class-routine')->only(['destroy']);
        $this->middleware('permission:print-class-routine')->only(['print']);
    }

    public function index(Request $request)
    {
        $currentAcademicYear = AcademicYear::where('academic_year', date('Y'))->first();
        $academicYears = AcademicYear::orderBy('academic_year', 'desc')->get();
        $centers = Center::orderBy('center_name')->get();

        $selectedAcademicYear = $request->get('academic_year_id', $currentAcademicYear->id ?? null);
        $selectedCenter = $request->get('center_id');
        $selectedDay = $request->get('day_of_week');

        $query = ClassSchedule::with([
            'academicYear', 'center', 'subjectAllocation.module', 
            'subjectAllocation.user', 'venue', 'classDuration'
        ])
        ->active()
        ->current();

        if ($selectedAcademicYear) {
            $query->forAcademicYear($selectedAcademicYear);
        }

        if ($selectedCenter) {
            $query->forCenter($selectedCenter);
        }

        if ($selectedDay) {
            $query->forDay($selectedDay);
        }

        $schedules = $query->orderBy('day_of_week')
                          ->orderBy('class_duration_id')
                          ->get();

        $daysOfWeek = [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday', 
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday'
        ];

        return view('ClassRoutine.index', compact(
            'schedules', 'academicYears', 'centers', 'daysOfWeek',
            'selectedAcademicYear', 'selectedCenter', 'selectedDay'
        ));
    }

    public function create()
    {
        $currentAcademicYear = AcademicYear::where('academic_year', date('Y'))->first();
        $academicYears = AcademicYear::orderBy('academic_year', 'desc')->get();
        $centers = Center::orderBy('center_name')->get();
        $venues = Venue::with('center')->active()->orderBy('venue_name')->get();
        $classDurations = ClassDuration::active()->notBreak()->ordered()->get();
        $subjectAllocations = SubjectAllocation::with(['module', 'user', 'center'])
            ->where('academic_year_id', $currentAcademicYear->id ?? null)
            ->orderBy('id')
            ->get();

        $daysOfWeek = [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday', 
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday'
        ];

        return view('ClassRoutine.create', compact(
            'academicYears', 'centers', 'venues', 'classDurations', 
            'subjectAllocations', 'daysOfWeek', 'currentAcademicYear'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'center_id' => 'required|exists:centers,id',
            'subject_allocation_id' => 'required|exists:subject_allocations,id',
            'venue_id' => 'required|exists:venues,id',
            'class_duration_id' => 'required|exists:class_durations,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Check for teacher conflicts
        if (ClassSchedule::hasTeacherConflict(
            $request->subject_allocation_id,
            $request->class_duration_id,
            $request->day_of_week,
            $request->effective_from
        )) {
            return back()->withErrors(['conflict' => 'Teacher already has a class scheduled at this time.'])->withInput();
        }

        // Check for venue conflicts
        if (ClassSchedule::hasVenueConflict(
            $request->venue_id,
            $request->class_duration_id,
            $request->day_of_week,
            $request->effective_from
        )) {
            return back()->withErrors(['conflict' => 'Venue is already booked for this time slot.'])->withInput();
        }

        ClassSchedule::create([
            'academic_year_id' => $request->academic_year_id,
            'center_id' => $request->center_id,
            'subject_allocation_id' => $request->subject_allocation_id,
            'venue_id' => $request->venue_id,
            'class_duration_id' => $request->class_duration_id,
            'day_of_week' => $request->day_of_week,
            'effective_from' => $request->effective_from,
            'effective_to' => $request->effective_to,
            'notes' => $request->notes,
            'created_by' => Auth::id()
        ]);

        return redirect()->route('class-routine.index')
                        ->with('success', 'Class schedule created successfully.');
    }

    public function edit($id)
    {
        $schedule = ClassSchedule::with([
            'academicYear', 'center', 'subjectAllocation.module', 
            'subjectAllocation.user', 'venue', 'classDuration'
        ])->findOrFail($id);

        $academicYears = AcademicYear::orderBy('academic_year', 'desc')->get();
        $centers = Center::orderBy('center_name')->get();
        $venues = Venue::with('center')->active()->orderBy('venue_name')->get();
        $classDurations = ClassDuration::active()->notBreak()->ordered()->get();
        $subjectAllocations = SubjectAllocation::with(['module', 'user', 'center'])
            ->where('academic_year_id', $schedule->academic_year_id)
            ->orderBy('id')
            ->get();

        $daysOfWeek = [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday', 
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday'
        ];

        return view('ClassRoutine.edit', compact(
            'schedule', 'academicYears', 'centers', 'venues', 
            'classDurations', 'subjectAllocations', 'daysOfWeek'
        ));
    }

    public function update(Request $request, $id)
    {
        $schedule = ClassSchedule::findOrFail($id);

        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'center_id' => 'required|exists:centers,id',
            'subject_allocation_id' => 'required|exists:subject_allocations,id',
            'venue_id' => 'required|exists:venues,id',
            'class_duration_id' => 'required|exists:class_durations,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Check for teacher conflicts (excluding current schedule)
        if (ClassSchedule::hasTeacherConflict(
            $request->subject_allocation_id,
            $request->class_duration_id,
            $request->day_of_week,
            $request->effective_from,
            $id
        )) {
            return back()->withErrors(['conflict' => 'Teacher already has a class scheduled at this time.'])->withInput();
        }

        // Check for venue conflicts (excluding current schedule)
        if (ClassSchedule::hasVenueConflict(
            $request->venue_id,
            $request->class_duration_id,
            $request->day_of_week,
            $request->effective_from,
            $id
        )) {
            return back()->withErrors(['conflict' => 'Venue is already booked for this time slot.'])->withInput();
        }

        $schedule->update([
            'academic_year_id' => $request->academic_year_id,
            'center_id' => $request->center_id,
            'subject_allocation_id' => $request->subject_allocation_id,
            'venue_id' => $request->venue_id,
            'class_duration_id' => $request->class_duration_id,
            'day_of_week' => $request->day_of_week,
            'effective_from' => $request->effective_from,
            'effective_to' => $request->effective_to,
            'notes' => $request->notes
        ]);

        return redirect()->route('class-routine.index')
                        ->with('success', 'Class schedule updated successfully.');
    }

    public function destroy($id)
    {
        $schedule = ClassSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('class-routine.index')
                        ->with('success', 'Class schedule deleted successfully.');
    }

    public function print(Request $request)
    {
        $currentAcademicYear = AcademicYear::where('academic_year', date('Y'))->first();
        $selectedAcademicYear = $request->get('academic_year_id', $currentAcademicYear->id ?? null);
        $selectedCenter = $request->get('center_id');

        $query = ClassSchedule::with([
            'academicYear', 'center', 'subjectAllocation.module',
            'subjectAllocation.user', 'venue', 'classDuration'
        ])
        ->active()
        ->current();

        if ($selectedAcademicYear) {
            $query->forAcademicYear($selectedAcademicYear);
        }

        if ($selectedCenter) {
            $query->forCenter($selectedCenter);
        }

        $schedules = $query->orderBy('day_of_week')
                          ->orderBy('class_duration_id')
                          ->get();

        $academicYear = AcademicYear::find($selectedAcademicYear);
        $center = Center::find($selectedCenter);

        return view('ClassRoutine.print', compact('schedules', 'academicYear', 'center'));
    }
}
