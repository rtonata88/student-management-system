<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventGallery;
use App\Event;
use Session;
use Auth;
class EventGalleryController extends Controller
{
     public function __construct()
	{
		$this->middleware('auth');
	}

	public function store(Request $request, $slug){
		$event = Event::whereSlug($slug)->first();

		foreach ($request->path as $key => $value) {
			$gallery = new EventGallery;
			$path = $request->path[$key]->store('events/gallery/'.$event->id, 'public');
			$gallery->event_id = $event->id;
			$gallery->path = $path;
			$gallery->caption = $request->description[$key];
			$gallery->created_by = Auth::user()->id;
			$gallery->save();
		}

		Session::flash('message', 'Photos successfully uploaded');
		return redirect()->back();
	}
}
