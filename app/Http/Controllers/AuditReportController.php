<?php

namespace App\Http\Controllers;

use App\Audit;
use App\User;
use Illuminate\Http\Request;

class AuditReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $audit_models = $this->getModels();

        $audit_logs = Audit::with('user')->whereDate('created_at', date('Y-m-d'))->get();

        $users = User::pluck('name', 'id');

        return view('Reports.Audit.Index', compact('audit_models', 'audit_logs', 'users'));
    }

    public function search(Request $request){
        
        $audit_models = $this->getModels();
        
        $users = User::pluck('name', 'id');

        $date_from = $request->date_from;

        $date_to = $request->date_to;
        
        $audit_logs = Audit::with('user')->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') BETWEEN '$date_from' AND '$date_to' ");

        if(isset($request->event)){
            $audit_logs = $audit_logs->where('event', $request->event);
        }

        if(isset($request->model)){
            $audit_logs = $audit_logs->where('auditable_type', $request->model);
        }

        if (isset($request->user_id)) {
            $audit_logs = $audit_logs->where('user_id', $request->user_id);
        }

        $audit_logs = $audit_logs->get();

        return view('Reports.Audit.Index', compact('audit_models', 'audit_logs', 'users'));
    }

    public function show($id){
        $log = Audit::find($id);

        return view('Reports.Audit.Show', compact('log'));
    }

    private function getModels(){
        return $this->models();
    }

    private function models(){
        return [
            "App\AcademicYear"          => "Academic Years",
            "App\CompanySetup"          => "Company Setup",
            "App\CreditMemo"            => "Credit Memos",
            "App\DebitMemo"             => "Debit Memos",
            "App\Registration"          => "Enrolment",
            "App\Fees"                  => "Fees",
            "App\ModuleExtraFee"        => "Other Fees Setup",
            "App\Payment"               => "Payments",
            "App\Student"               => "Students",
            "App\Module"                => "Subjecs",
            "App\StudentExtraCharge"    => "Student Other Fees Charges",
            "App\StudentGuardian"       => "Student Guardian Information"
        ];
    }
}
