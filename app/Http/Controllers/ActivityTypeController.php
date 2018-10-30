<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ActivityType;
use App\Language;
use Session;

class ActivityTypeController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$activity_types = ActivityType::all();

		return view('setup.activity-types.index', compact('activity_types'));
	}

	public function show($id){
		$activity_type =  ActivityType::find($id);
		$languages = Language::pluck('name', 'id');
		return view('setup.activity-types.edit', compact('activity_type', 'languages'));
	}

	public function create()
	{
		$languages = Language::pluck('name', 'id');
		return view('setup.activity-types.create', compact('activity_type', 'languages'));
	}

	public function edit($id)
	{
		$activity_type = ActivityType::find($id);
		return view('setup.activity-types.edit', compact('activity_type'));
	}

	public function store(Request $requests)
	{
		$activity_type = new ActivityType;

		$activity_type->language_id	= $requests->language_id;
		$activity_type->name 		= $requests->name;
		$activity_type->save();

		Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');
		return redirect('/activity-types');
	}

	public function update(Request $requests, $id)
	{
		$activity_type =  ActivityType::find($id);

		$activity_type->language_id	= $requests->language_id;
		$activity_type->name 		= $requests->name;
		$activity_type->save();

		Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');

		return redirect('/activity-types');
	}
}
