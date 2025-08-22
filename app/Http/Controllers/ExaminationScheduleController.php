<?php

namespace App\Http\Controllers;

use App\ExaminationSchedule;
use App\AcademicYear;
use App\Center;
use App\Examination;
use App\SubjectAllocation;
use App\Venue;
use App\ClassDuration;
use App\User;
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

        $currentAcademicYear = AcademicYear::where('status', 1)->first();
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
        $examinations = Examination::active()->get();

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

        $currentAcademicYear = AcademicYear::where('status', 1)->first();
        $centers = Center::all();
        $examinations = Examination::active()->get();
        $venues = Venue::active()->get();
        $classDurations = ClassDuration::active()->notBreak()->ordered()->get();
        $users = User::orderBy('name')->get();
        $subjectAllocations = SubjectAllocation::with(['module', 'user', 'center'])
            ->where('academic_year_id', $currentAcademicYear->id)
            ->get();

        return view('Assessments.ExaminationSchedule.create', compact(
            'currentAcademicYear', 'centers', 'examinations', 'venues', 
            'classDurations', 'subjectAllocations', 'users'
        ));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('create-examination-schedule')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'center_id' => 'required|exists:centers,id',
            'examination_id' => 'required|exists:examinations,id',
            'module_id' => 'required|exists:modules,id',
            'head_invigilator_id' => 'required|exists:users,id',
            'venue_id' => 'required|exists:venues,id',
            'class_duration_id' => 'required|exists:class_durations,id',
            'exam_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:1000'
        ]);

        $currentAcademicYear = AcademicYear::where('status', 1)->first();

        // Check for head invigilator conflicts
        $invigilatorConflict = ExaminationSchedule::where('head_invigilator_id', $request->head_invigilator_id)
            ->where('class_duration_id', $request->class_duration_id)
            ->where('exam_date', $request->exam_date)
            ->exists();

        $venueConflict = ExaminationSchedule::where('venue_id', $request->venue_id)
            ->where('class_duration_id', $request->class_duration_id)
            ->where('exam_date', $request->exam_date)
            ->exists();

        if ($invigilatorConflict) {
            return back()->withErrors(['conflict' => 'Head Invigilator has another exam scheduled at the same time.']);
        }

        if ($venueConflict) {
            return back()->withErrors(['conflict' => 'Venue is already booked at this time.']);
        }

        ExaminationSchedule::create([
            'academic_year_id' => $currentAcademicYear->id,
            'center_id' => $request->center_id,
            'examination_id' => $request->examination_id,
            'subject_id' => $request->module_id,
            'head_invigilator_id' => $request->head_invigilator_id,
            'subject_allocation_id' => null,
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
        $examinations = Examination::active()->get();
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
            'examination_id' => 'required|exists:examinations,id',
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

        $currentAcademicYear = AcademicYear::where('status', 1)->first();
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
        $examinations = Examination::active()->get();

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

        $currentAcademicYear = AcademicYear::where('status', 1)->first();
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

        $company = \App\CompanySetup::first();
        $center = $centerId ? Center::find($centerId) : null;
        $examination = $examinationId ? Examination::find($examinationId) : null;

        return view('Assessments.ExaminationSchedule.print', compact(
            'groupedSchedules', 'currentAcademicYear', 'company', 
            'center', 'examination', 'dateFrom', 'dateTo'
        ));
    }

    public function getSubjectAllocations(Request $request)
    {
        $centerId = $request->get('center_id');
        $currentAcademicYear = AcademicYear::where('status', 1)->first();

        $allocations = SubjectAllocation::with(['module', 'user'])
            ->where('center_id', $centerId)
            ->where('academic_year_id', $currentAcademicYear->id)
            ->get();

        return response()->json($allocations);
    }

    public function getModules(Request $request)
    {
        $centerId = $request->get('center_id');
        $currentAcademicYear = AcademicYear::where('status', 1)->first();
        
        if (!$currentAcademicYear) {
            // Fallback to latest academic year if no current year is set
            $currentAcademicYear = AcademicYear::latest()->first();
        }
        
        if (!$currentAcademicYear) {
            return response()->json([]);
        }

        // Get all modules and mark which ones are allocated to this centre
        $modules = \App\Module::all();
        $allocatedModuleIds = \App\SubjectAllocation::where('center_id', $centerId)
            ->where('academic_year_id', $currentAcademicYear->id)
            ->pluck('subject_id')
            ->toArray();

        $modules->each(function($module) use ($allocatedModuleIds) {
            $module->is_allocated = in_array($module->id, $allocatedModuleIds);
        });

        return response()->json($modules);
    }

    public function getTeachers(Request $request)
    {
        $moduleId = $request->get('module_id');
        $centerId = $request->get('center_id');
        $currentAcademicYear = AcademicYear::where('status', 1)->first();
        
        if (!$currentAcademicYear) {
            // Fallback to latest academic year if no current year is set
            $currentAcademicYear = AcademicYear::latest()->first();
        }
        
        if (!$currentAcademicYear) {
            return response()->json([]);
        }

        // Get all teachers and mark which ones are allocated to this subject/centre
        $allocatedTeachers = \App\User::whereHas('subjectAllocations', function($query) use ($moduleId, $centerId, $currentAcademicYear) {
            $query->where('subject_id', $moduleId)
                  ->where('center_id', $centerId)
                  ->where('academic_year_id', $currentAcademicYear->id);
        })->get();

        // Get all teachers with teacher role for fallback
        $allTeachers = \App\User::whereHas('roles', function($query) {
            $query->where('name', 'Teacher');
        })->get();

        // Mark allocated teachers
        $allocatedTeacherIds = $allocatedTeachers->pluck('id')->toArray();
        $allTeachers->each(function($teacher) use ($allocatedTeacherIds) {
            $teacher->is_allocated = in_array($teacher->id, $allocatedTeacherIds);
        });

        return response()->json($allTeachers);
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
        $teacherId = $request->get('head_invigilator_id');
        $classDurationId = $request->get('class_duration_id');
        $examDate = $request->get('exam_date');
        $venueId = $request->get('venue_id');
        $excludeId = $request->get('exclude_id');

        $conflicts = [];

        if ($teacherId && $classDurationId && $examDate) {
            // Check if teacher has another exam at the same time
            $teacherConflict = ExaminationSchedule::whereHas('subjectAllocation', function($query) use ($teacherId) {
                $query->where('user_id', $teacherId);
            })
            ->where('class_duration_id', $classDurationId)
            ->where('exam_date', $examDate)
            ->when($excludeId, function($query) use ($excludeId) {
                $query->where('id', '!=', $excludeId);
            })
            ->exists();
            
            if ($teacherConflict) {
                $conflicts[] = 'Teacher has another exam at the same time';
            }
        }

        if ($venueId && $classDurationId && $examDate) {
            $venueConflict = ExaminationSchedule::where('venue_id', $venueId)
                ->where('class_duration_id', $classDurationId)
                ->where('exam_date', $examDate)
                ->when($excludeId, function($query) use ($excludeId) {
                    $query->where('id', '!=', $excludeId);
                })
                ->exists();
                
            if ($venueConflict) {
                $conflicts[] = 'Venue is already booked at this time';
            }
        }

        return response()->json(['conflicts' => $conflicts]);
    }
}
