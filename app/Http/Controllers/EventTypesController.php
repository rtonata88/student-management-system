<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\EventType;
use App\Language;
use Session;

class EventTypesController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$event_types = EventType::all();

		return view('setup.event-types.index', compact('event_types'));
	}

	public function show($id){
		$event_type =  EventType::whereSlug($id)->first();
		$languages = Language::pluck('name', 'id');
		return view('setup.event-types.edit', compact('event_type', 'languages'));
	}

	public function create()
	{
		$languages = Language::pluck('name', 'id');
		return view('setup.event-types.create', compact('languages'));
	}

	public function edit($id)
	{
		$event_type = EventType::whereSlug($id)->first();
		return view('setup.event-types.edit', compact('event_type'));
	}

	public function store(Request $requests)
	{
		$this->validate($requests, [
            'type' => 'required|max:255|unique:event_types',
       
        ]);
		$event_type = new EventType;

		$event_type->language_id	= $requests->language_id;
		$event_type->type 			= $requests->type;
		$event_type->slug 			= str_slug($requests->type);
		$event_type->save();

		Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');
		return redirect('/event-types');
	}

	public function update(Request $requests, $id)
	{
		$event_type =  EventType::find($id);

		$event_type->language_id	= $requests->language_id;
		$event_type->type 		= $requests->type;
		$event_type->save();

		Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');

		return redirect('/event-types');
	}
}
