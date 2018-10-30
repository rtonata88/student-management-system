<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\EventReportConfiguration;
use App\EventParticipant;
use App\EventReportMisc;

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
    