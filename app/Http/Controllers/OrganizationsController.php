<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organization;
use App\Language;
use App\Sector;
use App\Industry;
use App\Country;

use Session;

class OrganizationsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(Request $requests)
	{
		if(isset($requests->name)){
			$organizations = Organization::where('name', 'like', '%'.$requests->name.'%')->paginate(50);
		} else {
			$organizations = Organization::paginate(50);
		}
		

		return view('setup.organizations.index', compact('organizations'));
	}

	public function show($id){
		$organization =  Organization::whereSlug($id)->first();
		$languages = Language::pluck('name', 'id');
		$industries = Industry::pluck('name', 'id');
		$sectors = Sector::pluck('name', 'id');
		$countries = Country::pluck('name', 'id');
		return view('setup.organizations.edit', compact('organization', 'languages', 'industries', 'sectors', 'countries'));
	}

	public function create()
	{
		$languages = Language::pluck('name', 'id');
		$industries = Industry::pluck('name', 'id');
		$sectors = Sector::pluck('name', 'id');
		$countries = Country::pluck('name', 'id');
		return view('setup.organizations.create', compact('languages', 'industries', 'sectors', 'countries'));
	}

	public function edit($id)
	{
		$meeting_type = Organization::whereSlug($id)->first();
		return view('setup.organizations.edit', compact('meeting_type'));
	}

	public function store(Request $requests)
	{
		$this->validate($requests, [
            'name' => 'required|max:255|unique:organizations',
       
        ]);
		$organization = new Organization;

		$organization->language_id		= $requests->language_id;
		$organization->name 			= $requests->name;
		$organization->acronym			= $requests->acronym;
		$organization->website			= $requests->website;
		$organization->industry_id		= $requests->industry_id;
		$organization->sector_id		= $requests->sector_id;
		$organization->country_id		= $requests->country_id;
		$organization->slug 			= str_slug($requests->name);
		$organization->save();

		Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');
		return redirect('/organizations');
	}

	public function update(Request $requests, $id)
	{
		$organization =  Organization::whereSlug($id)->first();

		$organization->language_id		= $requests->language_id;
		$organization->name 			= $requests->name;
		$organization->acronym			= $requests->acronym;
		$organization->website			= $requests->website;
		$organization->industry_id		= $requests->industry_id;
		$organization->sector_id		= $requests->sector_id;
		$organization->country_id		= $requests->country_id;
		$organization->slug 			= str_slug($requests->name);
		$organization->save();

		Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');

		return redirect('/organizations');
	}
}
