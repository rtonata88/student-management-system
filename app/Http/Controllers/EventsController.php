<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;
use App\Country;
use App\City;
use App\EventDiscussion;
use App\EventParticipantRole;
use App\EventStaffRole;
use App\EventActivityLog;
use App\Profile;
use App\EventParticipant;
use App\EventOrganization;
use App\User;
use App\Sector;
use App\Team;
use App\EventStaff;

use Auth;

class EventsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$events = Event::all();

		return view('events.index', compact('events'));
	}

	public function create(){
		$countries = Country::pluck('name', 'id');
		$cities = City::pluck('name', 'id');
		$sectors = Sector::pluck('name', 'id');
		$teams = Team::pluck('name', 'id');
		return view('events.create', compact('countries','cities', 'sectors', 'teams'));
	}

	public function edit($slug)
	{
		$event = Event::whereSlug($slug)->first();
		$countries = Country::pluck('name', 'id');
		$cities = City::pluck('name', 'id');
		$participant_roles = EventParticipantRole::where('event_id', $event->id)->get();
		$staff_roles = EventStaffRole::where('event_id', $event->id)->get();
		$discussions = EventDiscussion::where('event_id', $event->id)->get();

		$sectors = Sector::pluck('name', 'id');
		$teams = Team::pluck('name', 'id');
		
		return view('events.edit', compact('countries','cities', 'event', 'participant_roles', 'staff_roles', 'discussions', 'sectors', 'teams'));
	}

	public function show($slug){
		$event = Event::whereSlug($slug)->with('participants')->first();

		$profiles = Profile::selectRaw('id, CONCAT(fullname," ",lastname) AS name')
						   ->whereNotIn('id', $event->participants->pluck('profile_id')->toarray())
						   ->pluck('name', 'id');
		$participant_roles 	= $event->participant_roles->pluck('role_name', 'id');
		$staff_roles 		= $event->staff_roles->pluck('role_name', 'id');
		$event_staff 		= EventStaff::where('event_id', $event->id)->pluck('user_id');
		$users = User::whereNotIn('id',$event_staff)->pluck('name', 'id');


		return view('events.show', compact('event', 'profiles', 'participant_roles', 'staff_roles', 'users'));
	}

	public function store(Request $requests)
	{
		$event = new Event;
		$event->name = $requests->name;
		$event->slug = str_slug($requests->name);
		$event->description = $requests->description;
		$event->objectives = $requests->objectives;
		$event->start_date = $requests->start_date;
		$event->end_date = $requests->end_date;
		$event->start_time = $requests->start_time;
		$event->end_time = $requests->end_time;
		$event->address_line1 = $requests->address_line1;
		$event->address_line2 = $requests->address_line2;
		$event->country_id = $requests->country_id;
		$event->city_id = $requests->city_id;
		$event->theme = $requests->theme;
		$event->event_program = $requests->event_program;
		$event->created_by = Auth::user()->id;
		$event->save();

		//Discussions
		foreach ($requests->event_discussion as $discussion_key => $discussion_value) {
			$discussion = new EventDiscussion;
			$discussion->event_id = $event->id;
			$discussion->discussion_point = $discussion_value;
			$discussion->save();

		}

		//Participant Roles
		foreach ($requests->participant_roles as $participant_key => $participant_value) {
			$participant = new EventParticipantRole;
			$participant->event_id = $event->id;
			$participant->role_name = $participant_value;
			$participant->save();

		}

		//Staff Roles
		foreach ($requests->staff_roles as $staff_role_key => $staff_role_value) {
			$staff_role = new EventStaffRole;
			$staff_role->event_id = $event->id;
			$staff_role->role_name = $staff_role_value;
			$staff_role->save();

		}

		//Create event activity log
		EventActivityLog::create(['event_id' => $event->id, 'action'=>'CreateEvent', 'user_id'=>Auth::user()->id, 'description'=>'created the event']);


		return redirect()->route('events.show', ['slug' => $event->slug]);

	}


	public function update(Request $requests, $slug){
		$event =  Event::whereSlug($slug)->first();

		switch ($requests->update) {
			case 'EventProgram':
				$event->event_program = $requests->content;
				$event->save();

					//Create event activity log
				EventActivityLog::create(['event_id' => $event->id, 'action'=>'EventProgram', 'user_id'=>Auth::user()->id, 'description'=>'updated event program']);
			break;
			case 'InviteAttendee':
				if($requests->profile_y_n == 'y')
				{
					EventParticipant::create(['event_id' => $event->id, 'profile_id' => $requests->profile_id, 'participant_role_id' => $requests->participant_role_id, 'rsvp_status' => 'PENDING']);

					$profile = Profile::find($requests->profile_id);
					//Create event activity log
					EventActivityLog::create(['event_id' => $event->id, 'action'=>'InviteAttendee', 'participant_id' => $requests->profile_id, 'user_id'=>Auth::user()->id, 'description'=>"invited <a href='/profiles/".$profile->slug."'>". $profile->fullname.' '.$profile->lastname." </a>"]);
				} else {
					if(isset($requests->send_mail)){
						$send_mail = 1;
					} else {
						$send_mail = 0;
					}
					EventOrganization::create(['event_id' => $event->id, 'name' => $requests->name, 'participant_role_id' => $requests->participant_role_id, 'email' => $requests->email, 'send_mail' => $send_mail]);

					//Create event activity log
					EventActivityLog::create(['event_id' => $event->id, 'action'=>'InviteAttendee', 'user_id'=>Auth::user()->id, 'description'=>"invited ".$requests->name]);
				}
			break;
			
			default:
				$event->name = $requests->name;
				$event->slug = str_slug($requests->name);
				$event->description = $requests->description;
				$event->objectives = $requests->objectives;
				$event->start_date = $requests->start_date;
				$event->end_date = $requests->end_date;
				$event->start_time = $requests->start_time;
				$event->end_time = $requests->end_time;
				$event->address_line1 = $requests->address_line1;
				$event->address_line2 = $requests->address_line2;
				$event->country_id = $requests->country_id;
				$event->city_id = $requests->city_id;
				$event->theme = $requests->theme;
				$event->event_program = $requests->event_program;
				$event->created_by = Auth::user()->id;
				$event->save();

				$event->team()->sync($requests->team);
				$event->sector()->sync($requests->sector);

				//Delete Event related models
				$event->discussions()->delete();
				$event->participant_roles()->delete();
				$event->staff_roles()->delete();

				//Discussions
				foreach ($requests->event_discussion as $discussion_key => $discussion_value) {
					$discussion = new EventDiscussion;
					$discussion->event_id = $event->id;
					$discussion->discussion_point = $discussion_value;
					$discussion->save();

				}

				//Participant Roles
				foreach ($requests->participant_roles as $participant_key => $participant_value) {
					$participant = new EventParticipantRole;
					$participant->event_id = $event->id;
					$participant->role_name = $participant_value;
					$participant->save();

				}

				//Staff Roles
				foreach ($requests->staff_roles as $staff_role_key => $staff_role_value) {
					$staff_role = new EventStaffRole;
					$staff_role->event_id = $event->id;
					$staff_role->role_name = $staff_role_value;
					$staff_role->save();

				}

				//Create event activity log
				EventActivityLog::create(['event_id' => $event->id, 'action'=>'UpdateEvent', 'user_id'=>Auth::user()->id, 'description'=>'updated event details']);
			break;
		}

		return redirect()->route('events.show', ['slug' => $event->slug]);
	}


	public function manage($slug, $action, $participant = null)
	{
		$event = Event::whereSlug($slug)->first();
		$profile = Profile::whereSlug($participant)->first();
		switch ($action) {
			case 'rsvp':
				$participant = EventParticipant::where('event_id', $event->id)->where('profile_id', $profile->id)->first();
				if($participant->rsvp_status != 'RSVP'){
					$participant->rsvp_status = 'RSVP';
					$participant->save();

					//Create event activity log
					EventActivityLog::create(['event_id' => $event->id, 'action'=>'AttendeeStatus', 'participant_id' => $profile->id, 'user_id'=>Auth::user()->id, 'description'=>"changed <a href='/profiles/".$profile->slug."'>". $profile->fullname.' '.$profile->lastname."'s </a> status to RSVP"]);
				}
				
				break;
			case 'decline':
				$participant = EventParticipant::where('event_id', $event->id)->where('profile_id', $profile->id)->first();

				if ($participant->rsvp_status != 'DECLINE') {
					$participant->rsvp_status = 'DECLINE';
					$participant->save();

					//Create event activity log
					EventActivityLog::create(['event_id' => $event->id, 'action'=>'AttendeeStatus', 'participant_id' => $profile->id, 'user_id'=>Auth::user()->id, 'description'=>"changed <a href='/profiles/".$profile->slug."'>". $profile->fullname.' '.$profile->lastname."'s </a> status to decline"]);
				}
				

				break;
			
			case 'revoke':
				$participant = EventParticipant::where('event_id', $event->id)->where('profile_id', $profile->id)->first();
				if ($participant->rsvp_status != 'REVOKE') {
					$participant->rsvp_status = 'REVOKE';
					$participant->save();

					//Create event activity log
					EventActivityLog::create(['event_id' => $event->id, 'action'=>'AttendeeStatus', 'participant_id' => $profile->id, 'user_id'=>Auth::user()->id, 'description'=>"changed <a href='/profiles/".$profile->slug."'>". $profile->fullname.' '.$profile->lastname."'s </a> status to revoked"]);

				}
				
				break;

			case 'pending':
				$participant = EventParticipant::where('event_id', $event->id)->where('profile_id', $profile->id)->first();
				if ($participant->rsvp_status != 'PENDING') {
					$participant->rsvp_status = 'PENDING';
					$participant->save();
					

					//Create event activity log
					EventActivityLog::create(['event_id' => $event->id, 'action'=>'AttendeeStatus', 'participant_id' => $profile->id, 'user_id'=>Auth::user()->id, 'description'=>"changed <a href='/profiles/".$profile->slug."'>". $profile->fullname.' '.$profile->lastname."'s </a> status to pending"]);					
				}
				
				break;

			case 'delete':
				$participant = EventParticipant::where('event_id', $event->id)->where('profile_id', $profile->id)->delete();
				//Create event activity log
				EventActivityLog::create(['event_id' => $event->id, 'action'=>'AttendeeStatus', 'participant_id' => $profile->id, 'user_id'=>Auth::user()->id, 'description'=>"deleted <a href='/profiles/".$profile->slug."'>". $profile->fullname.' '.$profile->lastname."'s </a> invitation"]);

				break;
			default:
				# code...
				break;
		}
		return redirect()->route('events.show', ['slug' => $event->slug]);
	}

	function manage_other_attendees($slug, $action, $participant = null)
	{
		$event = Event::whereSlug($slug)->first();
		$other_participant = EventOrganization::find($participant);
		switch ($action) {
			case 'rsvp':
				if($other_participant->rsvp_status != 'RSVP'){
					$other_participant->rsvp_status = 'RSVP';
					$other_participant->save();

					//Create event activity log
					EventActivityLog::create(['event_id' => $event->id, 'action'=>'AttendeeStatus', 'participant_id' => $other_participant->id, 'user_id'=>Auth::user()->id, 'description'=>"changed ".$other_participant->name." status to RSVP"]);
				}
				
				break;
			case 'decline':
				if ($other_participant->rsvp_status != 'DECLINE') {
					$other_participant->rsvp_status = 'DECLINE';
					$other_participant->save();

					//Create event activity log
					EventActivityLog::create(['event_id' => $event->id, 'action'=>'AttendeeStatus', 'participant_id' => $other_participant->id, 'user_id'=>Auth::user()->id, 'description'=>"changed ".$other_participant->name." status to decline"]);
				}
				break;
			
			case 'revoke':
				if ($other_participant->rsvp_status != 'REVOKE') {
					$other_participant->rsvp_status = 'REVOKE';
					$other_participant->save();

					//Create event activity log
					EventActivityLog::create(['event_id' => $event->id, 'action'=>'AttendeeStatus', 'participant_id' => $other_participant->id, 'user_id'=>Auth::user()->id, 'description'=>"changed ".$other_participant->name." status to revoked"]);

				}
				
				break;

			case 'pending':
				if ($other_participant->rsvp_status != 'PENDING') {
					$other_participant->rsvp_status = 'PENDING';
					$other_participant->save();
					

					//Create event activity log
					EventActivityLog::create(['event_id' => $event->id, 'action'=>'AttendeeStatus', 'participant_id' => $other_participant->id, 'user_id'=>Auth::user()->id, 'description'=>"changed ".$other_participant->name." status to pending"]);				
				}
				
				break;

			case 'delete':
				EventOrganization::destroy($participant);
				//Create event activity log
				EventActivityLog::create(['event_id' => $event->id, 'action'=>'AttendeeStatus', 'participant_id' => $other_participant->id, 'user_id'=>Auth::user()->id, 'description'=>"deleted ".$other_participant->name." 's </a> invitation"]);

				break;
			default:
				# code...
				break;
		}
		return redirect()->route('events.show', ['slug' => $event->slug]);
	}


	public function invite_staff(Request $requests, $slug){
		$event = Event::whereSlug($slug)->first();
		$event_staff = new EventStaff;
		$event_staff->event_id = $event->id;
		$event_staff->user_id = $requests->staff_id;
		$event_staff->role_id = $requests->staff_role_id;
		$event_staff->save();

		return redirect()->route('events.show', ['slug' => $event->slug]);
	}

	public function remove_staff($id){
		EventStaff::destroy($id);
		return redirect()->back();
	}
}
