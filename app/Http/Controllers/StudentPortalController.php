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
use App\StudentPromotion;
use App\MarksSuppression;
use App\AcademicYear;
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
        $applications = OnlineApplication::where('user_id', $user->id)
            ->with(['subjects', 'student.center'])
            ->get();
        
        return view('student-portal.my-applications', compact('applications'));
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
        $currentAcademicYear = AcademicYear::where('active', 1)->first();
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
        
        // Get CA marks from module registrations or assessment system
        $caMarks = collect(); // Placeholder - implement based on your assessment system
        
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
        $currentAcademicYear = AcademicYear::where('active', 1)->first();
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
        
        // Get exam marks from assessment system
        $examMarks = collect(); // Placeholder - implement based on your assessment system
        
        return view('student-portal.academics.exam-marks', compact('examMarks', 'suppressed'));
    }

    public function classRoutine()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        $routines = collect(); // Placeholder - implement based on your class routine system
        
        return view('student-portal.academics.class-routine', compact('routines'));
    }

    public function examTimetable()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        $examSchedules = collect();
        if ($student) {
            $examSchedules = ExaminationSchedule::whereHas('subjectAllocation', function($query) use ($student) {
                $query->whereHas('moduleRegistrations', function($q) use ($student) {
                    $q->where('student_id', $student->id);
                });
            })->with(['subjectAllocation.subject', 'venue', 'timeSlot'])->get();
        }
        
        return view('student-portal.academics.exam-timetable', compact('examSchedules'));
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
        
        $subjects = ModuleRegistration::where('student_id', $student->id)
            ->with('subjectAllocation.subject')
            ->get();
        
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('student-portal.academics.proof-of-registration-pdf', compact('student', 'subjects'));
        
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
        
        $payments = collect();
        if ($student) {
            $payments = Payment::where('student_id', $student->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('student-portal.finance.my-payments', compact('payments'));
    }

    public function financialStatement()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        $payments = collect();
        $totalPaid = 0;
        $totalOwed = 0;
        
        if ($student) {
            $payments = Payment::where('student_id', $student->id)->get();
            $totalPaid = $payments->sum('payment_amount');
            // Calculate total owed based on subject fees
            $registrations = ModuleRegistration::where('student_id', $student->id)
                ->with('subjectAllocation.subject')
                ->get();
            $totalOwed = $registrations->sum(function($reg) {
                return $reg->subjectAllocation->subject->subject_fees ?? 0;
            });
        }
        
        return view('student-portal.finance.financial-statement', compact('payments', 'totalPaid', 'totalOwed'));
    }

    /**
     * My Subjects Section
     */
    public function mySubjects()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        $subjects = collect();
        if ($student) {
            $subjects = ModuleRegistration::where('student_id', $student->id)
                ->with(['subjectAllocation.module', 'subjectAllocation.user'])
                ->get();
        }
        
        return view('student-portal.my-subjects', compact('subjects'));
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
        return view('student-portal.library.books', compact('books'));
    }

    public function libraryFines()
    {
        // Placeholder - implement based on your library system
        $fines = collect();
        return view('student-portal.library.fines', compact('fines'));
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
        return view('student-portal.hostel.applications', compact('applications'));
    }

    public function myHostelData()
    {
        // Placeholder - implement based on your hostel system
        $hostelData = null;
        return view('student-portal.hostel.my-data', compact('hostelData'));
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
        return view('student-portal.support.quick-support');
    }

    public function getSupport()
    {
        return view('student-portal.support.get-support');
    }
}
