<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Duty;
use App\Language;

use Session;

class DutiesController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$duties = Duty::all();

		return view('setup.duties.index', compact('duties'));
	}

	public function show($id){
		$duty =  Duty::whereSlug($id)->first();
		$languages = Language::pluck('name', 'id');
		return view('setup.duties.edit', compact('duty', 'languages'));
	}

	public function create()
	{
		$languages = Language::pluck('name', 'id');
		return view('setup.duties.create', compact('duty', 'languages'));
	}

	public function edit($id)
	{
		$duty = Duty::whereSlug($id)->first();
		return view('setup.duties.edit', compact('duty'));
	}

	public function store(Request $requests)
	{
		$this->validate($requests, [
            'name' => 'required|max:255|unique:duties',
       
        ]);
		$duty = new Duty;

		$duty->language_id	= $requests->language_id;
		$duty->name 			= $requests->name;
		$duty->slug 			= str_slug($requests->name);
		$duty->save();

		Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');
		return redirect('/duties');
	}

	public function update(Request $requests, $id)
	{
		$duty =  Duty::find($id);

		$duty->language_id	= $requests->language_id;
		$duty->name 		= $requests->name;
		$duty->save();

		Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');

		return redirect('/duties');
	}
}
