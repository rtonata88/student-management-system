<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Team;
use App\Language;
use App\Sector;

use Session;

class TeamsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$teams = Team::with(['sector', 'language'])->get();

		return view('setup.teams.index', compact('teams'));
	}

	public function show($id){
		$team =  Team::whereSlug($id)->first();
		$languages = Language::pluck('name', 'id');
		$sectors = Sector::pluck('name', 'id');
		return view('setup.teams.edit', compact('team', 'languages', 'sectors'));
	}

	public function create()
	{
		$languages = Language::pluck('name', 'id');
		$sectors = Sector::pluck('name', 'id');
		return view('setup.teams.create', compact('languages', 'sectors'));
	}

	public function edit($id)
	{
		$team = Team::whereSlug($id)->first();
		return view('setup.teams.edit', compact('team'));
	}

	public function store(Request $requests)
	{
		$this->validate($requests, [
            'name' => 'required|max:255|unique:teams',
       
        ]);
		$team = new Team;

		$team->language_id		= $requests->language_id;
		$team->name 			= $requests->name;
		$team->sector_id		= $requests->sector_id;
		$team->slug 			= str_slug($requests->name);
		$team->save();

		Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');
		return redirect('/teams');
	}

	public function update(Request $requests, $id)
	{
		$team =  Team::whereSlug($id)->first();

		$team->language_id		= $requests->language_id;
		$team->name 			= $requests->name;
		$team->sector_id		= $requests->sector_id;
		$team->slug 			= str_slug($requests->name);
		$team->save();

		Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');

		return redirect('/teams');
	}

}
