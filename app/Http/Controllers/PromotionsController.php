<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\StudentPromotion;
use App\PromotionalStatus;
use App\AcademicYear;
use App\Center;
use App\ExamMark;
use App\ModuleRegistration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PromotionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the student promotions search page
     */
    public function index()
    {
        if (!Auth::user()->hasPermission('view-student-promotions')) {
            abort(403, 'Unauthorized action.');
        }

        $academicYears = AcademicYear::orderBy('academic_year', 'desc')->get();
        $centers = Center::orderBy('center_name')->get();

        return view('promotions.index', compact('academicYears', 'centers'));
    }

    /**
     * Search and filter students for promotion
     */
    public function search(Request $request)
    {
        if (!Auth::user()->hasPermission('view-student-promotions')) {
            abort(403, 'Unauthorized action.');
        }

        $query = Student::with(['center', 'currentRegistration']);

        // Filter by student number
        if ($request->filled('student_number')) {
            $query->where('student_number', 'like', '%' . $request->student_number . '%');
        }

        // Filter by student name
        if ($request->filled('student_name')) {
            $query->where(function($q) use ($request) {
                $q->where('student_names', 'like', '%' . $request->student_name . '%')
                  ->orWhere('surname', 'like', '%' . $request->student_name . '%');
            });
        }

        // Filter by academic year
        if ($request->filled('academic_year')) {
            $query->whereHas('registration', function($q) use ($request) {
                $q->where('academic_year', $request->academic_year);
            });
        }

        // Filter by center
        if ($request->filled('center_id')) {
            $query->where('center_id', $request->center_id);
        }

        $students = $query->paginate(20);

        $academicYears = AcademicYear::orderBy('academic_year', 'desc')->get();
        $centers = Center::orderBy('center_name')->get();

        return view('promotions.search', compact('students', 'academicYears', 'centers'));
    }

    /**
     * Show student exam marks for promotion
     */
    public function showMarks($studentId)
    {
        if (!Auth::user()->hasPermission('promote-students')) {
            abort(403, 'Unauthorized action.');
        }

        $student = Student::with(['center', 'currentRegistration'])->findOrFail($studentId);
        
        // Get current academic year
        $currentYear = date('Y');
        $academicYear = AcademicYear::where('academic_year', $currentYear)->first();
        
        if (!$academicYear) {
            return redirect()->back()->with('error', 'No active academic year found.');
        }

        // Get student's registered modules for current year
        $registeredModules = ModuleRegistration::where('student_id', $studentId)
            ->where('academic_year', $currentYear)
            ->with('module')
            ->get();

        // Get exam marks for registered modules
        $examMarksRaw = ExamMark::where('student_id', $studentId)
            ->where('academic_year_id', $academicYear->id)
            ->with(['module', 'examType', 'examPaper'])
            ->get();

        // Process exam marks - calculate weighted averages where possible
        $examMarks = [];
        
        // For each registered module, process marks by exam type
        foreach ($registeredModules as $registration) {
            $moduleId = $registration->module_id;
            $moduleMarksRaw = $examMarksRaw->where('module_id', $moduleId);
            
            if ($moduleMarksRaw->isNotEmpty()) {
                // Group by exam type
                $examTypeGroups = $moduleMarksRaw->groupBy('exam_type_id');
                $processedMarks = collect();
                
                foreach ($examTypeGroups as $examTypeId => $typeMarks) {
                    // Check if exam paper weights are defined for this module/exam type
                    $paperWeights = \App\ExamPaperWeight::where('module_id', $moduleId)
                        ->where('academic_year_id', $academicYear->id)
                        ->where('examination_id', $examTypeId)
                        ->get()
                        ->keyBy('paper_code');
                    
                    if ($paperWeights->isNotEmpty()) {
                        // Calculate weighted average
                        $totalWeightedMarks = 0;
                        $totalWeight = 0;
                        $hasAllPapers = true;
                        
                        foreach ($paperWeights as $weight) {
                            $paperMark = $typeMarks->where('exam_paper.paper_code', $weight->paper_code)->first();
                            if ($paperMark && $paperMark->total_marks > 0) {
                                $paperPercentage = ($paperMark->marks_obtained / $paperMark->total_marks) * 100;
                                $weightedContribution = ($paperPercentage * $weight->weight / 100);
                                $totalWeightedMarks += $weightedContribution;
                                $totalWeight += $weight->weight;
                            } else {
                                $hasAllPapers = false;
                                break;
                            }
                        }
                        
                        if ($hasAllPapers && $totalWeight == 100) {
                            // Create single weighted summary mark for this exam type
                            $summaryMark = new \stdClass();
                            $summaryMark->module = $registration->module;
                            $summaryMark->examType = $typeMarks->first()->examType;
                            $summaryMark->marks_obtained = round($totalWeightedMarks, 2);
                            $summaryMark->total_marks = 100;
                            $summaryMark->percentage = round($totalWeightedMarks, 2);
                            $summaryMark->is_weighted = true;
                            
                            $processedMarks->push($summaryMark);
                        } else {
                            // Fallback to individual marks if weights don't add up to 100 or missing papers
                            foreach ($typeMarks as $mark) {
                                $processedMarks->push($mark);
                            }
                        }
                    } else {
                        // No weights defined - show individual marks
                        foreach ($typeMarks as $mark) {
                            $processedMarks->push($mark);
                        }
                    }
                }
                
                $examMarks[$moduleId] = $processedMarks;
            }
        }

        // Check if all registered subjects have exam marks
        $missingMarks = [];
        foreach ($registeredModules as $registration) {
            if (!isset($examMarks[$registration->module_id]) || $examMarks[$registration->module_id]->isEmpty()) {
                $missingMarks[] = $registration->module->subject_name ?? 'Unknown Subject';
            }
        }

        $promotionalStatuses = PromotionalStatus::where('active', true)->get();

        // Get existing promotion for this year
        $existingPromotion = StudentPromotion::where('student_id', $studentId)
            ->where('academic_year_id', $academicYear->id)
            ->with('promotionalStatus')
            ->first();

        return view('promotions.marks', compact(
            'student', 
            'registeredModules', 
            'examMarks', 
            'missingMarks', 
            'promotionalStatuses',
            'academicYear',
            'existingPromotion'
        ));
    }

    /**
     * Promote a student
     */
    public function promote(Request $request, $studentId)
    {
        if (!Auth::user()->hasPermission('promote-students')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'promotional_status_id' => 'required|exists:promotional_statuses,id',
            'year_level' => 'required|string|max:10',
            'remarks' => 'nullable|string|max:1000'
        ]);

        $student = Student::findOrFail($studentId);
        $currentYear = date('Y');
        $academicYear = AcademicYear::where('academic_year', $currentYear)->first();

        if (!$academicYear) {
            return redirect()->back()->with('error', 'No active academic year found.');
        }

        // Check if all registered subjects have exam marks
        $registeredModules = ModuleRegistration::where('student_id', $studentId)
            ->where('academic_year', $currentYear)
            ->get();

        $examMarks = ExamMark::where('student_id', $studentId)
            ->where('academic_year_id', $academicYear->id)
            ->get()
            ->groupBy('module_id');

        $missingMarks = [];
        foreach ($registeredModules as $registration) {
            if (!isset($examMarks[$registration->module_id]) || $examMarks[$registration->module_id]->isEmpty()) {
                $missingMarks[] = $registration->module_id;
            }
        }

        if (!empty($missingMarks)) {
            return redirect()->back()->with('error', 'Cannot promote student. Exam marks are missing for some registered subjects.');
        }

        // Check if promotion already exists for this year
        $existingPromotion = StudentPromotion::where('student_id', $studentId)
            ->where('academic_year_id', $academicYear->id)
            ->first();

        if ($existingPromotion) {
            // Update existing promotion
            $existingPromotion->update([
                'promotional_status_id' => $request->promotional_status_id,
                'year_level' => $request->year_level,
                'remarks' => $request->remarks,
                'promoted_by' => Auth::id(),
                'promoted_at' => Carbon::now()
            ]);

            return redirect()->back()->with('success', 'Student promotion updated successfully.');
        } else {
            // Create new promotion
            StudentPromotion::create([
                'student_id' => $studentId,
                'academic_year_id' => $academicYear->id,
                'promotional_status_id' => $request->promotional_status_id,
                'year_level' => $request->year_level,
                'remarks' => $request->remarks,
                'promoted_by' => Auth::id(),
                'promoted_at' => Carbon::now()
            ]);

            return redirect()->back()->with('success', 'Student promoted successfully.');
        }
    }

    /**
     * View promotion history
     */
    public function history($studentId)
    {
        if (!Auth::user()->hasPermission('view-promotion-history')) {
            abort(403, 'Unauthorized action.');
        }

        $student = Student::with('center')->findOrFail($studentId);
        
        $promotions = StudentPromotion::where('student_promotions.student_id', $studentId)
            ->with(['academicYear', 'promotionalStatus', 'promotedBy'])
            ->orderBy('student_promotions.promoted_at', 'desc')
            ->get();

        return view('promotions.history', compact('student', 'promotions'));
    }
}
