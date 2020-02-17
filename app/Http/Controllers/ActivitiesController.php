<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Activity;
use App\Profile;
use App\Sector;
use App\Team;
use App\User;
use App\ActivityPhoto;
use App\ActivityType;
use App\Event;
use App\EventOrganization;
use App\EventActivity;
use App\EventActivityPhoto;

use Auth;
use Session;
use Route;

class ActivitiesController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$activities = Activity::all();

		return view('activities.index', compact('activities'));
	}

	public function create(Request $request, $profile_slug)
	{
		if($request->is('meetings/*'))
		{
			$activity_type = "Meeting";
			$activity_title= "POST MEETING REPORT";
		}

		if($request->is('calls/*'))
		{
			$activity_type = "Call";
			$activity_title= "CALL REPORT";
		}

		if($request->is('emails/*'))
		{
			$activity_type = "Email";
			$activity_title= "EMAIL REPORT";
		}

		if($request->is('messages/*'))
		{
			$activity_type = "Text Message (SMS)";
			$activity_title= "MESSAGE REPORT";
		}


		$profile = Profile::whereSlug($profile_slug)->first();

		$sectors = Sector::pluck('name', 'id');
		$teams = Team::pluck('name', 'id');
		$users = User::where('id', '<>', Auth::user()->id)->pluck('name', 'id');
		$profiles = Profile::selectRaw('id, CONCAT(fullname," ",lastname) AS name')->where('id', '<>', $profile->id)->pluck('name', 'id');

		return view('activities.create', compact('profile', 'sectors', 'teams', 'users', 'activity_type', 'activity_title', 'profiles'));
	}

	public function create_activity_report_from_events(Request $request, $type, $person, $event_slug){

		$route = Route::currentRouteName();
		if($type == 'Meeting')
		{
			$activity_type = "Meeting";
			$activity_title= "POST MEETING REPORT";
		}

		if($type == 'Call')
		{
			$activity_type = "Call";
			$activity_title= "CALL REPORT";
		}

		if($type == 'Email')
		{
			$activity_type = "Email";
			$activity_title= "EMAIL REPORT";
		}

		if($type == 'Text Message (SMS)')
		{
			$activity_type = "Text Message (SMS)";
			$activity_title= "MESSAGE REPORT";
		}

		$sectors = Sector::pluck('name', 'id');
		$teams = Team::pluck('name', 'id');
		$users = User::where('id', '<>', Auth::user()->id)->pluck('name', 'id');
		$event = Event::whereSlug($event_slug)->first();

		$profile = Profile::whereSlug($person)->first();
		$profiles = Profile::selectRaw('id, CONCAT(fullname," ",lastname) AS name')->where('id', '<>', $profile->id)->pluck('name', 'id');

		return view('events.activities.create-main_attendees', compact('profile', 'sectors', 'teams', 'users', 'activity_type', 'activity_title', 'event', 'other_participant', 'route', 'profiles'));
	}
	public function create_event_other_activities(Request $request, $type, $person, $event_slug){
		$route = Route::currentRouteName();
		if($type == 'Meeting')
		{
			$activity_type = "Meeting";
			$activity_title= "POST MEETING REPORT";
		}

		if($type == 'Call')
		{
			$activity_type = "Call";
			$activity_title= "CALL REPORT";
		}

		if($type == 'Email')
		{
			$activity_type = "Email";
			$activity_title= "EMAIL REPORT";
		}

		if($type == 'Text Message (SMS)')
		{
			$activity_type = "Text Message (SMS)";
			$activity_title= "MESSAGE REPORT";
		}

		$sectors = Sector::pluck('name', 'id');
		$teams = Team::pluck('name', 'id');
		$users = User::where('id', '<>', Auth::user()->id)->pluck('name', 'id');
		$event = Event::whereSlug($event_slug)->first();
		$participant = EventOrganization::find($person);

		$profile = Profile::whereSlug($person)->first();

		return view('events.activities.create-other_attendees', compact('profile', 'sectors', 'teams', 'users', 'activity_type', 'activity_title', 'event', 'route', 'participant', 'type'));
	}

	public function edit_activity_report_from_events($id){

		$activity = Activity::find($id);
		$activity_type = $activity->activity_type->name;
		$event = Event::find($activity->event->id)->first();
		$profile = Profile::whereSlug(Session::get('profile_id'))->first();
		$route = Route::currentRouteName();

		if($activity_type == "Meeting")
		{
			$activity_title= "POST MEETING REPORT";
		}

		if($activity_type == "Call")
		{
			$activity_title= "CALL REPORT";
		}

		if($activity_type == "Email")
		{
			$activity_type = "Email";
			$activity_title= "EMAIL REPORT";
		}

		if($activity_type == "Text Message (SMS)")
		{
			$activity_type = "Text Message (SMS)";
			$activity_title= "MESSAGE REPORT";
		}


		$sectors = Sector::pluck('name', 'id');
		$teams = Team::pluck('name', 'id');
		$users = User::where('id', '<>', Auth::user()->id)->pluck('name', 'id');
		$profiles = Profile::selectRaw('id, CONCAT(fullname," ",lastname) AS name')->where('id', '<>', $profile->id)->pluck('name', 'id');

		return view('events.activities.edit-main_attendees', compact('activity', 'sectors', 'teams', 'users', 'activity_type', 'activity_title', 'profiles', 'profile', 'event', 'route'));
	}

	public function edit_event_other_activities($id)
	{
		$activity = EventActivity::find($id);
		$activity_type = $activity->activity_type->name;
		$event = Event::find($activity->event->id)->first();
		$participant = EventOrganization::find($activity->participant->id);
		$route = Route::currentRouteName();

		if($activity_type == "Meeting")
		{
			$activity_title= "POST MEETING REPORT";
		}

		if($activity_type == "Call")
		{
			$activity_title= "CALL REPORT";
		}

		if($activity_type == "Email")
		{
			$activity_type = "Email";
			$activity_title= "EMAIL REPORT";
		}

		if($activity_type == "Text Message (SMS)")
		{
			$activity_type = "Text Message (SMS)";
			$activity_title= "MESSAGE REPORT";
		}


		$sectors = Sector::pluck('name', 'id');
		$teams = Team::pluck('name', 'id');
		$users = User::where('id', '<>', Auth::user()->id)->pluck('name', 'id');



		return view('events.activities.edit-other_attendees', compact('activity', 'sectors', 'teams', 'users', 'activity_type', 'activity_title', 'event', 'route', 'participant', 'activity_type'));
	}

	public function edit(Request $request, $activity_type, $id)
	{
		$profile_slug = session()->get('profile');
		$activity_type = Session::get('activity_type');
		$profile = Profile::whereSlug($profile_slug)->first();

		if($activity_type == "Meeting")
		{
			$activity_title= "POST MEETING REPORT";
		}

		if($activity_type == "Call")
		{
			$activity_title= "CALL REPORT";
		}

		if($activity_type == "Email")
		{
			$activity_type = "Email";
			$activity_title= "EMAIL REPORT";
		}

		if($activity_type == "Text Message (SMS)")
		{
			$activity_type = "Text Message (SMS)";
			$activity_title= "MESSAGE REPORT";
		}

		$activity = Activity::find($id);

		$sectors = Sector::pluck('name', 'id');
		$teams = Team::pluck('name', 'id');
		$users = User::where('id', '<>', Auth::user()->id)->pluck('name', 'id');
		$profiles = Profile::selectRaw('id, CONCAT(fullname," ",lastname) AS name')->where('slug', '<>', $profile_slug)->pluck('name', 'id');

		return view('activities.edit', compact('activity', 'sectors', 'teams', 'users', 'activity_type', 'activity_title', 'profiles', 'profile'));
	}

	public function store(Request $requests)
	{

		$activity = new Activity;

		$activity->activity_type_id = ActivityType::where('name', $requests->activity_type)->first()->id;
		if($requests->activity_type != 'Meeting'){
			$activity->direction = $requests->direction;
		}
		$activity->when = $requests->when;
		$activity->time = $requests->time;
		$activity->venue = $requests->where;
		$activity->outcome = $requests->outcome;
		$activity->why = $requests->why;
		$activity->save();

		//ACTIVITY PROFILES
		if(is_array($requests->profiles))
		{
			$profiles = $requests->profiles;
			if(!array_key_exists($requests->profile_id, $profiles)){
				array_push($profiles, $requests->profile_id);
			}
			$fruits = Profile::whereIn('id', $profiles)->get();
			$activity->profiles()->sync($profiles);
		} else {
			$fruits = Profile::whereIn('id', [$requests->profile_id])->get();
			$activity->profiles()->sync([$requests->profile_id]);
		}



		//ACTIVITY USERS
		if(is_array($requests->users))
		{
			$users = $requests->users;
			array_push($users, Auth::user()->id);
			$activity->users()->sync($users);
		} else {
			$activity->users()->sync(Auth::user()->id);
		}


		// ACTIVITY PHOTOS
		if(isset($requests->photos)){
			foreach ($fruits as $fruit) {
				foreach ($requests->photos as $key => $photo) {
					if (!is_null($photo)) {
						$photo = $photo->store('activity-photos/'.$fruit->slug, 'public');
						$activity_photo = new ActivityPhoto;
						$activity_photo->activity_id = $activity->id;
						$activity_photo->profile_id = $fruit->id;
						$activity_photo->path = $photo;
						$activity_photo->save();
					}
				}
			}
		}

		$profile = Profile::find($requests->profile_id);

		Session::flash('message', 'Activity successfully recorded. If you would like to make changes, please edit and save again. If you are happy, click <strong><a href="/profiles/'.$profile->slug.'" >go to profile</a></strong>');


		session()->put('profile', $profile->slug);
		session()->put('activity_type', $requests->activity_type);

		return redirect('/activities/'.$requests->activity_type.'/'.$activity->id.'/edit');
	}

	public function store_event_other_activities(Request $requests, $type, $person, $event_slug)
	{
		$route = Route::currentRouteName();
		$event = Event::whereSlug($event_slug)->first();
		$activity = new EventActivity;
		$activity->activity_type_id = ActivityType::where('name', $requests->activity_type)->first()->id;
		if($requests->activity_type != 'Meeting'){
			$activity->direction 	= $requests->direction;
		}
		$activity->event_id 		= $event->id;
		$activity->participant_id 	= $person;
		$activity->when 			= $requests->when;
		$activity->time 			= $requests->time;
		$activity->outcome 		= $requests->outcome;
		$activity->why 				= $requests->why;
		$activity->save();


		//ACTIVITY USERS
		if(is_array($requests->users))
		{
			$users = $requests->users;
			array_push($users, Auth::user()->id);
			$activity->users()->sync($users);
		} else {
			$activity->users()->sync(Auth::user()->id);
		}

		// ACTIVITY PHOTOS
		if(isset($requests->photos)){
			foreach ($requests->photos as $key => $photo) {
				if (!is_null($photo)) {
					$photo = $photo->store('events/'.$event->id.'/activity-photos/'.$requests->id.'/'.$activity->id, 'public');
					$activity_photo = new EventActivityPhoto;
					$activity_photo->activity_id = $activity->id;
					$activity_photo->other_participant_id = $person;
					$activity_photo->path = $photo;
					$activity_photo->save();
				}
			}
		}

		Session::flash('message', 'Activity successfully recorded. If you would like to make changes, please edit and save again. If you are happy, click <strong><a href="/events/'.$event->slug.'" >go to event page</a></strong>');


		session()->put('particant_id', $person);
		session()->put('activity_type', $requests->activity_type);
		session()->put('activity_id', $activity->id);

		return redirect()->route('edit.other_participant.activityReport', $activity->id);
	}

	public function store_activity_report_from_events(Request $requests, $type, $id, $event_slug)
	{

		$event = Event::whereSlug($event_slug)->first();

		$activity = new Activity;
		$activity->activity_type_id = ActivityType::where('name', $requests->activity_type)->first()->id;
		if($requests->activity_type != 'Meeting'){
			$activity->direction = $requests->direction;
		}
		$activity->when = $requests->when;
		$activity->is_related_to_event = 1;
		$activity->event_id = $event->id;
		$activity->when = $requests->when;
		$activity->time = $requests->time;
		$activity->outcome = $requests->outcome;
		$activity->why = $requests->why;
		$activity->save();

		//ACTIVITY PROFILES
		if(is_array($requests->profiles))
		{

			$profiles = $requests->profiles;
			if(!array_key_exists($requests->profile_id, $profiles)){
				array_push($profiles, $requests->profile_id);
			}
			$fruits = Profile::whereIn('id', $profiles)->get();
			$activity->profiles()->sync($profiles);
		} else {
			$fruits = Profile::whereIn('id', [$requests->profile_id])->get();
			$activity->profiles()->sync([$requests->profile_id]);
		}


		//ACTIVITY USERS
		if(is_array($requests->users))
		{
			$users = $requests->users;
			array_push($users, Auth::user()->id);
			$activity->users()->sync($users);
		} else {
			$activity->users()->sync(Auth::user()->id);
		}

		// ACTIVITY PHOTOS
		if(isset($requests->photos)){
			foreach ($fruits as $fruit) {
				foreach ($requests->photos as $key => $photo) {
					if (!is_null($photo)) {
						$photo = $photo->store('events/photos/activities/'.$event->id.'/'.$fruit->id, 'public');
						$activity_photo = new ActivityPhoto;
						$activity_photo->activity_id = $activity->id;
						$activity_photo->profile_id = $fruit->id;
						$activity_photo->path = $photo;
						$activity_photo->save();
					}
				}
			}
		}

		$profile = Profile::find($requests->profile_id);
		Session::flash('message', 'Activity successfully recorded. If you would like to make changes, please edit and save again. If you are happy, click <strong><a href="/events/'.$event->slug.'" >go to event page</a></strong>');


		session()->put('profile_id', $profile->slug);
		session()->put('activity_type', $requests->activity_type);

		return redirect('/events/activity-report/'.$activity->id.'/edit');
	}


	public function update(Request $requests, $activity_id, $profileSlug)
	{
		$activity = Activity::find($activity_id);

		if($activity->activity_type->name != 'Meeting'){
			$activity->direction = $requests->direction;
		}
		$activity->when = $requests->when;
		$activity->outcome = $requests->outcome;
		$activity->why = $requests->why;
		$activity->save();

		//ACTIVITY PROFILES
		if(is_array($requests->profiles))
		{

			$profiles = $requests->profiles;
			if(!array_key_exists($requests->profile_id, $profiles)){
				array_push($profiles, $requests->profile_id);
			}
			$fruits = Profile::whereIn('id', $profiles)->get();
			$activity->profiles()->sync($profiles);
		} else {
			$fruits = Profile::whereIn('id', [$requests->profile_id])->get();
			$activity->profiles()->sync([$requests->profile_id]);
		}



		//ACTIVITY USERS
		if(is_array($requests->users))
		{
			$users = $requests->users;
			array_push($users, Auth::user()->id);
			$activity->users()->sync($users);
		} else {
			$activity->users()->sync(Auth::user()->id);
		}


		// ACTIVITY PHOTOS
		if(isset($requests->photos)){
			foreach ($fruits as $fruit) {
				foreach ($requests->photos as $key => $photo) {
					if (!is_null($photo)) {
						$photo = $photo->store('activity-photos/'.$fruit->slug, 'public');
						$activity_photo = new ActivityPhoto;
						$activity_photo->activity_id = $activity->id;
						$activity_photo->profile_id = $fruit->id;
						$activity_photo->path = $photo;
						$activity_photo->save();
					}
				}
			}
		}


		Session::flash('message', 'Activity successfully recorded. If you would like to make changes, please edit and save again. If you are happy, click the <strong>Go to Profile</strong> link below.');




		return redirect('/activities/'.$requests->activity_type.'/'.$activity->id.'/edit');
	}

	public function update_activity_report_from_events(Request $requests, $id){


		$activity = Activity::find($id);
		$event = $activity->event;
		$activity->activity_type_id = ActivityType::where('name', $requests->activity_type)->first()->id;
		if($requests->activity_type != 'Meeting'){
			$activity->direction = $requests->direction;
		}
		$activity->when = $requests->when;
		$activity->is_related_to_event = 1;
		$activity->event_id = $event->id;
		$activity->when = $requests->when;
		$activity->time = $requests->time;
		$activity->outcome = $requests->outcome;
		$activity->why = $requests->why;
		$activity->save();

		//ACTIVITY PROFILES
		if(is_array($requests->profiles))
		{
			$profiles = $requests->profiles;
			if(!array_key_exists($requests->profile_id, $profiles)){
				array_push($profiles, $requests->profile_id);
			}
			$fruits = Profile::whereIn('id', $profiles)->get();
			$activity->profiles()->sync($profiles);
		} else {
			$fruits = Profile::whereIn('id', [$requests->profile_id])->get();
			$activity->profiles()->sync([$requests->profile_id]);
		}


		//ACTIVITY USERS
		if(is_array($requests->users))
		{
			$users = $requests->users;
			array_push($users, Auth::user()->id);
			$activity->users()->sync($users);
		} else {
			$activity->users()->sync(Auth::user()->id);
		}

		// ACTIVITY PHOTOS
		if(isset($requests->photos)){
			foreach ($fruits as $fruit) {
				foreach ($requests->photos as $key => $photo) {
					if (!is_null($photo)) {
						$photo = $photo->store('events/photos/activities/'.$event->id.'/'.$fruit->id, 'public');
						$activity_photo = new ActivityPhoto;
						$activity_photo->activity_id = $activity->id;
						$activity_photo->profile_id = $fruit->id;
						$activity_photo->path = $photo;
						$activity_photo->save();
					}
				}
			}
		}

		$profile = Profile::find($requests->profile_id);
		Session::flash('message', 'Activity successfully recorded. If you would like to make changes, please edit and save again. If you are happy, click <strong><a href="/events/'.$event->slug.'" >go to event page</a></strong>');


		session()->put('profile_id', $profile->slug);
		session()->put('activity_type', $requests->activity_type);

		return redirect('/events/activity-report/'.$activity->id.'/edit');
	}
	public function update_event_other_activities(Request $requests, $id){
		$activity = EventActivity::find($id);

		if($activity->activity_type->name != 'Meeting'){
			$activity->direction = $requests->direction;
		}
		$activity->when = $requests->when;
		$activity->when = $requests->when;
		$activity->time = $requests->time;
		$activity->outcome = $requests->outcome;
		$activity->why = $requests->why;
		$activity->save();


		//ACTIVITY USERS
		if(is_array($requests->users))
		{
			$users = $requests->users;
			array_push($users, Auth::user()->id);
			$activity->users()->sync($users);
		} else {
			$activity->users()->sync(Auth::user()->id);
		}


		// ACTIVITY PHOTOS
		if(isset($requests->photos)){
			foreach ($requests->photos as $key => $photo) {
				if (!is_null($photo)) {
					$photo = $photo->store('activity-photos/'.$fruit->slug, 'public');
					$activity_photo = new ActivityPhoto;
					$activity_photo->activity_id = $activity->id;
					$activity_photo->profile_id = $fruit->id;
					$activity_photo->path = $photo;
					$activity_photo->save();
				}
			}
	}

	Session::flash('message', 'Activity successfully recorded. If you would like to make changes, please edit and save again. If you are happy, click <strong><a href="/events/'.$activity->event->slug.'" >go to event page</a></strong>');

		return redirect()->route('edit.other_participant.activityReport', $activity->id);
	}
}
