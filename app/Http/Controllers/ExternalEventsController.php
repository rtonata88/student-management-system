<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\EventGallery;
use App\ExternalEventParticipant;
use App\EventReportConfiguration;
use App\Country;
use App\City;
use App\Sector;
use App\Team;
use Auth;

class ExternalEventsController extends Controller
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

    public function index(){
    	$events = Event::where('event_type', 'external')->get();
    	return view('external-events.index', compact('events'));
    }

    public function show(){
    	$event = Event::whereSlug($slug)->first();
    	$countries = Country::pluck('name', 'id');
		$cities = City::pluck('name', 'id');
		$sectors = Sector::pluck('name', 'id');
		$teams = Team::pluck('name', 'id');
    	return view('external-events.show', compact('event', 'countries','cities','sectors', 'teams'));
    }

    public function create(){
    	$countries = Country::pluck('name', 'id');
		$cities = City::pluck('name', 'id');
		$sectors = Sector::pluck('name', 'id');
		$teams = Team::pluck('name', 'id');
		return view('external-events.create', compact('countries','cities','sectors', 'teams'));
    }

    public function edit($slug){
    	$event = Event::whereSlug($slug)->first();
    	$countries = Country::pluck('name', 'id');
		$cities = City::pluck('name', 'id');
		$sectors = Sector::pluck('name', 'id');
		$teams = Team::pluck('name', 'id');
		return view('external-events.edit', compact('event', 'countries','cities','sectors', 'teams'));

    }

    public function store(Request $request){
    	$event = new Event;
    	$event->name = $request->name;
    	$event->slug = str_slug($request->name);
    	$event->event_type = 'external';
    	$event->objectives = $request->objectives;
    	$event->description = $request->description;
    	$event->event_program = $request->event_program;
    	$event->start_date = $request->start_date;
    	$event->start_time = $request->start_time;
    	$event->end_date = $request->end_date;
    	$event->end_time = $request->end_time;
    	$event->address_line1 = $request->address_line1;
    	$event->address_line2 = $request->address_line2;
    	$event->country_id = $request->country_id;
    	$event->city_id = $request->city_id;
    	$event->theme = $request->theme;
    	$event->save();

    	foreach ($request->path as $key => $value) {
			$gallery = new EventGallery;
			$path = $request->path[$key]->store('events/gallery/'.$event->id, 'public');
			$gallery->event_id = $event->id;
			$gallery->path = $path;
			$gallery->caption = $request->caption[$key];
			$gallery->created_by = Auth::user()->id;
			$gallery->save();
		}

		foreach ($request->fullname as $key => $participant_value) {
			$participant = new ExternalEventParticipant;
			$participant->event_id = $event->id;
			$participant->fullname = $request->fullname[$key];
			$participant->role = $request->role[$key];
			$participant->save();

		}

		$report = new EventReportConfiguration;
        $report->event_id = $event->id;
        $report->feedback_type = 'summary';
		$report->summary = $request->summary_outcome;
		$report->save();

		$event->team()->sync($request->team);
		$event->sector()->sync($request->sector);

		return redirect('/external-events');

    }

}
