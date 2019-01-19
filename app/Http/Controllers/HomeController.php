<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ActivityTeamReport;
use App\ActivityReport;
use App\MediaCoverageReport;
use App\EventReport;
use App\Profile;

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
        
        return view('home', compact('sectors', 'data', 'profiles'));
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
}
