<?php

namespace App\Http\Controllers;

use App\Audit;
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

        return view('Reports.Audit.Index', compact('audit_models', 'audit_logs'));
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
