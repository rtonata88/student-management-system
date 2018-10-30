<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FruitStage;
use App\Language;
use Session;


class FruitStagesController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$fruit_stages = FruitStage::all();

		return view('setup.fruit-stages.index', compact('fruit_stages'));
	}

	public function show($id){
		$fruit_stage =  FruitStage::whereSlug($id)->first();
		$languages = Language::pluck('name', 'id');
		return view('setup.fruit-stages.edit', compact('fruit_stage', 'languages'));
	}

	public function create()
	{
		$languages = Language::pluck('name', 'id');
		return view('setup.fruit-stages.create', compact('languages'));
	}

	public function edit($id)
	{
		$fruit_stage = FruitStage::whereSlug($id)->first();
		return view('setup.fruit-stages.edit', compact('fruit_stage'));
	}

	public function store(Request $requests)
	{
		$this->validate($requests, [
            'stage' => 'required|max:255|unique:fruit_stages',
       
        ]);
		$fruit_stage = new FruitStage;

		$fruit_stage->language_id	= $requests->language_id;
		$fruit_stage->stage 			= $requests->stage;
		$fruit_stage->slug 			= str_slug($requests->stage);
		$fruit_stage->save();

		Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');
		return redirect('/fruit-stages');
	}

	public function update(Request $requests, $id)
	{
		$fruit_stage =  FruitStage::find($id);

		$fruit_stage->language_id	= $requests->language_id;
		$fruit_stage->stage 		= $requests->stage;
		$fruit_stage->save();

		Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');

		return redirect('/fruit-stages');
	}
}
