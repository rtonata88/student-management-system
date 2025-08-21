<?php

namespace App\Http\Controllers;

use App\ExaminationSchedule;
use App\AcademicYear;
use App\Center;
use App\AssessmentType;
use App\SubjectAllocation;
use App\Venue;
use App\ClassDuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExaminationScheduleController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermission('view-examination-schedule')) {
            abort(403, 'Unauthorized action.');
        }

        $currentAcademicYear = AcademicYear::where('status', 'Current')->first();
        $search = $request->get('search');
        $centerId = $request->get('center_id');
        $examinationId = $request->get('examination_id');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $query = ExaminationSchedule::with([
            'academicYear', 'center', 'examination', 'subjectAllocation.module', 
            'subjectAllocation.user', 'venue', 'classDuration'
        ])
        ->active()
        ->forAcademicYear($currentAcademicYear->id);

        if ($search) {
            $query->whereHas('subjectAllocation.module', function($q) use ($search) {
                $q->where('subject_name', 'like', "%{$search}%")
                  ->orWhere('subject_code', 'like', "%{$search}%");
            });
        }

        if ($centerId) {
            $query->forCenter($centerId);
        }

        if ($examinationId) {
            $query->forExamination($examinationId);
        }

        if ($dateFrom) {
            $query->where('exam_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->where('exam_date', '<=', $dateTo);
        }

        $schedules = $query->orderBy('exam_date')
                          ->orderBy('class_duration_id')
                          ->paginate(20);

        $centers = Center::all();
        $examinations = AssessmentType::all();

        return view('Assessments.ExaminationSchedule.index', compact(
            'schedules', 'currentAcademicYear', 'search', 'centers', 
            'examinations', 'centerId', 'examinationId', 'dateFrom', 'dateTo'
        ));
    }

    public function create()
    {
        if (!Auth::user()->hasPermission('create-examination-schedule')) {
            abort(403, 'Unauthorized action.');
        }

        $currentAcademicYear = AcademicYear::where('status', 'Current')->first();
        $centers = Center::all();
        $examinations = AssessmentType::all();
        $venues = Venue::active()->get();
        $classDurations = ClassDuration::active()->notBreak()->ordered()->get();
        $subjectAllocations = SubjectAllocation::with(['module', 'user', 'center'])
            ->where('academic_year_id', $currentAcademicYear->id)
            ->get();

        return view('Assessments.ExaminationSchedule.create', compact(
            'currentAcademicYear', 'centers', 'examinations', 'venues', 
            'classDurations', 'subjectAllocations'
        ));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('create-examination-schedule')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'center_id' => 'required|exists:centers,id',
            'examination_id' => 'required|exists:assessment_types,id',
            'subject_allocation_id' => 'required|exists:subject_allocations,id',
            'venue_id' => 'required|exists:venues,id',
            'class_duration_id' => 'required|exists:class_durations,id',
            'exam_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:1000'
        ]);

        $currentAcademicYear = AcademicYear::where('status', 'Current')->first();

        // Check for conflicts
        $teacherConflict = ExaminationSchedule::hasTeacherConflict(
            $request->subject_allocation_id,
            $request->class_duration_id,
            $request->exam_date
        );

        $venueConflict = ExaminationSchedule::hasVenueConflict(
            $request->venue_id,
            $request->class_duration_id,
            $request->exam_date
        );

        if ($teacherConflict) {
            return back()->withErrors(['conflict' => 'Teacher has another exam scheduled at the same time.']);
        }

        if ($venueConflict) {
            return back()->withErrors(['conflict' => 'Venue is already booked at this time.']);
        }

        ExaminationSchedule::create([
            'academic_year_id' => $currentAcademicYear->id,
            'center_id' => $request->center_id,
            'examination_id' => $request->examination_id,
            'subject_allocation_id' => $request->subject_allocation_id,
            'venue_id' => $request->venue_id,
            'class_duration_id' => $request->class_duration_id,
            'exam_date' => $request->exam_date,
            'notes' => $request->notes,
            'created_by' => Auth::id()
        ]);

        return redirect()->route('examination-schedule.index')
                        ->with('success', 'Examination schedule created successfully.');
    }

    public function edit($id)
    {
        if (!Auth::user()->hasPermission('edit-examination-schedule')) {
            abort(403, 'Unauthorized action.');
        }

        $schedule = ExaminationSchedule::with([
            'academicYear', 'center', 'examination', 'subjectAllocation.module',
            'venue', 'classDuration'
        ])->findOrFail($id);

        $centers = Center::all();
        $examinations = AssessmentType::all();
        $venues = Venue::active()->get();
        $classDurations = ClassDuration::active()->notBreak()->ordered()->get();
        $subjectAllocations = SubjectAllocation::with(['module', 'user', 'center'])
            ->where('academic_year_id', $schedule->academic_year_id)
            ->get();

        return view('Assessments.ExaminationSchedule.edit', compact(
            'schedule', 'centers', 'examinations', 'venues', 
            'classDurations', 'subjectAllocations'
        ));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->hasPermission('edit-examination-schedule')) {
            abort(403, 'Unauthorized action.');
        }

        $schedule = ExaminationSchedule::findOrFail($id);

        $request->validate([
            'center_id' => 'required|exists:centers,id',
            'examination_id' => 'required|exists:assessment_types,id',
            'subject_allocation_id' => 'required|exists:subject_allocations,id',
            'venue_id' => 'required|exists:venues,id',
            'class_duration_id' => 'required|exists:class_durations,id',
            'exam_date' => 'required|date',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Check for conflicts (excluding current record)
        $teacherConflict = ExaminationSchedule::hasTeacherConflict(
            $request->subject_allocation_id,
            $request->class_duration_id,
            $request->exam_date,
            $id
        );

        $venueConflict = ExaminationSchedule::hasVenueConflict(
            $request->venue_id,
            $request->class_duration_id,
            $request->exam_date,
            $id
        );

        if ($teacherConflict) {
            return back()->withErrors(['conflict' => 'Teacher has another exam scheduled at the same time.']);
        }

        if ($venueConflict) {
            return back()->withErrors(['conflict' => 'Venue is already booked at this time.']);
        }

        $schedule->update([
            'center_id' => $request->center_id,
            'examination_id' => $request->examination_id,
            'subject_allocation_id' => $request->subject_allocation_id,
            'venue_id' => $request->venue_id,
            'class_duration_id' => $request->class_duration_id,
            'exam_date' => $request->exam_date,
            'notes' => $request->notes
        ]);

        return redirect()->route('examination-schedule.index')
                        ->with('success', 'Examination schedule updated successfully.');
    }

    public function destroy($id)
    {
        if (!Auth::user()->hasPermission('delete-examination-schedule')) {
            abort(403, 'Unauthorized action.');
        }

        $schedule = ExaminationSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('examination-schedule.index')
                        ->with('success', 'Examination schedule deleted successfully.');
    }

    public function timetable(Request $request)
    {
        if (!Auth::user()->hasPermission('view-examination-schedule')) {
            abort(403, 'Unauthorized action.');
        }

        $currentAcademicYear = AcademicYear::where('status', 'Current')->first();
        $centerId = $request->get('center_id');
        $examinationId = $request->get('examination_id');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $query = ExaminationSchedule::with([
            'center', 'examination', 'subjectAllocation.module', 
            'subjectAllocation.user', 'venue', 'classDuration'
        ])
        ->active()
        ->forAcademicYear($currentAcademicYear->id);

        if ($centerId) {
            $query->forCenter($centerId);
        }

        if ($examinationId) {
            $query->forExamination($examinationId);
        }

        if ($dateFrom) {
            $query->where('exam_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->where('exam_date', '<=', $dateTo);
        }

        $schedules = $query->orderBy('exam_date')
                          ->orderBy('class_duration_id')
                          ->get();

        // Group schedules by date
        $groupedSchedules = $schedules->groupBy(function($schedule) {
            return $schedule->exam_date->format('Y-m-d');
        });

        $centers = Center::all();
        $examinations = AssessmentType::all();

        return view('Assessments.ExaminationSchedule.timetable', compact(
            'groupedSchedules', 'currentAcademicYear', 'centers', 
            'examinations', 'centerId', 'examinationId', 'dateFrom', 'dateTo'
        ));
    }

    public function print(Request $request)
    {
        if (!Auth::user()->hasPermission('print-examination-schedule')) {
            abort(403, 'Unauthorized action.');
        }

        $currentAcademicYear = AcademicYear::where('status', 'Current')->first();
        $centerId = $request->get('center_id');
        $examinationId = $request->get('examination_id');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $query = ExaminationSchedule::with([
            'center', 'examination', 'subjectAllocation.module', 
            'subjectAllocation.user', 'venue', 'classDuration'
        ])
        ->active()
        ->forAcademicYear($currentAcademicYear->id);

        if ($centerId) {
            $query->forCenter($centerId);
        }

        if ($examinationId) {
            $query->forExamination($examinationId);
        }

        if ($dateFrom) {
            $query->where('exam_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->where('exam_date', '<=', $dateTo);
        }

        $schedules = $query->orderBy('exam_date')
                          ->orderBy('class_duration_id')
                          ->get();

        // Group schedules by date
        $groupedSchedules = $schedules->groupBy(function($schedule) {
            return $schedule->exam_date->format('Y-m-d');
        });

        $company = \App\Company::first();
        $center = $centerId ? Center::find($centerId) : null;
        $examination = $examinationId ? AssessmentType::find($examinationId) : null;

        return view('Assessments.ExaminationSchedule.print', compact(
            'groupedSchedules', 'currentAcademicYear', 'company', 
            'center', 'examination', 'dateFrom', 'dateTo'
        ));
    }

    public function getSubjectAllocations(Request $request)
    {
        $centerId = $request->get('center_id');
        $currentAcademicYear = AcademicYear::where('status', 'Current')->first();

        $allocations = SubjectAllocation::with(['module', 'user'])
            ->where('center_id', $centerId)
            ->where('academic_year_id', $currentAcademicYear->id)
            ->get();

        return response()->json($allocations);
    }

    public function getVenues(Request $request)
    {
        $centerId = $request->get('center_id');

        $venues = Venue::active()
            ->byCenter($centerId)
            ->get();

        return response()->json($venues);
    }

    public function checkConflicts(Request $request)
    {
        $subjectAllocationId = $request->get('subject_allocation_id');
        $classDurationId = $request->get('class_duration_id');
        $examDate = $request->get('exam_date');
        $venueId = $request->get('venue_id');
        $excludeId = $request->get('exclude_id');

        $conflicts = [];

        if ($subjectAllocationId && $classDurationId && $examDate) {
            $teacherConflict = ExaminationSchedule::hasTeacherConflict(
                $subjectAllocationId, $classDurationId, $examDate, $excludeId
            );
            if ($teacherConflict) {
                $conflicts[] = 'Teacher has another exam at the same time';
            }
        }

        if ($venueId && $classDurationId && $examDate) {
            $venueConflict = ExaminationSchedule::hasVenueConflict(
                $venueId, $classDurationId, $examDate, $excludeId
            );
            if ($venueConflict) {
                $conflicts[] = 'Venue is already booked at this time';
            }
        }

        return response()->json(['conflicts' => $conflicts]);
    }
}
