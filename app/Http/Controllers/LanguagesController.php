<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Language;
use Session;

class LanguagesController extends Controller
{
     public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$languages = Language::all();

		return view('setup.languages.index', compact('languages'));
	}

	public function show($id){
		$language =  Language::where('short_name', $id)->first();
		return view('setup.languages.edit', compact('language'));
	}

	public function create()
	{
		$language = Language::pluck('name', 'id');
		return view('setup.languages.create', compact('languages'));
	}

	public function edit($id)
	{
		$language = Language::find($id);
		return view('setup.languages.edit', compact('language'));
	}

	public function store(Request $requests)
	{
		$this->validate($requests, [
            'name' => 'required|max:255|unique:languages',
            'short_name' => 'required|max:255|unique:languages',
       
        ]);
		$language = new Language;

		$language->name 			= $requests->name;
		$language->short_name 			= $requests->short_name;
		$language->save();

		Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');
		return redirect('/languages');
	}

	public function update(Request $requests, $id)
	{

		$language =  Language::where('short_name', $id)->first();

		$language->name 			= $requests->name;
		$language->short_name 		= $requests->short_name;
		$language->save();

		Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');

		return redirect('/languages');
	}
}
