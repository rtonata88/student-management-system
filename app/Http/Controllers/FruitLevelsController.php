<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Language;
use App\FruitLevel;
use Session;

class FruitLevelsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$fruit_levels = FruitLevel::all();

		return view('setup.fruit-levels.index', compact('fruit_levels'));
	}

	public function show($id){
		$fruit_level =  FruitLevel::whereSlug($id)->first();
		$languages = Language::pluck('name', 'id');
		return view('setup.fruit-levels.edit', compact('fruit_level', 'languages'));
	}

	public function create()
	{
		$languages = Language::pluck('name', 'id');
		return view('setup.fruit-levels.create', compact('languages'));
	}

	public function edit($id)
	{
		$fruit_level = FruitLevel::whereSlug($id)->first();
		return view('setup.fruit-levels.edit', compact('fruit_level'));
	}

	public function store(Request $requests)
	{
		$this->validate($requests, [
            'level' => 'required|max:255|unique:fruit_levels',
       
        ]);
		$fruit_level = new FruitLevel;

		$fruit_level->language_id	= $requests->language_id;
		$fruit_level->level 			= $requests->level;
		$fruit_level->slug 			= str_slug($requests->level);
		$fruit_level->save();

		Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');
		return redirect('/fruit-levels');
	}

	public function update(Request $requests, $id)
	{
		$fruit_level =  FruitLevel::find($id);

		$fruit_level->language_id	= $requests->language_id;
		$fruit_level->level 		= $requests->level;
		$fruit_level->save();

		Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');

		return redirect('/fruit-levels');
	}
}
