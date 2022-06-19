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
        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        $registered_students = Registration::where('academic_year', $academic_year)
                                ->where('registration_status', 'Registered')
                                ->pluck('student_id');

        $registered_learners = count($registered_students);
        $total_invoices = $this->totalInvoices($academic_year, $registered_students);
        $total_payments = $this->totalPayments($academic_year, $registered_students);
        $learners_per_subject = $this->learnersPerSubject($academic_year);

        return view('home', compact('registered_learners', 'total_invoices', 'total_payments', 'learners_per_subject'));
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
