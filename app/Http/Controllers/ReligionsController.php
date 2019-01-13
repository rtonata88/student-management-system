<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Religion;
use App\Language;
use Session;

class ReligionsController extends Controller
{
     public function __construct()
	{
		$this->middleware('auth');
	}


	public function index()
	{
		$religions = Religion::all();

		return view('setup.religions.index', compact('religions'));
	}

	public function show($id){
		$religion =  Religion::whereSlug($id)->first();
		$languages = Language::pluck('name', 'id');
		return view('setup.religions.edit', compact('religion', 'languages'));
	}

	public function create()
	{
		$languages = Language::pluck('name', 'id');
		return view('setup.religions.create', compact('languages'));
	}

	public function edit($id)
	{
		$religion = Religion::whereSlug($id)->first();
		return view('setup.religions.edit', compact('religion'));
	}

	public function store(Request $requests)
	{
		$this->validate($requests, [
            'name' => 'required|max:255|unique:religions',
       
        ]);
		$religion = new Religion;

		$religion->language_id		= $requests->language_id;
		$religion->name 			= $requests->name;
		$religion->slug 			= str_slug($requests->name);
		$religion->save();

		Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');
		return redirect('/religions');
	}

	public function update(Request $requests, $id)
	{
		$religion =  Religion::whereSlug($id)->first();

		$religion->language_id	= $requests->language_id;
		$religion->name 		= $requests->name;
		$religion->save();

		Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');

		return redirect('/religions');
	}
}
