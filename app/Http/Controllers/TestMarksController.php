<?php

namespace App\Http\Controllers;

use App\TestMark;
use App\Module;
use App\Student;
use App\AcademicYear;
use App\AssessmentWeight;
use App\AssessmentType;
use App\ModuleRegistration;
use App\SubjectAllocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TestMarksController extends Controller
{
    /**
     * Display a listing of modules with assessment weights for test marks capture
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $currentAcademicYear = AcademicYear::where('academic_year', date('Y'))->first();
        
        if (!$currentAcademicYear) {
            return redirect()->back()->with('error', 'No current academic year found.');
        }

        // Get modules that have assessment weights defined for current academic year
        $query = Module::whereHas('assessmentWeights', function($q) use ($currentAcademicYear) {
            $q->where('academic_year_id', $currentAcademicYear->id);
        })->with(['assessmentWeights' => function($q) use ($currentAcademicYear) {
            $q->where('academic_year_id', $currentAcademicYear->id)
              ->with('assessmentType');
        }]);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('subject_name', 'like', "%{$search}%")
                  ->orWhere('subject_code', 'like', "%{$search}%");
            });
        }

        $modules = $query->get();

        // Get all modules allocated to the current user (including those without assessment weights)
        $userAllocations = SubjectAllocation::with(['module.assessmentWeights' => function($q) use ($currentAcademicYear) {
                $q->where('academic_year_id', $currentAcademicYear->id)
                  ->with('assessmentType');
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

        return view('Assessments.TestMarks.index', compact('modulesWithCentres', 'search', 'currentAcademicYear'));
    }

    /**
     * Show assessments for a specific module and centre
     */
    public function showAssessments($moduleId, $centreId)
    {
        $module = Module::findOrFail($moduleId);
        $centre = \App\Center::findOrFail($centreId);
        $currentAcademicYear = AcademicYear::where('academic_year', date('Y'))->first();
        
        if (!$currentAcademicYear) {
            return redirect()->back()->with('error', 'No current academic year found.');
        }

        $assessmentWeights = AssessmentWeight::where('module_id', $moduleId)
            ->where('academic_year_id', $currentAcademicYear->id)
            ->with('assessmentType')
            ->get();

        if ($assessmentWeights->isEmpty()) {
            return redirect()->back()->with('error', 'No assessment weights defined for this module.');
        }

        return view('Assessments.TestMarks.assessments', compact('module', 'centre', 'assessmentWeights', 'currentAcademicYear'));
    }

    /**
     * Show students for marks capture for a specific assessment
     */
    public function captureMarks($moduleId, $centreId, $assessmentTypeId, Request $request)
    {
        $module = Module::findOrFail($moduleId);
        $centre = \App\Center::findOrFail($centreId);
        $assessmentType = AssessmentType::findOrFail($assessmentTypeId);
        $currentAcademicYear = AcademicYear::where('academic_year', date('Y'))->first();
        
        if (!$currentAcademicYear) {
            return redirect()->back()->with('error', 'No current academic year found.');
        }

        $assessmentWeight = AssessmentWeight::where('module_id', $moduleId)
            ->where('academic_year_id', $currentAcademicYear->id)
            ->where('assessment_type_id', $assessmentTypeId)
            ->first();

        if (!$assessmentWeight) {
            return redirect()->back()->with('error', 'Assessment weight not found for this module and assessment type.');
        }

        $search = $request->get('search');

        // Get students registered for this module in current academic year, filtered by centre
        $query = Student::where('center_id', $centreId)
            ->whereHas('registered_modules', function($q) use ($moduleId, $currentAcademicYear) {
                $q->where('module_id', $moduleId)
                  ->where('academic_year', $currentAcademicYear->academic_year);
            })->with(['testMarks' => function($q) use ($moduleId, $assessmentTypeId, $currentAcademicYear) {
                $q->where('module_id', $moduleId)
                  ->where('assessment_type_id', $assessmentTypeId)
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

        // Get existing total marks for this assessment if any marks have been captured
        $existingTotalMarks = TestMark::where('module_id', $moduleId)
            ->where('assessment_type_id', $assessmentTypeId)
            ->where('academic_year_id', $currentAcademicYear->id)
            ->value('total_marks');

        return view('Assessments.TestMarks.capture', compact(
            'module', 'centre', 'assessmentType', 'assessmentWeight', 'currentAcademicYear', 'students', 'search', 'existingTotalMarks'
        ));
    }

    /**
     * Store or update test marks
     */
    public function storeMarks(Request $request, $moduleId, $centreId, $assessmentTypeId)
    {
        $request->validate([
            'marks' => 'required|array',
            'marks.*' => 'nullable|numeric|min:0',
            'total_marks' => 'required|numeric|min:1|max:1000'
        ]);

        // Validate that individual marks don't exceed total marks
        $totalMarks = $request->input('total_marks');
        $request->validate([
            'marks.*' => "nullable|numeric|min:0|max:{$totalMarks}"
        ]);

        $currentAcademicYear = AcademicYear::where('academic_year', date('Y'))->first();
        $totalMarks = $request->input('total_marks');

        DB::beginTransaction();
        try {
            foreach ($request->input('marks') as $studentId => $marksObtained) {
                if ($marksObtained !== null && $marksObtained !== '') {
                    TestMark::updateOrCreate(
                        [
                            'student_id' => $studentId,
                            'module_id' => $moduleId,
                            'academic_year_id' => $currentAcademicYear->id,
                            'assessment_type_id' => $assessmentTypeId,
                        ],
                        [
                            'marks_obtained' => $marksObtained,
                            'total_marks' => $totalMarks,
                            'captured_at' => Carbon::now(),
                            'captured_by' => Auth::id(),
                        ]
                    );
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Test marks saved successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error saving marks: ' . $e->getMessage());
        }
    }

    /**
     * View all marks for a module with CA calculations
     */
    public function viewAll($moduleId, $centreId)
    {
        $module = Module::findOrFail($moduleId);
        $currentAcademicYear = AcademicYear::where('academic_year', date('Y'))->first();
        
        if (!$currentAcademicYear) {
            return redirect()->back()->with('error', 'No current academic year found.');
        }

        // Get assessment weights for this module
        $assessmentWeights = AssessmentWeight::where('module_id', $moduleId)
            ->where('academic_year_id', $currentAcademicYear->id)
            ->with('assessmentType')
            ->orderBy('assessment_type_id')
            ->get();

        if ($assessmentWeights->isEmpty()) {
            return redirect()->back()->with('error', 'No assessment weights defined for this module.');
        }

        // Get students registered for this module, filtered by centre
        $centre = \App\Center::findOrFail($centreId);
        $students = Student::where('center_id', $centreId)
            ->whereHas('registered_modules', function($q) use ($moduleId, $currentAcademicYear) {
                $q->where('module_id', $moduleId)
                  ->where('academic_year', $currentAcademicYear->academic_year);
            })->with(['testMarks' => function($q) use ($moduleId, $currentAcademicYear) {
                $q->where('module_id', $moduleId)
                  ->where('academic_year_id', $currentAcademicYear->id)
                  ->with('assessmentType');
            }])->orderBy('surname')->orderBy('student_names')->get();

        // Calculate CA marks for each student
        $studentsWithCA = $students->map(function($student) use ($assessmentWeights) {
            $studentMarks = $student->testMarks->keyBy('assessment_type_id');
            $caTotal = 0;
            $assessmentData = [];

            foreach ($assessmentWeights as $weight) {
                $mark = $studentMarks->get($weight->assessment_type_id);
                $percentage = 0;
                $weightedMark = 0;

                if ($mark && $mark->marks_obtained !== null && $mark->total_marks > 0) {
                    $percentage = ($mark->marks_obtained / $mark->total_marks) * 100;
                    $weightedMark = ($percentage * $weight->weight) / 100;
                    $caTotal += $weightedMark;
                }

                $assessmentData[] = [
                    'assessment_type' => $weight->assessmentType,
                    'weight' => $weight->weight,
                    'marks_obtained' => $mark ? $mark->marks_obtained : null,
                    'total_marks' => $mark ? $mark->total_marks : null,
                    'percentage' => round($percentage, 2),
                    'weighted_mark' => round($weightedMark, 2)
                ];
            }

            $student->ca_total = round($caTotal, 2);
            $student->assessment_data = $assessmentData;
            return $student;
        });

        return view('Assessments.TestMarks.view_all', compact(
            'module', 'centre', 'currentAcademicYear', 'assessmentWeights', 'studentsWithCA'
        ));
    }

    /**
     * Delete a test mark
     */
    public function destroy($id)
    {
        $testMark = TestMark::findOrFail($id);
        $testMark->delete();

        return redirect()->back()->with('success', 'Test mark deleted successfully.');
    }
}
