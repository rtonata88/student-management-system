<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Title;
use App\Language;

use Session;

class TitlesController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$titles = Title::all();
		return view('setup.titles.index', compact('titles'));
	}

	public function show($id){
		$title = Title::whereSlug($id)->first();
		$languages = Language::pluck('name', 'id');
		return view('setup.titles.edit', compact('title', 'languages'));
	}

	public function create()
	{
		$languages = Language::pluck('name', 'id');
		return view('setup.titles.create', compact('languages'));
	}

	public function edit($id)
	{
		$title = Title::whereSlug($id)->first();
		return view('setup.titles.edit', compact('title'));
	}

	public function store(Request $requests)
	{
		$this->validate($requests, [
            'title' => 'required|max:255|unique:titles',
       
        ]);

		$title = new Title;

		$title->language_id	= $requests->language_id;
		$title->slug			= str_slug($requests->title);
		$title->title 			= $requests->title;
		$title->save();

		Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');
		return redirect('/titles');
	}

	public function update(Request $requests, $id)
	{
		$title =  Title::whereSlug($id)->first();
		$title->language_id	= $requests->language_id;
		$title->title 			= $requests->title;
		$title->save();

		Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');

		return redirect('/titles');
	}
}
