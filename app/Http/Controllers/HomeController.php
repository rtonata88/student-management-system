<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ActivityTeamReport;
use App\ActivityReport;
use App\MediaCoverageReport;
use App\EventReport;
use App\Profile;
use App\ActivityType;

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
        return view('home');
    }


    private function sectorByTeamGraph($user){
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

    private function getProfilesByCountry($user){
        $profiles_by_country = Profile::getProfilesByCountry($user);

        $data = array();
        array_push($data, array('Countries', 'Profiles'));

        foreach($profiles_by_country as $profiles){
            array_push($data, array($profiles->country, $profiles->number_of_profiles));
        }

        return json_encode($data);
    }

    private function getProfilesByStatus($user){
        $profiles_by_status = Profile::getProfilesByStatus($user);

        $data = array();
        array_push($data, array('Status', 'Profiles'));

        foreach($profiles_by_status as $profiles){
            array_push($data, array($profiles->status, $profiles->number_of_profiles));
        }

        return json_encode($data);
    }

    private function getProfilesByRole($user){
        $profiles_by_role = Profile::getProfilesByRole($user);

        $data = array();
        array_push($data, array('Appointed Role', 'Profiles'));

        foreach($profiles_by_role as $profiles){
            array_push($data, array($profiles->role, $profiles->number_of_profiles));
        }

        return json_encode($data);
    }

    private function getProfilesByStage($user){
        $profiles_by_stage = Profile::getProfilesByStage($user);

        $data = array();
        array_push($data, array('Stage', 'Profiles'));

        foreach($profiles_by_stage as $profiles){
            array_push($data, array($profiles->stage, $profiles->number_of_profiles));
        }

        return json_encode($data);
    }

    private function getEmailActivitiesByTeam($user, $start_date, $end_date){
        $activity_type_id = $this->getActivityId('Email');
        $report_by_activity = ActivityTeamReport::getReportByTeam($activity_type_id, $start_date, $end_date);

        $data = array();
        array_push($data, array('Team', 'Emails'));

        foreach($report_by_activity as $activity){
            array_push($data, array($activity->Team, $activity->Occurence));
        }
        return json_encode($data);
    }

    private function getMeetingActivitiesByTeam($user, $start_date, $end_date){
        $activity_type_id = $this->getActivityId('Meeting');
        $report_by_activity = ActivityTeamReport::getReportByTeam($activity_type_id, $start_date, $end_date);

        $data = array();
        array_push($data, array('Team', 'Meetings'));

        foreach($report_by_activity as $activity){
            array_push($data, array($activity->Team, $activity->Occurence));
        }
        return json_encode($data);
    }

    private function getCallActivitiesByTeam($user, $start_date, $end_date){
        $activity_type_id = $this->getActivityId('Call');
        $report_by_activity = ActivityTeamReport::getReportByTeam($activity_type_id, $start_date, $end_date);

        $data = array();
        array_push($data, array('Team', 'Calls'));

        foreach($report_by_activity as $activity){
            array_push($data, array($activity->Team, $activity->Occurence));
        }
        return json_encode($data);
    }

    private function getMessageActivitiesByTeam($user, $start_date, $end_date){
        $activity_type_id = $this->getActivityId('Text Message (SMS)');
        $report_by_activity = ActivityTeamReport::getReportByTeam($activity_type_id, $start_date, $end_date);

        $data = array();
        array_push($data, array('Team', 'Messages'));

        foreach($report_by_activity as $activity){
            array_push($data, array($activity->Team, $activity->Occurence));
        }
        return json_encode($data);
    }


    private function getInternalEventReportsByTeam($user, $start_date, $end_date){
        $report_by_activity = ActivityTeamReport::getEventReportsByTeam('internal', $start_date, $end_date);

        $data = array();
        array_push($data, array('Team', 'Events'));

        foreach($report_by_activity as $activity){
            array_push($data, array($activity->Team, $activity->Occurence));
        }
        return json_encode($data);
    }

    private function getExternalEventReportsByTeam($user, $start_date, $end_date){
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
