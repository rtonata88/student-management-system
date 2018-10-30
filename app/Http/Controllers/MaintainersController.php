<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Maintainer;
use App\Language;
use Session;

class MaintainersController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$maintainers = Maintainer::all();

		return view('setup.maintainers.index', compact('maintainers'));
	}

	public function show($id){
		$maintainer =  Maintainer::whereSlug($id)->first();
		$languages = Language::pluck('name', 'id');
		return view('setup.maintainers.edit', compact('maintainer', 'languages'));
	}

	public function create()
	{
		$languages = Language::pluck('name', 'id');
		return view('setup.maintainers.create', compact('languages'));
	}

	public function edit($id)
	{
		$maintainer = Maintainer::whereSlug($id)->first();
		return view('setup.maintainers.edit', compact('maintainer'));
	}

	public function store(Request $requests)
	{
		$this->validate($requests, [
            'name' => 'required|max:255|unique:maintainers',
       
        ]);
		$maintainer = new Maintainer;

		$maintainer->language_id	= $requests->language_id;
		$maintainer->name 			= $requests->name;
		$maintainer->slug 			= str_slug($requests->name);
		$maintainer->save();

		Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');
		return redirect('/maintainers');
	}

	public function update(Request $requests, $id)
	{
		$maintainer =  Maintainer::whereSlug($id)->first();

		$maintainer->language_id	= $requests->language_id;
		$maintainer->name 		= $requests->name;
		$maintainer->save();

		Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');

		return redirect('/maintainers');
	}
}
