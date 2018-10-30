<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\FruitRole;
use App\Language;
use Session;

class FruitRolesController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$fruit_roles = FruitRole::all();

		return view('setup.fruit-roles.index', compact('fruit_roles'));
	}

	public function show($id){
		$fruit_role =  FruitRole::whereSlug($id)->first();
		$languages = Language::pluck('name', 'id');
		return view('setup.fruit-roles.edit', compact('fruit_role', 'languages'));
	}

	public function create()
	{
		$languages = Language::pluck('name', 'id');
		return view('setup.fruit-roles.create', compact('languages'));
	}

	public function edit($id)
	{
		$fruit_role = FruitRole::whereSlug($id)->first();
		return view('setup.fruit-roles.edit', compact('fruit_role'));
	}

	public function store(Request $requests)
	{
		$this->validate($requests, [
            'role' => 'required|max:255|unique:fruit_roles',
       
        ]);
		$fruit_role = new FruitRole;

		$fruit_role->language_id	= $requests->language_id;
		$fruit_role->role 			= $requests->role;
		$fruit_role->slug 			= str_slug($requests->role);
		$fruit_role->save();

		Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');
		return redirect('/fruit-roles');
	}

	public function update(Request $requests, $id)
	{
		$fruit_role =  FruitRole::find($id);

		$fruit_role->language_id	= $requests->language_id;
		$fruit_role->role 		= $requests->role;
		$fruit_role->save();

		Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');

		return redirect('/fruit-roles');
	}
}
