<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ActivityTeamReport;
use App\ActivityReport;
use App\MediaCoverageReport;
use App\EventReport;
use App\Profile;
use App\ActivityType;

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
        $sectors = ActivityTeamReport::sectorsDashboardAnalysis();
        $data = $this->sectorByTeamGraph();

        $profiles = Profile::count();

        $profiles_by_country = $this->getProfilesByCountry();
        $profiles_by_status = $this->getProfilesByStatus();
        $profiles_by_role = $this->getProfilesByRole();
        $profiles_by_stage = $this->getProfilesByStage();
        $email_activities = $this->getEmailActivitiesByTeam(date('Y-m-01'), date('Y-m-d'));
        $meeting_activities = $this->getMeetingActivitiesByTeam(date('Y-m-01'), date('Y-m-d'));
        $call_activities = $this->getCallActivitiesByTeam(date('Y-m-01'), date('Y-m-d'));
        $message_activities = $this->getMessageActivitiesByTeam(date('Y-m-01'), date('Y-m-d'));
        $internal_events_by_team = $this->getInternalEventReportsByTeam(date('Y-m-01'), date('Y-m-d'));
        $external_events_by_team = $this->getExternalEventReportsByTeam(date('Y-m-01'), date('Y-m-d'));
        
        return view('home', compact('sectors', 'data', 'profiles', 'profiles_by_country', 'profiles_by_status', 'profiles_by_role', 'profiles_by_stage', 'email_activities', 'message_activities', 'call_activities', 'meeting_activities', 'internal_events_by_team', 'external_events_by_team'));
    }


    private function sectorByTeamGraph(){
        $activity_report = ActivityReport::all();
        $media_coverage = MediaCoverageReport::all();
        $event_reports = EventReport::all();

        
        foreach ($media_coverage as $key => $coverage) {
           $activity_report->push($coverage);
        }

         foreach ($event_reports as $key => $event) {
           $activity_report->push($event);
        }
       
        //Get Unique Activities contained in the report and make them chart legend
        $legend = array('Activities');
        $activities = array();
        $data = array();
        foreach ($activity_report as $key => $report) {
            array_push($activities, $report->Activity);
        }



        $activities = array_values(array_unique($activities));
    
        
        $legend = array_merge($legend, $activities);

        array_push($data, $legend);

        $report = array('HWPL');
        $sector = $activity_report->where('Sector', 'HWPL');
        foreach ($legend as $key => $value) {
            if($key > 0){
                $activity = $sector->where('Activity', $value)->first();
                if(count($activity) == 0){
                    array_push($report, 0); 
                } else {
                    array_push($report, $activity->Occurence);
                }
            }
        }

        
        array_push($data, $report);
      
        $report = array('IPYG');
        $sector = $activity_report->where('Sector', 'IPYG');
        foreach ($legend as $key => $value) {
            if($key > 0){
                $activity = $sector->where('Activity', $value)->first();
                if(count($activity) == 0){
                    array_push($report, 0); 
                } else {
                    array_push($report, $activity->Occurence);
                }
            }
        }

        array_push($data, $report);
      
        $report = array('IWPG');
        $sector = $activity_report->where('Sector', 'IWPG');
        foreach ($legend as $key => $value) {
            if($key > 0){
                $activity = $sector->where('Activity', $value)->first();
                if(count($activity) == 0){
                    array_push($report, 0); 
                } else {
                    array_push($report, $activity->Occurence);
                }
            }
        }
        array_push($data, $report);
        $data1 = collect($data);

        return json_encode($data);
    }

    private function getProfilesByCountry(){
        $profiles_by_country = Profile::getProfilesByCountry();

        $data = array();
        array_push($data, array('Countries', 'Profiles'));

        foreach($profiles_by_country as $profiles){
            array_push($data, array($profiles->country, $profiles->number_of_profiles));
        }

        return json_encode($data); 
    }

    private function getProfilesByStatus(){
        $profiles_by_status = Profile::getProfilesByStatus();

        $data = array();
        array_push($data, array('Status', 'Profiles'));

        foreach($profiles_by_status as $profiles){
            array_push($data, array($profiles->status, $profiles->number_of_profiles));
        }

        return json_encode($data); 
    }

    private function getProfilesByRole(){
        $profiles_by_role = Profile::getProfilesByRole();

        $data = array();
        array_push($data, array('Appointed Role', 'Profiles'));

        foreach($profiles_by_role as $profiles){
            array_push($data, array($profiles->role, $profiles->number_of_profiles));
        }

        return json_encode($data); 
    }

    private function getProfilesByStage(){
        $profiles_by_stage = Profile::getProfilesByStage();

        $data = array();
        array_push($data, array('Stage', 'Profiles'));

        foreach($profiles_by_stage as $profiles){
            array_push($data, array($profiles->stage, $profiles->number_of_profiles));
        }

        return json_encode($data); 
    }

    private function getEmailActivitiesByTeam($start_date, $end_date){
        $activity_type_id = $this->getActivityId('Email');
        $report_by_activity = ActivityTeamReport::getReportByTeam($activity_type_id, $start_date, $end_date);

        $data = array();
        array_push($data, array('Team', 'Emails'));

        foreach($report_by_activity as $activity){
            array_push($data, array($activity->Team, $activity->Occurence));
        }
        return json_encode($data); 
    }

    private function getMeetingActivitiesByTeam($start_date, $end_date){
        $activity_type_id = $this->getActivityId('Meeting');
        $report_by_activity = ActivityTeamReport::getReportByTeam($activity_type_id, $start_date, $end_date);

        $data = array();
        array_push($data, array('Team', 'Meetings'));

        foreach($report_by_activity as $activity){
            array_push($data, array($activity->Team, $activity->Occurence));
        }
        return json_encode($data); 
    }

    private function getCallActivitiesByTeam($start_date, $end_date){
        $activity_type_id = $this->getActivityId('Call');
        $report_by_activity = ActivityTeamReport::getReportByTeam($activity_type_id, $start_date, $end_date);

        $data = array();
        array_push($data, array('Team', 'Calls'));

        foreach($report_by_activity as $activity){
            array_push($data, array($activity->Team, $activity->Occurence));
        }
        return json_encode($data); 
    }

    private function getMessageActivitiesByTeam($start_date, $end_date){
        $activity_type_id = $this->getActivityId('Text Message (SMS)');
        $report_by_activity = ActivityTeamReport::getReportByTeam($activity_type_id, $start_date, $end_date);

        $data = array();
        array_push($data, array('Team', 'Messages'));

        foreach($report_by_activity as $activity){
            array_push($data, array($activity->Team, $activity->Occurence));
        }
        return json_encode($data); 
    }


    private function getInternalEventReportsByTeam($start_date, $end_date){
        $report_by_activity = ActivityTeamReport::getEventReportsByTeam('internal', $start_date, $end_date);

        $data = array();
        array_push($data, array('Team', 'Events'));

        foreach($report_by_activity as $activity){
            array_push($data, array($activity->Team, $activity->Occurence));
        }
        return json_encode($data); 
    }

    private function getExternalEventReportsByTeam($start_date, $end_date){
        $report_by_activity = ActivityTeamReport::getEventReportsByTeam('external', $start_date, $end_date);

        $data = array();
        array_push($data, array('Team', 'Events'));

        foreach($report_by_activity as $activity){
            array_push($data, array($activity->Team, $activity->Occurence));
        }
        return json_encode($data); 
    }

    private function getActivityId($activity_name){
        return ActivityType::where('name', '=', $activity_name)->first()->id;
    }
}
