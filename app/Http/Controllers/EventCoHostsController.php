<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventCoHost;
use App\Event;
use App\EventCoHostContact;

class EventCoHostsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function create($slug){
		$event = Event::whereSlug($slug)->first();
		return view('events.co-hosts.create', compact('event'));
	}

	public function view($id){
		$co_host = EventCoHost::find($id);

		return view('events.co-hosts.view', compact('co_host'));
	}


	public function edit($id){
		$co_host = EventCoHost::find($id);

		return view('events.co-hosts.edit', compact('co_host'));
	}

	public function delete($id){
		EventCoHost::destroy($id);
		return redirect()->back();
	}

	public function store(Request $requests, $slug){

		$event = Event::whereSlug($slug)->first();

		if ($requests->hasFile('logo')) {
		    $logo = $requests->logo->store('events/co-hosts/'.$event->id, 'public');
		}


		$co_host = new EventCoHost;
		$co_host->name = $requests->name;
		$co_host->event_id = $event->id;
		$co_host->address_line1 = $requests->address_line1;
		$co_host->address_line2 = $requests->address_line2;
		$co_host->address_line3 = $requests->address_line3;
		$co_host->address_line4 = $requests->address_line4;
		$co_host->logo = $logo;
		$co_host->save();

		for ($i=0; $i<count($requests->contact_person); $i++) {
			EventCoHostContact::create(['event_co_host_id' => $co_host->id, 
								 'contact_person' => $requests->contact_person[$i],
								 'contact_number' => $requests->contact_number[$i],
							     'contact_email' => $requests->contact_email[$i]
							 	]);
		}

		return redirect('/events/'.$slug);
	}
	public function update(Request $requests, $id){
		$co_host = EventCoHost::find($id);

		if ($requests->hasFile('logo')) {
		    $logo = $requests->logo->store('events/co-hosts/'.$co_host->event->id, 'public');
		    $co_host->logo = $logo;
		}


		
		$co_host->name = $requests->name;
		$co_host->event_id = $co_host->event->id;
		$co_host->address_line1 = $requests->address_line1;
		$co_host->address_line2 = $requests->address_line2;
		$co_host->address_line3 = $requests->address_line3;
		$co_host->address_line4 = $requests->address_line4;
		
		$co_host->save();

		$co_host->contacts()->delete();

		for ($i=0; $i<count($requests->contact_person); $i++) {
			EventCoHostContact::create(['event_co_host_id' => $co_host->id, 
								 'contact_person' => $requests->contact_person[$i],
								 'contact_number' => $requests->contact_number[$i],
							     'contact_email' => $requests->contact_email[$i]
							 	]);
		}

		return redirect('/events/'.$co_host->event->slug);
	}
}
