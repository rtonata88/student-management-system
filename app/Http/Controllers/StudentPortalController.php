<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Student;
use App\OnlineApplication;
use App\ApplicationDocument;
use App\Subject;
use App\SubjectAllocation;
use App\ModuleRegistration;
use App\Payment;
use App\ExaminationSchedule;
use App\ClassRoutine;
use App\ClassSchedule;
use App\StudentPromotion;
use App\MarksSuppression;
use App\AcademicYear;
use App\CompanySetup;
use Illuminate\Support\Facades\Auth;

class StudentPortalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Remove permission middleware since we're using user.type middleware in routes
    }

    /**
     * Student Portal Dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        $application = OnlineApplication::where('user_id', $user->id)->first();

        // Get student statistics
        $stats = [
            'total_subjects' => 0,
            'total_payments' => 0,
            'pending_applications' => 0,
            'exam_schedules' => 0
        ];

        if ($student) {
            $stats['total_subjects'] = ModuleRegistration::where('student_id', $student->id)->count();
            $stats['total_payments'] = Payment::where('student_id', $student->id)->sum('payment_amount');
            $stats['exam_schedules'] = ExaminationSchedule::whereHas('subjectAllocation', function($query) use ($student) {
                $query->whereHas('moduleRegistrations', function($q) use ($student) {
                    $q->where('student_id', $student->id);
                });
            })->count();
        }

        if ($application) {
            $stats['pending_applications'] = $application->status === 'pending' ? 1 : 0;
        }

        return view('student-portal.dashboard', compact('student', 'application', 'stats'));
    }

    /**
     * Student Portal Index (alias for dashboard)
     */
    public function index()
    {
        return $this->dashboard();
    }

    /**
     * Profile Section
     */
    public function profile()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        return view('student-portal.profile', compact('student'));
    }

    /**
     * Academic Records
     */
    public function academicRecords()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        $records = collect(); // Placeholder - implement based on your assessment system
        
        return view('student-portal.academic-records', compact('student', 'records'));
    }

    /**
     * Assignments
     */
    public function assignments()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        $assignments = collect(); // Placeholder - implement based on your assignment system
        
        return view('student-portal.assignments', compact('student', 'assignments'));
    }

    /**
     * Grades
     */
    public function grades()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        $grades = collect(); // Placeholder - implement based on your grading system
        
        return view('student-portal.grades', compact('student', 'grades'));
    }

    public function myInfo()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)
            ->with(['center', 'currentRegistration', 'registration'])
            ->first();
        
        return view('student-portal.my-info', compact('student'));
    }

    public function myDocuments()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        $documents = collect();
        if ($student) {
            $documents = DB::table('student_documents')
                ->where('student_id', $student->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('student-portal.my-documents', compact('documents', 'student'));
    }

    public function myApplications()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        $applications = collect();
        if ($student) {
            // First, get online applications (for students who have applied but not yet registered)
            $onlineApplications = OnlineApplication::where('user_id', $user->id)->get();
            
            foreach ($onlineApplications as $onlineApp) {
                $applicationData = (object) [
                    'id' => $onlineApp->id,
                    'application_number' => $onlineApp->application_number,
                    'status' => $onlineApp->status, // Use actual status from online application
                    'created_at' => $onlineApp->created_at,
                    'updated_at' => $onlineApp->updated_at,
                    'academic_year' => $onlineApp->academic_year,
                    'student' => $student,
                    'subjects' => $onlineApp->subjects ?? collect()
                ];
                $applications->push($applicationData);
            }
            
            // Then, get registrations (for students who have been admitted and registered)
            $registrations = $student->registration->sortByDesc('academic_year');
            
            foreach ($registrations as $registration) {
                // Get subjects for this specific registration year
                $subjects = $student->registered_modules()
                    ->with('module')
                    ->get()
                    ->map(function($moduleReg) {
                        return $moduleReg->module;
                    })
                    ->filter();

                // Create application object from registration
                $applicationData = (object) [
                    'id' => $registration->id,
                    'application_number' => 'REG' . $registration->academic_year . str_pad($student->id, 4, '0', STR_PAD_LEFT),
                    'status' => 'registered',
                    'created_at' => $registration->created_at,
                    'updated_at' => $registration->updated_at,
                    'academic_year' => $registration->academic_year,
                    'student' => $student,
                    'subjects' => $subjects
                ];
                $applications->push($applicationData);
            }
        }
        
        return view('student-portal.my-applications', compact('applications', 'student'));
    }

    /**
     * Academics Section
     */
    public function academics()
    {
        return view('student-portal.academics.index');
    }

    public function caMarks()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        if (!$student) {
            return view('student-portal.academics.ca-marks', ['caMarks' => collect(), 'suppressed' => false]);
        }

        // Check if CA marks are suppressed
        $currentAcademicYear = AcademicYear::where('status', 1)->first();
        $suppressed = false;
        
        if ($currentAcademicYear && $student->intake && $student->campus && $student->study_mode) {
            $suppressed = MarksSuppression::isMarksSuppressed(
                $currentAcademicYear->id,
                $student->intake,
                $student->campus,
                'CA',
                $student->study_mode
            );
        }
        
        // Get student's registered modules with CA marks
        $caMarks = collect();
        
        if (!$suppressed && $currentAcademicYear) {
            // Get modules the student is registered for
            $registeredModules = ModuleRegistration::where('student_id', $student->id)
                ->where('academic_year', $currentAcademicYear->academic_year)
                ->with(['module'])
                ->get();

            foreach ($registeredModules as $registration) {
                // Skip if module relationship is missing
                if (!$registration->module) {
                    continue;
                }
                
                $module = $registration->module;
                
                // Get assessment weights for this module
                $assessmentWeights = \App\AssessmentWeight::where('module_id', $module->id)
                    ->where('academic_year_id', $currentAcademicYear->id)
                    ->with('assessmentType')
                    ->orderBy('assessment_type_id')
                    ->get();

                // Show module even if no assessment weights are defined
                if ($assessmentWeights->isEmpty()) {
                    // Module with no assessment structure defined
                    $caMarks->push([
                        'module' => $module,
                        'assessment_weights' => collect(),
                        'assessment_data' => [],
                        'ca_total' => 0,
                        'no_assessment_structure' => true
                    ]);
                } else {
                    // Get student's test marks for this module
                    $testMarks = \App\TestMark::where('student_id', $student->id)
                        ->where('module_id', $module->id)
                        ->where('academic_year_id', $currentAcademicYear->id)
                        ->with('assessmentType')
                        ->get()
                        ->keyBy('assessment_type_id');

                    // Calculate CA marks
                    $caTotal = 0;
                    $assessmentData = [];
                    $hasAnyMarks = false;

                    foreach ($assessmentWeights as $weight) {
                        $mark = $testMarks->get($weight->assessment_type_id);
                        $percentage = 0;
                        $weightedMark = 0;

                        if ($mark && $mark->marks_obtained !== null && $mark->total_marks > 0) {
                            $percentage = ($mark->marks_obtained / $mark->total_marks) * 100;
                            $weightedMark = ($percentage * $weight->weight) / 100;
                            $caTotal += $weightedMark;
                            $hasAnyMarks = true;
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

                    $caMarks->push([
                        'module' => $module,
                        'assessment_weights' => $assessmentWeights,
                        'assessment_data' => $assessmentData,
                        'ca_total' => round($caTotal, 2),
                        'has_marks' => $hasAnyMarks
                    ]);
                }
            }
            
            // Sort CA marks alphabetically by subject name
            $caMarks = $caMarks->sortBy(function($moduleData) {
                return $moduleData['module']->subject_name;
            })->values();
        }
        
        return view('student-portal.academics.ca-marks', compact('caMarks', 'suppressed'));
    }

    public function examMarks()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        if (!$student) {
            return view('student-portal.academics.exam-marks', ['examMarks' => collect(), 'suppressed' => false]);
        }

        // Check if Exam marks are suppressed
        $currentAcademicYear = AcademicYear::where('status', 1)->first();
        $suppressed = false;
        
        if ($currentAcademicYear && $student->intake && $student->campus && $student->study_mode) {
            $suppressed = MarksSuppression::isMarksSuppressed(
                $currentAcademicYear->id,
                $student->intake,
                $student->campus,
                'Exam Marks',
                $student->study_mode
            );
        }
        
        // Get student's registered modules with exam marks
        $examMarks = collect();
        
        if (!$suppressed && $currentAcademicYear) {
            // Get modules the student is registered for
            $registeredModules = ModuleRegistration::where('student_id', $student->id)
                ->where('academic_year', $currentAcademicYear->academic_year)
                ->with(['module'])
                ->get();

            foreach ($registeredModules as $registration) {
                // Skip if module relationship is missing
                if (!$registration->module) {
                    continue;
                }
                
                $module = $registration->module;
                
                // Get exam paper weights for this module
                $examPaperWeights = \App\ExamPaperWeight::where('module_id', $module->id)
                    ->where('academic_year_id', $currentAcademicYear->id)
                    ->with(['examination', 'examPaper'])
                    ->orderBy('examination_id')
                    ->orderBy('paper_code')
                    ->get();

                // Show module even if no exam paper weights are defined
                if ($examPaperWeights->isEmpty()) {
                    // Module with no exam structure defined
                    $examMarks->push([
                        'module' => $module,
                        'exam_types' => collect(),
                        'exam_data' => [],
                        'exam_total' => 0,
                        'no_exam_structure' => true
                    ]);
                } else {
                    // Group exam papers by exam type
                    $examTypeGroups = $examPaperWeights->groupBy('examination_id');
                    $examTypesData = [];
                    $overallExamTotal = 0;
                    $hasAnyMarks = false;

                    foreach ($examTypeGroups as $examTypeId => $papers) {
                        $examType = $papers->first()->examination;
                        
                        // Get student's exam marks for this module and exam type
                        $examMarks_raw = \App\ExamMark::where('student_id', $student->id)
                            ->where('module_id', $module->id)
                            ->where('academic_year_id', $currentAcademicYear->id)
                            ->where('exam_type_id', $examTypeId)
                            ->with(['examPaper'])
                            ->get()
                            ->keyBy('exam_paper_id');

                        // Calculate exam marks for this exam type
                        $examTypeTotal = 0;
                        $examPaperData = [];

                        // Get all available exam marks for this exam type (not keyed by paper_id)
                        $availableMarks = $examMarks_raw->values();
                        $usedMarks = [];
                        
                        foreach ($papers as $paperIndex => $paperWeight) {
                            // Find exam mark by matching through multiple strategies
                            $mark = null;
                            
                            foreach ($availableMarks as $markIndex => $examMark) {
                                // Skip if this mark is already used
                                if (in_array($markIndex, $usedMarks)) {
                                    continue;
                                }
                                
                                if ($examMark->examPaper) {
                                    // Strategy 1: Exact paper code match
                                    if ($examMark->examPaper->paper_code === $paperWeight->paper_code) {
                                        $mark = $examMark;
                                        $usedMarks[] = $markIndex;
                                        break;
                                    }
                                    // Strategy 2: Exact paper name match
                                    if ($examMark->examPaper->paper_name === $paperWeight->paper_name) {
                                        $mark = $examMark;
                                        $usedMarks[] = $markIndex;
                                        break;
                                    }
                                    // Strategy 3: Partial paper name match (case insensitive)
                                    if (stripos($examMark->examPaper->paper_name, $paperWeight->paper_name) !== false ||
                                        stripos($paperWeight->paper_name, $examMark->examPaper->paper_name) !== false) {
                                        $mark = $examMark;
                                        $usedMarks[] = $markIndex;
                                        break;
                                    }
                                    // Strategy 4: Match by paper number (P1, P01, Paper 1, etc.)
                                    $examPaperNum = preg_replace('/[^0-9]/', '', $examMark->examPaper->paper_code);
                                    $weightPaperNum = preg_replace('/[^0-9]/', '', $paperWeight->paper_code);
                                    if (!empty($examPaperNum) && !empty($weightPaperNum) && $examPaperNum === $weightPaperNum) {
                                        $mark = $examMark;
                                        $usedMarks[] = $markIndex;
                                        break;
                                    }
                                }
                            }
                            
                            // Strategy 5: If no match found, assign marks sequentially to available papers
                            if (!$mark && !empty($availableMarks)) {
                                foreach ($availableMarks as $markIndex => $examMark) {
                                    if (!in_array($markIndex, $usedMarks)) {
                                        $mark = $examMark;
                                        $usedMarks[] = $markIndex;
                                        break;
                                    }
                                }
                            }
                            
                            $percentage = 0;
                            $weightedMark = 0;

                            if ($mark && $mark->marks_obtained !== null && $mark->total_marks > 0) {
                                $percentage = ($mark->marks_obtained / $mark->total_marks) * 100;
                                $weightedMark = ($percentage * $paperWeight->weight) / 100;
                                $examTypeTotal += $weightedMark;
                                $hasAnyMarks = true;
                            }

                            $examPaperData[] = [
                                'exam_paper' => (object)['paper_name' => $paperWeight->paper_name, 'paper_code' => $paperWeight->paper_code],
                                'weight' => $paperWeight->weight,
                                'marks_obtained' => $mark ? $mark->marks_obtained : null,
                                'total_marks' => $mark ? $mark->total_marks : null,
                                'percentage' => round($percentage, 2),
                                'weighted_mark' => round($weightedMark, 2)
                            ];
                        }

                        $examTypesData[] = [
                            'exam_type' => $examType,
                            'exam_papers' => $examPaperData,
                            'exam_type_total' => round($examTypeTotal, 2)
                        ];

                        $overallExamTotal += $examTypeTotal;
                    }

                    $examMarks->push([
                        'module' => $module,
                        'exam_types' => $examTypesData,
                        'exam_total' => round($overallExamTotal, 2),
                        'has_marks' => $hasAnyMarks
                    ]);
                }
            }
            
            // Sort exam marks alphabetically by subject name
            $examMarks = $examMarks->sortBy(function($moduleData) {
                return $moduleData['module']->subject_name;
            })->values();
        }
        
        return view('student-portal.academics.exam-marks', compact('examMarks', 'suppressed'));
    }

    public function classRoutine()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        $routines = collect();
        
        if ($student) {
            // Get current academic year
            $currentAcademicYear = AcademicYear::where('academic_year', date('Y'))->first();
            
            if ($currentAcademicYear) {
                // Get student's registered modules for current academic year
                $registeredModules = ModuleRegistration::where('student_id', $student->id)
                    ->where('academic_year', $currentAcademicYear->academic_year)
                    ->pluck('module_id');
                
                if ($registeredModules->isNotEmpty()) {
                    // Get subject allocation IDs for the registered modules
                    $subjectAllocationIds = SubjectAllocation::whereIn('subject_id', $registeredModules)
                        ->where('academic_year_id', $currentAcademicYear->id)
                        ->where('center_id', $student->center_id)
                        ->pluck('id');
                    
                    if ($subjectAllocationIds->isNotEmpty()) {
                        // Get class schedules for student's subject allocations
                        $routines = ClassSchedule::with([
                            'academicYear', 'center', 'subjectAllocation.module', 
                            'subjectAllocation.user', 'venue', 'classDuration'
                        ])
                        ->active()
                        ->current()
                        ->where('academic_year_id', $currentAcademicYear->id)
                        ->where('center_id', $student->center_id)
                        ->whereIn('subject_allocation_id', $subjectAllocationIds)
                        ->orderBy('day_of_week')
                        ->orderBy('start_time')
                        ->get();
                    }
                }
            }
        }
        
        return view('student-portal.academics.class-routine', compact('routines'));
    }

    public function downloadClassRoutine()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        $routines = collect();
        
        if ($student) {
            // Get current academic year
            $currentAcademicYear = AcademicYear::where('academic_year', date('Y'))->first();
            
            if ($currentAcademicYear) {
                // Get student's registered modules for current academic year
                $registeredModules = ModuleRegistration::where('student_id', $student->id)
                    ->where('academic_year', $currentAcademicYear->academic_year)
                    ->pluck('module_id');
                
                if ($registeredModules->isNotEmpty()) {
                    // Get subject allocation IDs for the registered modules
                    $subjectAllocationIds = SubjectAllocation::whereIn('subject_id', $registeredModules)
                        ->where('academic_year_id', $currentAcademicYear->id)
                        ->where('center_id', $student->center_id)
                        ->pluck('id');
                    
                    if ($subjectAllocationIds->isNotEmpty()) {
                        // Get class schedules for student's subject allocations
                        $routines = ClassSchedule::with([
                            'academicYear', 'center', 'subjectAllocation.module', 
                            'subjectAllocation.user', 'venue', 'classDuration'
                        ])
                        ->active()
                        ->current()
                        ->where('academic_year_id', $currentAcademicYear->id)
                        ->where('center_id', $student->center_id)
                        ->whereIn('subject_allocation_id', $subjectAllocationIds)
                        ->orderBy('day_of_week')
                        ->orderBy('start_time')
                        ->get();
                    }
                }
            }
        }

        // Get company information for the PDF header
        $company = \App\CompanySetup::first();
        
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('student-portal.academics.class-routine-pdf', compact('student', 'routines', 'company', 'currentAcademicYear'));
        
        return $pdf->download('class-routine-' . ($student ? $student->student_number : 'student') . '.pdf');
    }

    public function examTimetable()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        $examSchedules = collect();
        if ($student) {
            // Get current academic year
            $currentAcademicYear = AcademicYear::where('status', 1)->first();
            
            // Get student's registered modules for their academic year and center
            $registeredModules = ModuleRegistration::where('student_id', $student->id)
                ->whereHas('registration', function($query) use ($student, $currentAcademicYear) {
                    $query->where('center_id', $student->center_id);
                    if ($currentAcademicYear) {
                        $query->where('academic_year', $currentAcademicYear->academic_year);
                    }
                })
                ->pluck('module_id');

            if ($registeredModules->isNotEmpty()) {
                // Get subject allocation IDs for the registered modules
                $subjectAllocationIds = SubjectAllocation::whereIn('subject_id', $registeredModules)
                    ->where('academic_year_id', $currentAcademicYear ? $currentAcademicYear->id : null)
                    ->where('center_id', $student->center_id)
                    ->pluck('id');
                
                // Get examination schedules for these subject allocations
                $examSchedules = ExaminationSchedule::whereIn('subject_allocation_id', $subjectAllocationIds)
                    ->orWhereIn('subject_id', $registeredModules)
                    ->where('center_id', $student->center_id)
                    ->where('academic_year_id', $currentAcademicYear ? $currentAcademicYear->id : null)
                    ->where('is_active', true)
                    ->with([
                        'subject', 
                        'subjectAllocation.subject', 
                        'venue', 
                        'classDuration', 
                        'headInvigilator',
                        'examination',
                        'academicYear',
                        'center'
                    ])
                    ->orderBy('exam_date')
                    ->orderBy('class_duration_id')
                    ->get();
            }
        }
        
        return view('student-portal.academics.exam-timetable', compact('examSchedules'));
    }

    public function examTimetablePdf()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        $examSchedules = collect();
        if ($student) {
            // Get current academic year
            $currentAcademicYear = AcademicYear::where('status', 1)->first();
            
            // Get student's registered modules for their academic year and center
            $registeredModules = ModuleRegistration::where('student_id', $student->id)
                ->whereHas('registration', function($query) use ($student, $currentAcademicYear) {
                    $query->where('center_id', $student->center_id);
                    if ($currentAcademicYear) {
                        $query->where('academic_year', $currentAcademicYear->academic_year);
                    }
                })
                ->pluck('module_id');

            if ($registeredModules->isNotEmpty()) {
                // Get subject allocation IDs for the registered modules
                $subjectAllocationIds = SubjectAllocation::whereIn('subject_id', $registeredModules)
                    ->where('academic_year_id', $currentAcademicYear ? $currentAcademicYear->id : null)
                    ->where('center_id', $student->center_id)
                    ->pluck('id');
                
                // Get examination schedules for these subject allocations
                $examSchedules = ExaminationSchedule::whereIn('subject_allocation_id', $subjectAllocationIds)
                    ->orWhereIn('subject_id', $registeredModules)
                    ->where('center_id', $student->center_id)
                    ->where('academic_year_id', $currentAcademicYear ? $currentAcademicYear->id : null)
                    ->where('is_active', true)
                    ->with([
                        'subject', 
                        'subjectAllocation.subject', 
                        'venue', 
                        'classDuration', 
                        'headInvigilator',
                        'examination',
                        'academicYear',
                        'center'
                    ])
                    ->orderBy('exam_date')
                    ->orderBy('class_duration_id')
                    ->get();
            }
        }
        
        // Get company information for the PDF header
        $company = \App\CompanySetup::first();
        $currentAcademicYear = AcademicYear::where('status', 1)->first();
        
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('student-portal.academics.exam-timetable-pdf', compact('student', 'examSchedules', 'company', 'currentAcademicYear'));
        
        return $pdf->download('exam-timetable-' . ($student ? $student->student_number : 'student') . '.pdf');
    }

    public function academicScript()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        return view('student-portal.academics.academic-script', compact('student'));
    }

    public function proofOfRegistration()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        if (!$student) {
            return redirect()->back()->with('error', 'Student record not found.');
        }
        
        // Get company information
        $company = \App\CompanySetup::first();
        
        // Get all academic years where student has registrations
        $registrationsByYear = ModuleRegistration::where('student_id', $student->id)
            ->with(['module'])
            ->get()
            ->groupBy('academic_year')
            ->sortKeysDesc(); // Most recent year first
        
        // Get current academic year for default display
        $currentYear = AcademicYear::where('status', 1)->first();
        if (!$currentYear) {
            $currentYear = (object)['academic_year' => date('Y')];
        }
        
        // Prepare registration data for each academic year
        $registrationsData = [];
        foreach ($registrationsByYear as $academicYear => $modules) {
            // Get student registration for this year
            $registration = $student->registration->where('academic_year', $academicYear)->first();
            if (!$registration) {
                // Create a default registration object
                $registration = (object)[
                    'registration_date' => $student->created_at ?? now(),
                    'registration_status' => 'Active'
                ];
            }
            
            $registrationsData[] = [
                'academic_year' => $academicYear,
                'registration' => $registration,
                'modules' => $modules,
                'total_amount' => $modules->sum('amount'),
                'subject_count' => $modules->count()
            ];
        }
        
        return view('student-portal.academics.proof-of-registration', compact(
            'student', 'company', 'currentYear', 'registrationsData'
        ));
    }
    
    public function downloadProofOfRegistration()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        if (!$student) {
            return redirect()->back()->with('error', 'Student record not found.');
        }
        
        // Get company information
        $company = \App\CompanySetup::first();
        
        // Get current academic year
        $currentYear = AcademicYear::where('status', 1)->first();
        if (!$currentYear) {
            $currentYear = (object)['academic_year' => date('Y')];
        }
        
        // Get student registration
        $registration = $student->registration->where('academic_year', $currentYear->academic_year)->first();
        if (!$registration) {
            // Create a default registration object
            $registration = (object)[
                'registration_date' => $student->created_at ?? now(),
                'registration_status' => 'Active'
            ];
        }
        
        // Get registered modules
        $registered_modules = ModuleRegistration::where('student_id', $student->id)
            ->where('academic_year', $currentYear->academic_year)
            ->with(['module'])
            ->get();
        
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('student-portal.academics.proof-of-registration-pdf', compact(
            'student', 'company', 'currentYear', 'registration', 'registered_modules'
        ));
        
        return $pdf->download('proof-of-registration-' . $student->student_number . '.pdf');
    }

    /**
     * Finance Section
     */
    public function finance()
    {
        return view('student-portal.finance.index');
    }

    public function myPayments()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        $paymentsByYear = [];
        if ($student) {
            // Get cashier payments
            $cashierPayments = DB::table('cashier_payments')
                ->select([
                    'id',
                    'student_id',
                    'receipt_number',
                    'amount as payment_amount',
                    'payment_method',
                    'reference_number',
                    'notes',
                    'cashier_id as user_id',
                    'payment_date',
                    'created_at',
                    'updated_at',
                    DB::raw("'Cashier' as payment_source")
                ])
                ->where('student_id', $student->id);

            // Get manual payments
            $manualPayments = DB::table('payments')
                ->select([
                    'id',
                    'student_id',
                    'receipt_number',
                    'payment_amount',
                    'payment_method',
                    DB::raw("NULL as reference_number"),
                    DB::raw("NULL as notes"),
                    'received_by as user_id',
                    'payment_date',
                    'created_at',
                    'updated_at',
                    DB::raw("'Manual' as payment_source")
                ])
                ->where('student_id', $student->id);

            // Union the queries and get results
            $allPayments = $cashierPayments->union($manualPayments)
                ->orderBy('payment_date', 'desc')
                ->get();

            // Add relationships manually and group by year
            foreach ($allPayments as $payment) {
                // Add student relationship
                $payment->student = $student;
                
                // Add user/cashier relationship
                if ($payment->payment_source === 'Cashier') {
                    $payment->cashier = DB::table('users')->where('id', $payment->user_id)->first();
                    $payment->user = null;
                } else {
                    $payment->user = DB::table('users')->where('id', $payment->user_id)->first();
                    $payment->cashier = null;
                }
                
                // Convert payment_date to Carbon instance if it's a string
                if ($payment->payment_date && is_string($payment->payment_date)) {
                    $payment->payment_date = \Carbon\Carbon::parse($payment->payment_date);
                }
                
                // Group by year
                $year = $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->year : date('Y');
                if (!isset($paymentsByYear[$year])) {
                    $paymentsByYear[$year] = [
                        'year' => $year,
                        'payments' => collect(),
                        'total_amount' => 0,
                        'payment_count' => 0
                    ];
                }
                
                $paymentsByYear[$year]['payments']->push($payment);
                $paymentsByYear[$year]['total_amount'] += $payment->payment_amount;
                $paymentsByYear[$year]['payment_count']++;
            }
            
            // Sort by year descending (latest year first)
            krsort($paymentsByYear);
        }
        
        return view('student-portal.finance.my-payments', compact('paymentsByYear', 'student'));
    }

    public function printPaymentReceipt($paymentId, $paymentSource)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        if (!$student) {
            return redirect()->back()->with('error', 'Student record not found.');
        }

        // Get the specific payment based on source
        $payment = null;
        if ($paymentSource === 'Cashier') {
            $payment = DB::table('cashier_payments')
                ->where('id', $paymentId)
                ->where('student_id', $student->id)
                ->first();
            
            if ($payment) {
                // Add relationships manually
                $payment->student = $student;
                $payment->cashier = DB::table('users')->where('id', $payment->cashier_id)->first();
                $payment->user = null;
                $payment->payment_source = 'Cashier';
                // Map amount to payment_amount for consistency
                $payment->payment_amount = $payment->amount;
            }
        } else {
            $payment = DB::table('payments')
                ->where('id', $paymentId)
                ->where('student_id', $student->id)
                ->first();
            
            if ($payment) {
                // Add relationships manually
                $payment->student = $student;
                $payment->user = DB::table('users')->where('id', $payment->received_by)->first();
                $payment->cashier = null;
                $payment->payment_source = 'Manual';
                $payment->reference_number = null;
                $payment->notes = null;
            }
        }

        if (!$payment) {
            return redirect()->back()->with('error', 'Payment record not found.');
        }

        // Get company information - handle if companies table doesn't exist
        $company = null;
        try {
            $company = DB::table('companies')->first();
        } catch (\Exception $e) {
            // Companies table doesn't exist, use default values
            $company = (object) [
                'company_name' => config('app.name', 'EDUCIMS TUTORIALS SYSTEM'),
                'address1' => 'Educational Institution',
                'address2' => 'P.O. Box 12345, City',
                'address3' => '',
                'address4' => '',
                'contact_number' => '+123 456 7890',
                'fax' => 'N/A',
                'email' => 'info@educims.com'
            ];
        }

        return view('student-portal.finance.payment-receipt', compact('payment', 'company'));
    }

    public function financialStatement()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        $financialData = collect();
        
        if ($student) {
            // Get all academic years for this student
            $academicYears = ModuleRegistration::where('student_id', $student->id)
                ->select('academic_year')
                ->distinct()
                ->orderBy('academic_year', 'asc') // Changed to ascending to process chronologically
                ->pluck('academic_year');

            $previousYearBalance = 0; // Track balance from previous years
            $lastProcessedYear = null; // Track the actual last year processed

            foreach ($academicYears as $academicYear) {
                // Get registrations for this academic year
                $registrations = ModuleRegistration::where('student_id', $student->id)
                    ->where('academic_year', $academicYear)
                    ->with('subjectAllocation.module')
                    ->get();

                // Calculate tuition fees for this year
                $tuitionFees = $registrations->sum(function($reg) {
                    return $reg->subjectAllocation->module->subject_fees ?? 0;
                });

                // Get all payments for this academic year (both cashier and manual)
                $cashierPayments = DB::table('cashier_payments')
                    ->select([
                        'id',
                        'receipt_number',
                        'amount as payment_amount',
                        'payment_method',
                        'reference_number',
                        'notes',
                        'payment_date as transaction_date',
                        DB::raw("'Payment Received - Cashier' as line_description"),
                        DB::raw("0 as debit_amount"),
                        'amount as credit_amount',
                        DB::raw("'Cashier' as payment_source")
                    ])
                    ->where('student_id', $student->id)
                    ->whereYear('payment_date', $academicYear);

                $manualPayments = DB::table('payments')
                    ->select([
                        'id',
                        'receipt_number',
                        'payment_amount',
                        'payment_method',
                        DB::raw("NULL as reference_number"),
                        DB::raw("NULL as notes"),
                        'payment_date as transaction_date',
                        DB::raw("'Payment Received - Manual' as line_description"),
                        DB::raw("0 as debit_amount"),
                        'payment_amount as credit_amount',
                        DB::raw("'Manual' as payment_source")
                    ])
                    ->where('student_id', $student->id)
                    ->whereYear('payment_date', $academicYear);

                // Combine payments
                $allPayments = $cashierPayments->union($manualPayments)
                    ->orderBy('transaction_date', 'asc')
                    ->get();

                // Create transactions collection
                $transactions = collect();
                
                // Add Balance B/F as first entry if there's a previous year balance
                if ($previousYearBalance != 0 && $lastProcessedYear !== null) {
                    $transactions->push((object) [
                        'transaction_date' => $academicYear . '-01-01', // Start of academic year
                        'line_description' => 'Balance B/F from ' . $lastProcessedYear,
                        'reference_number' => 'BAL-BF-' . $lastProcessedYear,
                        'debit_amount' => $previousYearBalance > 0 ? $previousYearBalance : 0,
                        'credit_amount' => $previousYearBalance < 0 ? abs($previousYearBalance) : 0,
                        'payment_source' => 'System'
                    ]);
                }
                
                // Add tuition fees as debit entries
                foreach ($registrations as $registration) {
                    if ($registration->subjectAllocation && $registration->subjectAllocation->module) {
                        $module = $registration->subjectAllocation->module;
                        $subjectFee = $module->subject_fees ?? 0;
                        
                        if ($subjectFee > 0) {
                            $transactions->push((object) [
                                'transaction_date' => $academicYear . '-01-01', // Start of academic year
                                'line_description' => 'Tuition Fee - ' . $module->subject_name,
                                'reference_number' => 'TF-' . $academicYear . '-' . $module->subject_code,
                                'debit_amount' => $subjectFee,
                                'credit_amount' => 0,
                                'payment_source' => 'System'
                            ]);
                        }
                    }
                }

                // Add payments as credit entries
                foreach ($allPayments as $payment) {
                    $transactions->push((object) [
                        'transaction_date' => $payment->transaction_date,
                        'line_description' => $payment->line_description,
                        'reference_number' => $payment->receipt_number,
                        'debit_amount' => $payment->debit_amount,
                        'credit_amount' => $payment->credit_amount,
                        'payment_source' => $payment->payment_source
                    ]);
                }

                // Sort transactions by date
                $transactions = $transactions->sortBy('transaction_date');

                // Calculate totals including Balance B/F
                $totalPayable = $tuitionFees + ($previousYearBalance > 0 ? $previousYearBalance : 0);
                $totalPaid = $allPayments->sum('credit_amount') + ($previousYearBalance < 0 ? abs($previousYearBalance) : 0);
                $courseBalance = $totalPayable - $totalPaid;

                // Store current year balance and year for next iteration
                $previousYearBalance = $courseBalance;
                $lastProcessedYear = $academicYear;

                $financialData->push([
                    'academic_year' => $academicYear,
                    'registrations' => $registrations,
                    'transactions' => $transactions,
                    'tuition_fees' => $tuitionFees,
                    'other_fees' => 0, // Can be extended later
                    'total_payable' => $totalPayable,
                    'total_paid' => $totalPaid,
                    'course_balance' => $courseBalance,
                    'balance_bf' => $lastProcessedYear !== null ? ($courseBalance - $tuitionFees + $allPayments->sum('credit_amount')) : 0
                ]);
            }

            // Reverse the collection to show most recent year first
            $financialData = $financialData->reverse()->values();
        }
        
        return view('student-portal.finance.financial-statement', compact('financialData', 'student'));
    }

    /**
     * My Subjects Section
     */
    public function mySubjects()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        $subjectsByYear = collect();
        if ($student) {
            // Get ALL module registrations with their modules
            $moduleRegistrations = ModuleRegistration::where('student_id', $student->id)
                ->with(['module'])
                ->get();
            
            // For each registration, try to find the corresponding subject allocation
            foreach ($moduleRegistrations as $registration) {
                if ($registration->module) {
                    // Find subject allocation for this module, academic year, and center
                    $academicYear = AcademicYear::where('academic_year', $registration->academic_year)->first();
                    
                    $subjectAllocation = SubjectAllocation::where('subject_id', $registration->module_id)
                        ->where('center_id', $student->center_id)
                        ->when($academicYear, function($query) use ($academicYear) {
                            return $query->where('academic_year_id', $academicYear->id);
                        })
                        ->with(['user', 'academicYear', 'center'])
                        ->first();
                    
                    // Add the subject allocation to the registration object (can be null)
                    $registration->subjectAllocation = $subjectAllocation;
                    
                    // Group by academic year
                    $year = $registration->academic_year;
                    if (!$subjectsByYear->has($year)) {
                        $subjectsByYear->put($year, collect());
                    }
                    $subjectsByYear->get($year)->push($registration);
                }
            }
        }
        
        // Sort years with 2025 (current year) first, then descending order
        $subjectsByYear = $subjectsByYear->sortKeysUsing(function ($a, $b) {
            if ($a == 2025) return -1;
            if ($b == 2025) return 1;
            return $b <=> $a; // Descending order for other years
        });
        
        return view('student-portal.my-subjects', compact('subjectsByYear'));
    }

    /**
     * Display attendance for a student in a specific subject
     */
    public function myAttendance($allocationId)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        if (!$student) {
            return redirect()->back()->with('error', 'Student record not found.');
        }

        // Get the subject allocation first
        $allocation = SubjectAllocation::with(['module', 'academicYear', 'center', 'user'])
            ->where('id', $allocationId)
            ->firstOrFail();

        // Verify student is enrolled in this subject
        $enrollment = ModuleRegistration::where('student_id', $student->id)
            ->where('module_id', $allocation->subject_id)
            ->where('academic_year', $allocation->academicYear->academic_year ?? null)
            ->first();
            
        if (!$enrollment) {
            return redirect()->back()->with('error', 'You are not enrolled in this subject.');
        }

        // Get attendance records for this student in this subject
        $attendanceRecords = \App\Attendance::with(['student'])
            ->where('subject_allocation_id', $allocationId)
            ->where('student_id', $student->id)
            ->orderBy('attendance_date', 'desc')
            ->orderBy('class_time', 'desc')
            ->paginate(20);

        // Calculate attendance statistics
        $totalClasses = \App\Attendance::where('subject_allocation_id', $allocationId)
            ->where('student_id', $student->id)
            ->count();
            
        $attendedClasses = \App\Attendance::where('subject_allocation_id', $allocationId)
            ->where('student_id', $student->id)
            ->where('status', 'present')
            ->count();
            
        $attendancePercentage = $totalClasses > 0 ? round(($attendedClasses / $totalClasses) * 100, 2) : 0;

        return view('student-portal.my-attendance', compact(
            'allocation', 'attendanceRecords', 'student', 'totalClasses', 
            'attendedClasses', 'attendancePercentage'
        ));
    }

    /**
     * Display subject materials for a student in a specific subject
     */
    public function subjectMaterials($allocationId)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        if (!$student) {
            return redirect()->back()->with('error', 'Student record not found.');
        }

        // Get the subject allocation first
        $allocation = SubjectAllocation::with(['module', 'academicYear', 'center', 'user'])
            ->where('id', $allocationId)
            ->firstOrFail();

        // Verify student is enrolled in this subject
        $enrollment = ModuleRegistration::where('student_id', $student->id)
            ->where('module_id', $allocation->subject_id)
            ->where('academic_year', $allocation->academicYear->academic_year ?? null)
            ->first();
            
        if (!$enrollment) {
            return redirect()->back()->with('error', 'You are not enrolled in this subject.');
        }

        $query = \App\SubjectMaterial::with(['uploader'])
            ->where('module_allocation_id', $allocationId)
            ->where('published', true)
            ->where(function($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            });

        // Apply search filter if provided
        if (request()->filled('search')) {
            $search = request()->get('search');
            $query->where(function($q) use ($search) {
                $q->where('document_name', 'LIKE', "%{$search}%")
                  ->orWhere('document_description', 'LIKE', "%{$search}%")
                  ->orWhere('category', 'LIKE', "%{$search}%");
            });
        }

        // Apply category filter if provided
        if (request()->filled('category') && request()->get('category') !== 'all') {
            $query->where('category', request()->get('category'));
        }

        $materials = $query->orderBy('category')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends(request()->query());

        $categories = \App\SubjectMaterial::getCategories();

        return view('student-portal.subject-materials', compact('materials', 'allocation', 'categories', 'student'));
    }

    /**
     * Download subject material for student
     */
    public function downloadSubjectMaterial($materialId)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        if (!$student) {
            return redirect()->back()->with('error', 'Student record not found.');
        }

        $material = \App\SubjectMaterial::with(['moduleAllocation'])
            ->where('id', $materialId)
            ->where('published', true)
            ->where(function($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            })
            ->firstOrFail();

        // Get the subject allocation to verify enrollment
        $allocation = SubjectAllocation::with(['academicYear'])
            ->where('id', $material->module_allocation_id)
            ->first();

        // Verify student is enrolled in this subject
        $enrollment = ModuleRegistration::where('student_id', $student->id)
            ->where('module_id', $allocation->subject_id ?? null)
            ->where('academic_year', $allocation->academicYear->academic_year ?? null)
            ->first();
            
        if (!$enrollment) {
            return redirect()->back()->with('error', 'You are not enrolled in this subject.');
        }

        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($material->file_path)) {
            return back()->with('error', 'File not found.');
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->download($material->file_path, $material->file_name);
    }

    /**
     * Online Learning Section
     */
    public function onlineLearning()
    {
        return view('student-portal.online-learning.index');
    }

    /**
     * Library Management Section
     */
    public function library()
    {
        return view('student-portal.library.index');
    }

    public function libraryBooks()
    {
        // Placeholder - implement based on your library system
        $books = collect();
        return view('student-portal.library.library-books', compact('books'));
    }

    public function libraryFines()
    {
        // Placeholder - implement based on your library system
        $fines = collect();
        return view('student-portal.library.library-fines', compact('fines'));
    }

    public function borrowHistory()
    {
        // Placeholder - implement based on your library system
        $history = collect();
        return view('student-portal.library.borrow-history', compact('history'));
    }

    /**
     * Hostel Management Section
     */
    public function hostel()
    {
        return view('student-portal.hostel.index');
    }

    public function hostelApplications()
    {
        // Placeholder - implement based on your hostel system
        $applications = collect();
        return view('student-portal.hostel.hostel-applications', compact('applications'));
    }

    public function myHostelData()
    {
        // Placeholder - implement based on your hostel system
        $hostelData = null;
        return view('student-portal.hostel.my-hostel-data', compact('hostelData'));
    }

    /**
     * Market Place Section
     */
    public function marketplace()
    {
        return view('student-portal.marketplace.index');
    }

    /**
     * Support Centre Section
     */
    public function userManuals()
    {
        return view('student-portal.support.user-manuals');
    }

    public function videoTutorials()
    {
        return view('student-portal.support.video-tutorials');
    }

    public function faqHelp()
    {
        return view('student-portal.support.faq-help');
    }

    public function quickSupport()
    {
        $company = CompanySetup::first();
        return view('student-portal.support.quick-support', compact('company'));
    }

    public function getSupport()
    {
        return view('student-portal.support.get-support');
    }
}
