<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;
use App\ExamMark;
use App\Student;
use App\AcademicYear;
use App\AssessmentType;
use App\ExamPaper;
use App\ExamPaperWeight;
use App\SubjectAllocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamMarksController extends Controller
{
    /**
     * Display a listing of exam types for module selection
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $currentAcademicYear = AcademicYear::where('academic_year', date('Y'))->first();

        if (!$currentAcademicYear) {
            return redirect()->back()->with('error', 'No current academic year found.');
        }

        // Get modules that have exam paper weights defined for current academic year
        $query = Module::whereHas('examPaperWeights', function($q) use ($currentAcademicYear) {
            $q->where('academic_year_id', $currentAcademicYear->id);
        })->with(['examPaperWeights' => function($q) use ($currentAcademicYear) {
            $q->where('academic_year_id', $currentAcademicYear->id)
              ->with(['examination', 'examPaper']);
        }]);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('subject_name', 'like', "%{$search}%")
                  ->orWhere('subject_code', 'like', "%{$search}%");
            });
        }

        $modules = $query->get();

        // Get all modules allocated to the current user (including those without exam paper weights)
        $userAllocations = SubjectAllocation::with(['module.examPaperWeights' => function($q) use ($currentAcademicYear) {
                $q->where('academic_year_id', $currentAcademicYear->id)
                  ->with(['examination', 'examPaper']);
            }, 'center', 'user'])
            ->where('user_id', Auth::id())
            ->where('academic_year_id', $currentAcademicYear->id)
            ->get();

        // Filter by search if provided
        if ($search) {
            $userAllocations = $userAllocations->filter(function($allocation) use ($search) {
                return stripos($allocation->module->subject_name, $search) !== false ||
                       stripos($allocation->module->subject_code, $search) !== false;
            });
        }

        $modulesWithCentres = [];
        foreach ($userAllocations as $allocation) {
            // Get the teacher name (should be current user)
            $teacherName = 'Not Assigned';
            if ($allocation->user) {
                $fullName = trim($allocation->user->surname . ' ' . $allocation->user->other_names);
                $teacherName = !empty($fullName) ? $fullName : $allocation->user->name;
            }

            $modulesWithCentres[] = [
                'module' => $allocation->module,
                'centre_id' => $allocation->center->id,
                'centre_name' => $allocation->center->center_name,
                'teacher_name' => $teacherName,
                'allocation' => $allocation
            ];
        }

        return view('Assessments.ExamMarks.index', compact('modulesWithCentres', 'search', 'currentAcademicYear'));
    }

    /**
     * Show modules for a specific exam type
     */
    public function showModules($examTypeId, Request $request)
    {
        $search = $request->get('search');
        $examTypes = AssessmentType::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })->get();
        $currentAcademicYear = AcademicYear::where('academic_year', date('Y'))->first();

        if (!$currentAcademicYear) {
            return redirect()->back()->with('error', 'No current academic year found.');
        }

        // Get modules that have exam paper weights defined for current academic year and exam type
        $query = Module::whereHas('examPaperWeights', function($q) use ($currentAcademicYear, $examTypeId) {
            $q->where('academic_year_id', $currentAcademicYear->id)
              ->where('examination_id', $examTypeId);
        })->with(['examPaperWeights' => function($q) use ($currentAcademicYear, $examTypeId) {
            $q->where('academic_year_id', $currentAcademicYear->id)
              ->where('examination_id', $examTypeId)
              ->with('examPaper');
        }]);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('subject_name', 'like', "%{$search}%")
                  ->orWhere('subject_code', 'like', "%{$search}%");
            });
        }

        $modules = $query->get();

        // Get all centres and show each module for every centre
        $allCentres = \App\Center::all();
        $modulesWithCentres = [];
        
        foreach ($modules as $module) {
            foreach ($allCentres as $centre) {
                $modulesWithCentres[] = [
                    'module' => $module,
                    'centre_id' => $centre->id,
                    'centre_name' => $centre->center_name
                ];
            }
        }

        return view('Assessments.ExamMarks.modules', compact('examType', 'modulesWithCentres', 'search', 'currentAcademicYear'));
    }

    /**
     * Show exam papers for a specific module, centre and exam type
     */
    public function showExamPapers($examTypeId, $moduleId, $centreId)
    {
        $examType = AssessmentType::findOrFail($examTypeId);
        $module = Module::findOrFail($moduleId);
        $centre = \App\Center::findOrFail($centreId);
        $currentAcademicYear = AcademicYear::where('academic_year', date('Y'))->first();
        
        if (!$currentAcademicYear) {
            return redirect()->back()->with('error', 'No current academic year found.');
        }

        $examPaperWeights = ExamPaperWeight::where('module_id', $moduleId)
            ->where('academic_year_id', $currentAcademicYear->id)
            ->where('examination_id', $examTypeId)
            ->with('examPaper')
            ->get();

        if ($examPaperWeights->isEmpty()) {
            return redirect()->back()->with('error', 'No exam paper weights defined for this module and exam type.');
        }

        return view('Assessments.ExamMarks.exam_papers', compact('examType', 'module', 'centre', 'examPaperWeights', 'currentAcademicYear'));
    }

    /**
     * Show students for marks capture for a specific exam paper
     */
    public function captureMarks($examTypeId, $moduleId, $centreId, $examPaperId, Request $request)
    {
        $examType = AssessmentType::findOrFail($examTypeId);
        $module = Module::findOrFail($moduleId);
        $centre = \App\Center::findOrFail($centreId);
        $examPaper = ExamPaper::findOrFail($examPaperId);
        $currentAcademicYear = AcademicYear::where('academic_year', date('Y'))->first();
        
        if (!$currentAcademicYear) {
            return redirect()->back()->with('error', 'No current academic year found.');
        }
        
        $examPaperWeight = ExamPaperWeight::where('module_id', $moduleId)
            ->where('academic_year_id', $currentAcademicYear->id)
            ->where('examination_id', $examTypeId)
            ->where('paper_code', $examPaper->paper_code)
            ->first();

        if (!$examPaperWeight) {
            return redirect()->back()->with('error', 'Exam paper weight not found for this module and exam paper.');
        }

        $search = $request->get('search');

        // Get students registered for this module in current academic year, filtered by centre
        $query = Student::where('center_id', $centreId)
            ->whereHas('registered_modules', function($q) use ($moduleId, $currentAcademicYear) {
                $q->where('module_id', $moduleId)
                  ->where('academic_year', $currentAcademicYear->academic_year);
            })->with(['examMarks' => function($q) use ($moduleId, $examTypeId, $examPaperId, $currentAcademicYear) {
                $q->where('module_id', $moduleId)
                  ->where('exam_type_id', $examTypeId)
                  ->where('exam_paper_id', $examPaperId)
                  ->where('academic_year_id', $currentAcademicYear->id);
            }, 'center']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('student_number2', 'like', "%{$search}%")
                  ->orWhere('surname', 'like', "%{$search}%")
                  ->orWhere('student_names', 'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('surname')->orderBy('student_names')->get();

        return view('Assessments.ExamMarks.capture', compact(
            'examType', 'module', 'centre', 'examPaper', 'examPaperWeight', 'currentAcademicYear', 'students', 'search'
        ));
    }

    /**
     * Store or update exam marks
     */
    public function storeMarks(Request $request, $examTypeId, $moduleId, $centreId, $examPaperId)
    {
        $request->validate([
            'marks' => 'required|array',
            'marks.*' => 'nullable|numeric|min:0',
            'total_marks' => 'required|numeric|min:1|max:1000'
        ]);

        $currentAcademicYear = AcademicYear::where('academic_year', date('Y'))->first();
        $totalMarks = $request->input('total_marks');

        DB::beginTransaction();
        try {
            foreach ($request->input('marks') as $studentId => $marksObtained) {
                if ($marksObtained !== null && $marksObtained !== '') {
                    ExamMark::updateOrCreate(
                        [
                            'student_id' => $studentId,
                            'module_id' => $moduleId,
                            'academic_year_id' => $currentAcademicYear->id,
                            'exam_type_id' => $examTypeId,
                            'exam_paper_id' => $examPaperId,
                        ],
                        [
                            'marks_obtained' => $marksObtained,
                            'total_marks' => $totalMarks,
                            'captured_by' => Auth::id(),
                        ]
                    );
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Exam marks saved successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error saving marks: ' . $e->getMessage());
        }
    }

    /**
     * View all marks for a module with exam calculations
     */
    public function viewAll($examTypeId, $moduleId, $centreId)
    {
        $examType = AssessmentType::findOrFail($examTypeId);
        $module = Module::findOrFail($moduleId);
        $centre = \App\Center::findOrFail($centreId);
        $currentAcademicYear = AcademicYear::where('academic_year', date('Y'))->first();
        
        if (!$currentAcademicYear) {
            return redirect()->back()->with('error', 'No current academic year found.');
        }

        // Get exam paper weights for this module and exam type
        $examPaperWeights = ExamPaperWeight::where('module_id', $moduleId)
            ->where('academic_year_id', $currentAcademicYear->id)
            ->where('examination_id', $examTypeId)
            ->with('examPaper')
            ->orderBy('exam_paper_id')
            ->get();

        if ($examPaperWeights->isEmpty()) {
            return redirect()->back()->with('error', 'No exam paper weights defined for this module and exam type.');
        }

        // Get students registered for this module, filtered by centre
        $students = Student::where('center_id', $centreId)
            ->whereHas('registered_modules', function($q) use ($moduleId, $currentAcademicYear) {
                $q->where('module_id', $moduleId)
                  ->where('academic_year', $currentAcademicYear->academic_year);
            })->with(['examMarks' => function($q) use ($moduleId, $examTypeId, $currentAcademicYear) {
                $q->where('module_id', $moduleId)
                  ->where('exam_type_id', $examTypeId)
                  ->where('academic_year_id', $currentAcademicYear->id)
                  ->with('examPaper');
            }])->orderBy('surname')->orderBy('student_names')->get();

        // Calculate exam totals for each student
        $studentsWithExamTotals = $students->map(function($student) use ($examPaperWeights) {
            $studentMarks = $student->examMarks->keyBy('exam_paper_id');
            $examTotal = 0;
            $examData = [];

            foreach ($examPaperWeights as $weight) {
                $mark = $studentMarks->get($weight->exam_paper_id);
                $percentage = 0;
                $weightedMark = 0;

                if ($mark && $mark->total_marks > 0) {
                    $percentage = ($mark->marks_obtained / $mark->total_marks) * 100;
                    $weightedMark = ($percentage * $weight->weight) / 100;
                    $examTotal += $weightedMark;
                }

                $examData[] = [
                    'exam_paper' => $weight->examPaper,
                    'weight' => $weight->weight,
                    'marks_obtained' => $mark ? $mark->marks_obtained : null,
                    'total_marks' => $mark ? $mark->total_marks : null,
                    'percentage' => round($percentage, 2),
                    'weighted_mark' => round($weightedMark, 2)
                ];
            }

            $student->exam_total = round($examTotal, 2);
            $student->exam_data = $examData;
            return $student;
        });

        return view('Assessments.ExamMarks.view_all', compact(
            'examType', 'module', 'centre', 'currentAcademicYear', 'examPaperWeights', 'studentsWithExamTotals'
        ));
    }

    /**
     * Delete an exam mark
     */
    public function destroy($id)
    {
        $examMark = ExamMark::findOrFail($id);
        $examMark->delete();

        return redirect()->back()->with('success', 'Exam mark deleted successfully.');
    }
}
