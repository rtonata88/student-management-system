<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Country;
use App\Language;

use Session;

class CitiesController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
    	$cities = City::all();
    	return view('setup.cities.index', compact('cities'));
    }

    public function create()
    {
    	$countries = Country::pluck('name', 'id');
    	$languages = Language::pluck('name', 'id');
    	return view('setup.cities.create', compact('countries', 'languages'));
    }

   	public function edit($slug)
   	{
   		$city = City::whereSlug($slug)->first();
   		return view('setup.city.edit', compact('city'));
   	}


   	public function store(Request $request)
   	{
      $this->validate($request, [
            'name' => 'required|max:255|unique:countries',
       
        ]);

   		$city 				     = new City;
   		$city->language_id = $request->language_id;
   		$city->country_id  = $request->country_id;
   		$city->name 		   = $request->name;
   		$city->save();

      Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');

   		return redirect('/cities');
   	}

    public function update(Request $requests, $id)
    {
      $this->validate($requests, [
            'name' => 'required|max:255|unique:countries',
       
        ]);
      $city              = City::find($id);
      $city->language_id = $request->language_id;
      $city->name        = $request->country_id;
      $city->name        = $request->name;
      $city->save();

      Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');
      return redirect('/activity-types');
    }
}
