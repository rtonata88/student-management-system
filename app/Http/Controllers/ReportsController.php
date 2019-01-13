<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\EventReportConfiguration;
use App\EventParticipant;
use App\EventReportMisc;
use App\ActivityReport;
use App\MediaCoverageReport;
use App\EventReport;
use App\Sector;
use App\ActivityTeamReport;
use App\Team;
use Excel;
use App\Exports\PeriodicReportsExport;

class ReportsController extends Controller
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


    public function periodic_index(){
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

        $data =  json_encode($data);

        return view('reports.periodic.index', compact('data', 'data1'));
    }

    public function sector_report($sector){
        $sector = Sector::where('name', $sector)->first();
        $teams = Team::where('sector_id', $sector->id)->pluck('name', 'id');
        $team_report = ActivityTeamReport::report($sector->id, 0, date('Y-m-01'), date('Y-m-d'));
        $media_coverage_report = ActivityTeamReport::media_coverage($sector->id, 0, date('Y-m-01'), date('Y-m-d'));
        $events = ActivityTeamReport::events($sector->id, 0, date('Y-m-01'), date('Y-m-d'));

        $start_date = date('Y-m-01');
        $end_date = date('Y-m-d');
        return view('reports.periodic.sector', compact('sector', 'teams', 'team_report', 'start_date', 'end_date', 'media_coverage_report', 'events'));
    }

    public function report_filter(Request $requests, $sector){
        $sector = Sector::where('name', $sector)->first();

        $teams = Team::where('sector_id', $sector->id)->pluck('name', 'id');
        $team_report = ActivityTeamReport::report($sector->id, $requests->team_id, $requests->start_date, $requests->end_date);
        $media_coverage_report = ActivityTeamReport::media_coverage($sector->id, $requests->team_id,$requests->start_date, $requests->end_date);
        $events = ActivityTeamReport::events($sector->id, $requests->team_id,$requests->start_date, $requests->end_date);

        $start_date = $requests->start_date;
        $end_date = $requests->end_date;

        $requests->session()->put('team_id', $requests->team_id);
        $requests->session()->put('start_date', $requests->start_date);
        $requests->session()->put('end_date', $requests->end_date);

        return view('reports.periodic.sector', compact('sector', 'teams', 'team_report', 'start_date', 'end_date', 'media_coverage_report', 'events'));
    }

    public function export($sector) 
    {        
        $export = new PeriodicReportsExport($sector);
        return Excel::download($export, $sector.'.xlsx');
    }

    public function events_report_index($type){
    	$events = Event::where('event_type', $type)->get();


    	return view('reports.events.index', compact('events'));
    }

    public function events_report_view($slug){
        $event = Event::whereSlug($slug)->first();
        return view('reports.events.view', compact('event'));
    }

    public function events_report_print($slug){
        $event = Event::whereSlug($slug)->first();
        return view('reports.events.print', compact('event'));
    }

    public function events_report_create($slug){
        $event = Event::whereSlug($slug)->first();
        return view('reports.events.create', compact('event'));
    }

    public function events_report_edit($slug){
        $event = Event::whereSlug($slug)->first();
        $report_config = $event->report;
        return view('reports.events.edit', compact('event', 'report_config'));
    }


    public function events_report_store(Request $requests, $slug){
        
        $event = Event::whereSlug($slug)->first();
        $config = new EventReportConfiguration;
        $config->event_id = $event->id;
        $config->feedback_type = $requests->feedback_type;
        $config->strengths  = $requests->strengths;
        $config->weaknesses = $requests->weaknesses;
        $config->opportunities = $requests->opportunities;
        $config->threats = $requests->threats;
        
        if($requests->feedback_type == 'detailed')
        {
            foreach ($requests->detailed_outcome as $profile_id => $outcome) { 
                $participant = EventParticipant::where('profile_id', $profile_id)->where('event_id', $event->id)->first(); 
                $participant->feedback = $outcome;
                $participant->save();
            }
        } else if ($requests->feedback_type == 'summary'){
            $config->summary      = $requests->summary_outcome;
        } else {
            foreach ($requests->detailed_outcome as $profile_id => $outcome) 
            { 
                $participant = EventParticipant::where('profile_id', $profile_id)->where('event_id', $event->id)->first(); 
                $participant->feedback = $outcome;
                $participant->save();
            }

            $config->summary      = $requests->summary_outcome;
        }

        $config->save();

        if(count($requests->misc) > 0){
            foreach ($requests->misc as $misc_id => $misc) { 
                $report_misc = new EventReportMisc;
                $report_misc->report_id = $config->id;
                $report_misc->misc_id = $misc_id;
                $report_misc->timestamps = false;
                $report_misc->save();
            }
        }
        return redirect('/report/events/view/'.$event->slug);
    }

    public function events_report_update(Request $requests, $slug, $id){
        
        $event = Event::whereSlug($slug)->first();
        $config = EventReportConfiguration::find($id);
        $config->event_id = $event->id;
        $config->feedback_type = $requests->feedback_type;
        $config->strengths  = $requests->strengths;
        $config->weaknesses = $requests->weaknesses;
        $config->opportunities = $requests->opportunities;
        $config->threats = $requests->threats;
        
        if($requests->feedback_type == 'detailed')
        {
            foreach ($requests->detailed_outcome as $profile_id => $outcome) { 
                $participant = EventParticipant::where('profile_id', $profile_id)->where('event_id', $event->id)->first(); 
                $participant->feedback = $outcome;
                $participant->save();
            }
        } else if ($requests->feedback_type == 'summary'){
            $config->summary      = $requests->summary_outcome;
        } else {
            foreach ($requests->detailed_outcome as $profile_id => $outcome) 
            { 
                $participant = EventParticipant::where('profile_id', $profile_id)->where('event_id', $event->id)->first(); 
                $participant->feedback = $outcome;
                $participant->save();
            }

            $config->summary      = $requests->summary_outcome;
        }

        $config->save();
        EventReportMisc::where('report_id', $config->id)->delete();
        if(count($requests->misc) > 0){
            foreach ($requests->misc as $misc_id => $misc) { 
                $report_misc = new EventReportMisc;
                $report_misc->report_id = $config->id;
                $report_misc->misc_id = $misc_id;
                $report_misc->timestamps = false;
                $report_misc->save();
            }
        }
        return redirect('/report/events/view/'.$event->slug);
    }
}
    