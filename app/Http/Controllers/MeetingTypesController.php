<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MeetingType;
use App\Language;
use Session;

class MeetingTypesController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$meeting_types = MeetingType::all();

		return view('setup.meeting-types.index', compact('meeting_types'));
	}

	public function show($id){
		$meeting_type =  MeetingType::whereSlug($id)->first();
		$languages = Language::pluck('name', 'id');
		return view('setup.meeting-types.edit', compact('meeting_type', 'languages'));
	}

	public function create()
	{
		$languages = Language::pluck('name', 'id');
		return view('setup.meeting-types.create', compact('languages'));
	}

	public function edit($id)
	{
		$meeting_type = MeetingType::whereSlug($id)->first();
		return view('setup.meeting-types.edit', compact('meeting_type'));
	}

	public function store(Request $requests)
	{
		$this->validate($requests, [
            'type' => 'required|max:255|unique:meeting_types',
       
        ]);
		$meeting_type = new MeetingType;

		$meeting_type->language_id		= $requests->language_id;
		$meeting_type->type 			= $requests->type;
		$meeting_type->slug 			= str_slug($requests->type);
		$meeting_type->save();

		Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');
		return redirect('/meeting-types');
	}

	public function update(Request $requests, $id)
	{
		$meeting_type =  MeetingType::whereSlug($id)->first();

		$meeting_type->language_id		= $requests->language_id;
		$meeting_type->type 			= $requests->type;
		$meeting_type->slug 			= str_slug($requests->type);
		$meeting_type->save();

		Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');

		return redirect('/meeting-types');
	}
}
