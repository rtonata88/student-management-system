<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;
use App\Language;
use Session;

class CountriesController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$countries = Country::all();

		return view('setup.countries.index', compact('countries'));
	}

	public function show($id){
		$country = Country::whereSlug($id)->first();
		$languages = Language::pluck('name', 'id');
		return view('setup.countries.edit', compact('country', 'languages'));
	}

	public function create()
	{
		$languages = Language::pluck('name', 'id');
		return view('setup.countries.create', compact('languages'));
	}

	public function edit($id)
	{
		$country = Country::whereSlug($id)->first();
		return view('setup.countries.edit', compact('country'));
	}

	public function store(Request $requests)
	{
		$this->validate($requests, [
            'name' => 'required|max:255|unique:countries',
       
        ]);

		$country = new Country;

		$country->language_id	= $requests->language_id;
		$country->slug			= str_slug($requests->name);
		$country->name 			= $requests->name;
		$country->save();

		Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');
		return redirect('/countries');
	}

	public function update(Request $requests, $id)
	{
		$country =  Country::find($id);

		$country->language_id	= $requests->language_id;
		$country->name 			= $requests->name;
		$country->save();

		Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');

		return redirect('/countries');
	}
}
