<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use Illuminate\Http\Request;

use App\ActivityTeamReport;
use App\ActivityReport;
use App\MediaCoverageReport;
use App\EventReport;
use App\Profile;
use App\ActivityType;
use App\Invoice;
use App\ModuleRegistration;
use App\Registration;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        //dd($user->hasPermissionTo('access-dashboard'));
        if (!$user->hasPermission('dashboard')) {
            return redirect('/start-page');
        }
        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $registered_students = Registration::where('academic_year', $academic_year)
                                ->where('registration_status', 'Registered')
                                ->pluck('student_id');

        $registered_learners = count($registered_students);
        $total_invoices = $this->totalInvoices($academic_year, $registered_students);
        $total_payments = $this->totalPayments($academic_year, $registered_students);
        $learners_per_subject = $this->learnersPerSubject($academic_year);

        $total_outstanding = 0;
        $total_credit_memos = 0;
        $total_debit_memos = 0;
        $net_outstanding = 0;
        $activity_team_reports = 0;
        $activity_reports = 0;
        $media_coverage_reports = 0;
        $event_reports = 0;
        $activity_types = 0;

        return view('home', compact('registered_learners', 'total_invoices', 'total_payments', 'total_outstanding', 'total_credit_memos', 'total_debit_memos', 'net_outstanding', 'academic_year', 'activity_team_reports', 'activity_reports', 'media_coverage_reports', 'event_reports', 'activity_types', 'learners_per_subject'));
    }

    /**
     * Show the start page with proper permission context.
     *
     * @return \Illuminate\Http\Response
     */
    public function startPage()
    {
        // Ensure user is authenticated and permissions are loaded
        $user = Auth::user();
        
        // Load user permissions and roles to ensure sidebar displays correctly
        $user->load('permissions', 'roles');
        
        return view('start-page');
    }

    /**
     * Show the welcome page for users when they login.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        $user = Auth::user();
        return view('welcome-user', compact('user'));
    }

    private function totalLearners($academic_year){
        return  Registration::where('academic_year', $academic_year)
                                ->where('registration_status', 'Registered')
                                ->count();
    }

    private function totalInvoices($academic_year, $registered_students)
    {
        $invoices = Invoice::select('debit_amount')->whereIn('student_id', $registered_students)      
                            ->where('financial_year', $academic_year) 
                            ->sum('debit_amount');
        
        return $invoices;
    }

    private function totalPayments($academic_year, $registered_students)
    {
        $payments = Invoice::select('credit_amount')->whereIn('student_id', $registered_students)
            ->where('financial_year', $academic_year)
            ->sum('credit_amount');

        return $payments;
    }

    private function learnersPerSubject($academic_year){
        return ModuleRegistration::selectRaw('count(module_registrations.module_id) as count, modules.subject_name')
            ->join('modules', 'modules.id', '=', 'module_registrations.module_id')
            ->where('academic_year', $academic_year)
            ->where('registration_status', 'Registered')
            ->groupBy('module_registrations.module_id')
            ->get();
    }

    public function fetchSubjects(){
        
        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $subjects = ModuleRegistration::selectRaw('count(module_registrations.module_id) as y, modules.subject_name as name')
                                    ->join('modules', 'modules.id', '=', 'module_registrations.module_id')
                                    ->where('academic_year', $academic_year)
                                    ->where('registration_status', 'Registered')
                                    ->groupBy('module_registrations.module_id')
                                    ->get();


        return response()->json(
            $subjects
        );
    }
}
