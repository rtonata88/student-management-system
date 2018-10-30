<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Industry;
use App\Language;
use Session;

class IndustriesController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$industries = Industry::all();

		return view('setup.industries.index', compact('industries'));
	}

	public function show($id){
		$industry =  Industry::whereSlug($id)->first();
		$languages = Language::pluck('name', 'id');
		return view('setup.industries.edit', compact('industry', 'languages'));
	}

	public function create()
	{
		$languages = Language::pluck('name', 'id');
		return view('setup.industries.create', compact('languages'));
	}

	public function edit($id)
	{
		$industry = Industry::whereSlug($slug)->first();
		return view('setup.industries.edit', compact('industry'));
	}

	public function store(Request $requests)
	{
		$this->validate($requests, [
            'name' => 'required|max:255|unique:industries',
       
        ]);
		$industry = new Industry;

		$industry->language_id		= $requests->language_id;
		$industry->name 			= $requests->name;
		$industry->slug 			= str_slug($requests->name);
		$industry->save();

		Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');
		return redirect('/industries');
	}

	public function update(Request $requests, $id)
	{
		$industry =  Industry::whereSlug($id)->first();

		$industry->language_id		= $requests->language_id;
		$industry->name 			= $requests->name;
		$industry->slug 			= str_slug($requests->name);
		$industry->save();

		Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');

		return redirect('/industries');
	}
}
