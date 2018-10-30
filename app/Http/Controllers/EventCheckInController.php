<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Profile;
use App\EventCheckIn;

use Auth;
use Session;

class EventCheckInController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(){
		$events = Event::all();
		return view('events.check-in.index', compact('events'));
	}

	public function create($slug){
		$event = Event::whereSlug($slug)->first();
		//dd(array_flatten($event->participants->pluck('profile_id')));
		$guests = Profile::selectRaw('id, CONCAT(fullname," ",lastname) AS name')
							->whereIn('id', $event->participants->pluck('profile_id'))
							->whereNotIn('id', $event->check_ins->pluck('profile_id'))
						 	->pluck('name', 'id');

		return view('events.check-in.create', compact('guests', 'event'));
	}


	public function get_guest(Request $request){
		$profile = Profile::get_guest($request->guest);

		return $profile;
	}

	public function store(Request $request, $slug){

		$event = Event::whereSlug($slug)->first();

		$check_in = new EventCheckIn;

		$check_in->event_id = $event->id;
		$check_in->profile_id = $request->profile_id;
		$check_in->fullname = $request->fullname;
		$check_in->lastname = $request->lastname;
		$check_in->email = $request->email;
		$check_in->mobile_no = $request->mobile_no;
		$check_in->work_number = $request->work_number;
		$check_in->checked_in_by = Auth::user()->id;
		$check_in->save();

		Session::flash('message', $request->fullname.' '.$request->lastname.' successfully checked in.');

		return redirect()->back();

	}
}
