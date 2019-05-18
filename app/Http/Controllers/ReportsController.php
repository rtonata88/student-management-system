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
use App\Profile;
use App\ActivityTeamReport;
use App\Team;
use App\Country;
use App\Organization;
use App\Documentation;
use App\City;
use App\FruitRole;
use App\FruitLevel;
use App\FruitStage;
use App\DocumentationType;
use Excel;
use EloquentBuilder;
use App\Exports\PeriodicReportsExport;
use App\Exports\ProfilesExport;
use App\Exports\DocumentationsExport;
use Freshbitsweb\Laratables\Laratables;
use App\WarpSummitAttendee;
use Session;

class ReportsController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function periodic_index() {
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
            if ($key > 0) {
                $activity = $sector->where('Activity', $value)->first();
                if (count($activity) == 0) {
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
            if ($key > 0) {
                $activity = $sector->where('Activity', $value)->first();
                if (count($activity) == 0) {
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
            if ($key > 0) {
                $activity = $sector->where('Activity', $value)->first();
                if (count($activity) == 0) {
                    array_push($report, 0);
                } else {
                    array_push($report, $activity->Occurence);
                }
            }
        }
        array_push($data, $report);
        $data1 = collect($data);

        $data = json_encode($data);

        return view('reports.periodic.index', compact('data', 'data1'));
    }

    /**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function profiles() {
        $profiles = '';
        $sectors = Sector::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        $organizations = Organization::pluck('name', 'id');
        $cities = City::pluck('name', 'id');
        $fruit_roles = FruitRole::pluck('role', 'id');
        $teams = Team::pluck('name', 'id');
        $fruit_levels = FruitLevel::pluck('level', 'id');
        $fruit_stages = FruitStage::pluck('stage', 'id');

        return view('reports.profiles.index', compact('teams', 'profiles', 'sectors', 'countries', 'organizations', 'cities', 'fruit_stages', 'fruit_levels', 'fruit_roles'));
    }

    public function WarpAttendees(){
        $attendees = '';
        return view('reports.warp.index', compact('attendees'));
    }

     public function WarpAttendeesSearch(Request $request){
        $year_from = intval(date('Y', strtotime($request->date_from)));
        $year_to = intval(date('Y', strtotime($request->date_to)));
        if($year_from == $year_to){
            $attendees = WarpSummitAttendee::whereYear('date_attended', $year_from)->get();
        } else if ($year_from < $year_to){
            $attendees = WarpSummitAttendee::whereBetween('date_attended',[$request->date_from, $request->date_to])->get();
        } else if ($year_from > $year_to){
            $attendees = '';
            Session::flash('message', 'The Date To cannot be earlier than Date From ');
        }
        return view('reports.warp.index', compact('attendees'));
    }

    public function searchProfiles(Request $request){
        $profiles = Profile::with('team', 'country');
        $profiles = EloquentBuilder::to($profiles, $request->except(['_token']));
        $profiles = $profiles->paginate(25);


        $sectors = Sector::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        $organizations = Organization::pluck('name', 'id');
        $cities = City::pluck('name', 'id');
        $fruit_roles = FruitRole::pluck('role', 'id');
        $teams = Team::pluck('name', 'id');
        $fruit_levels = FruitLevel::pluck('level', 'id');
        $fruit_stages = FruitStage::pluck('stage', 'id');

        session()->put('user_filter', $request->except(['_token']));

        return view('reports.profiles.index', compact('profiles', 'teams', 'profiles', 'sectors', 'countries', 'organizations', 'cities', 'fruit_stages', 'fruit_levels', 'fruit_roles'));
    }

    public function documentation() {
        $documentations = '';
        $sectors = Sector::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        $documentation_type = DocumentationType::pluck('type', 'id');

        return view('reports.documentations.index', 
            compact('documentations', 'sectors', 'countries', 'documentation_type'));
    }

    public function searchDocumentations(Request $request){
        $documentations = Documentation::select('profiles.fullname', 'profiles.lastname', 'genders.gender', 'profiles.dob', 'profiles.position', 'organizations.name as organization', 'sectors.name as sector', 'countries.name as country', 'cities.name as city', 'profiles.mobile_no', 'profiles.work_number', 'profiles.email', 'documentations.effective_date', 'documentation_types.type')
            ->join('profiles', 'profiles.id', '=', 'documentations.id')
            ->leftJoin('genders', 'genders.id', '=', 'profiles.gender_id')
            ->leftjoin('organizations', 'organizations.id', '=', 'profiles.organization_id')
            ->leftJoin('sectors', 'sectors.id', '=', 'profiles.sector_id')
            ->leftJoin('countries', 'countries.id', '=', 'profiles.country_id')
            ->leftJoin('cities', 'cities.id', '=', 'profiles.city_id')
            ->leftjoin('documentation_types', 'documentation_types.id', '=', 'documentations.documentation_type_id');

        $documentations = EloquentBuilder::to($documentations, $request->except(['_token']));
        $documentations = $documentations->paginate(25);


        $sectors = Sector::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        $documentation_type = DocumentationType::pluck('type', 'id');

        session()->put('documentation_filter', $request->except(['_token']));

        return view('reports.documentations.index', 
            compact('profiles', 'teams', 'documentations', 'sectors', 'countries', 'organizations', 'cities', 'documentation_type'));
    }


    public function exportProfilesToExcel(Request $requests){
        return Excel::download(new ProfilesExport, 'profiles.xlsx');
    }

    public function exportDocumentationsToExcel(Request $requests){
        return Excel::download(new DocumentationsExport, 'profiles.xlsx');   
    }


    public function sector_report($sector) {
        $sector = Sector::where('name', $sector)->first();
        $teams = Team::where('sector_id', $sector->id)->pluck('name', 'id');
        $team_report = ActivityTeamReport::report($sector->id, 0, date('Y-m-01'), date('Y-m-d'));
        $media_coverage_report = ActivityTeamReport::media_coverage($sector->id, 0, date('Y-m-01'), date('Y-m-d'));
        $events = ActivityTeamReport::events($sector->id, 0, date('Y-m-01'), date('Y-m-d'));

        $start_date = date('Y-m-01');
        $end_date = date('Y-m-d');
        return view('reports.periodic.sector', compact('sector', 'teams', 'team_report', 'start_date', 'end_date', 'media_coverage_report', 'events'));
    }

    public function report_filter(Request $requests, $sector) {


        $sector = Sector::where('name', $sector)->first();

        $teams = Team::where('sector_id', $sector->id)->pluck('name', 'id');
        $team_report = ActivityTeamReport::report($sector->id, $requests->team_id, $requests->start_date, $requests->end_date);
        $media_coverage_report = ActivityTeamReport::media_coverage($sector->id, $requests->team_id, $requests->start_date, $requests->end_date);
        $events = ActivityTeamReport::events($sector->id, $requests->team_id, $requests->start_date, $requests->end_date);

        
        $start_date = $requests->start_date;
        $end_date = $requests->end_date;

        $requests->session()->put('team_id', $requests->team_id);
        $requests->session()->put('start_date', $requests->start_date);
        $requests->session()->put('end_date', $requests->end_date);

        return view('reports.periodic.sector', compact('sector', 'teams', 'team_report', 'start_date', 'end_date', 'media_coverage_report', 'events'));
    }

    public function export($sector) {
        $export = new PeriodicReportsExport($sector);
        return Excel::download($export, $sector . '.xlsx');
    }

    public function events_report_index($type) {
        $events = Event::where('event_type', $type)->get();


        return view('reports.events.index', compact('events'));
    }

    public function events_report_view($slug) {
        $event = Event::whereSlug($slug)->first();
        return view('reports.events.view', compact('event'));
    }

    public function events_report_print($slug) {
        $event = Event::whereSlug($slug)->first();
        return view('reports.events.print', compact('event'));
    }

    public function events_report_create($slug) {
        $event = Event::whereSlug($slug)->first();
        return view('reports.events.create', compact('event'));
    }

    public function events_report_edit($slug) {
        $event = Event::whereSlug($slug)->first();
        $report_config = $event->report;
        return view('reports.events.edit', compact('event', 'report_config'));
    }

    public function events_report_store(Request $requests, $slug) {

        $event = Event::whereSlug($slug)->first();
        $config = new EventReportConfiguration;
        $config->event_id = $event->id;
        $config->feedback_type = $requests->feedback_type;
        $config->strengths = $requests->strengths;
        $config->weaknesses = $requests->weaknesses;
        $config->opportunities = $requests->opportunities;
        $config->threats = $requests->threats;

        if ($requests->feedback_type == 'detailed') {
            foreach ($requests->detailed_outcome as $profile_id => $outcome) {
                $participant = EventParticipant::where('profile_id', $profile_id)->where('event_id', $event->id)->first();
                $participant->feedback = $outcome;
                $participant->save();
            }
        } else if ($requests->feedback_type == 'summary') {
            $config->summary = $requests->summary_outcome;
        } else {
            foreach ($requests->detailed_outcome as $profile_id => $outcome) {
                $participant = EventParticipant::where('profile_id', $profile_id)->where('event_id', $event->id)->first();
                $participant->feedback = $outcome;
                $participant->save();
            }

            $config->summary = $requests->summary_outcome;
        }

        $config->save();

        if (count($requests->misc) > 0) {
            foreach ($requests->misc as $misc_id => $misc) {
                $report_misc = new EventReportMisc;
                $report_misc->report_id = $config->id;
                $report_misc->misc_id = $misc_id;
                $report_misc->timestamps = false;
                $report_misc->save();
            }
        }
        return redirect('/report/events/view/' . $event->slug);
    }

    public function events_report_update(Request $requests, $slug, $id) {

        $event = Event::whereSlug($slug)->first();
        $config = EventReportConfiguration::find($id);
        $config->event_id = $event->id;
        $config->feedback_type = $requests->feedback_type;
        $config->strengths = $requests->strengths;
        $config->weaknesses = $requests->weaknesses;
        $config->opportunities = $requests->opportunities;
        $config->threats = $requests->threats;

        if ($requests->feedback_type == 'detailed') {
            foreach ($requests->detailed_outcome as $profile_id => $outcome) {
                $participant = EventParticipant::where('profile_id', $profile_id)->where('event_id', $event->id)->first();
                $participant->feedback = $outcome;
                $participant->save();
            }
        } else if ($requests->feedback_type == 'summary') {
            $config->summary = $requests->summary_outcome;
        } else {
            foreach ($requests->detailed_outcome as $profile_id => $outcome) {
                $participant = EventParticipant::where('profile_id', $profile_id)->where('event_id', $event->id)->first();
                $participant->feedback = $outcome;
                $participant->save();
            }

            $config->summary = $requests->summary_outcome;
        }

        $config->save();
        EventReportMisc::where('report_id', $config->id)->delete();
        if (count($requests->misc) > 0) {
            foreach ($requests->misc as $misc_id => $misc) {
                $report_misc = new EventReportMisc;
                $report_misc->report_id = $config->id;
                $report_misc->misc_id = $misc_id;
                $report_misc->timestamps = false;
                $report_misc->save();
            }
        }
        return redirect('/report/events/view/' . $event->slug);
    }

}
