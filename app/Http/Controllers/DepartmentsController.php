<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Department;
use App\Language;
use Session;

class DepartmentsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$departments = Department::all();

		return view('setup.departments.index', compact('departments'));
	}

	public function show($id){
		$department =  Department::find($id);
		$languages = Language::pluck('name', 'id');
		return view('setup.departments.edit', compact('department', 'languages'));
	}

	public function create()
	{
		$languages = Language::pluck('name', 'id');
		return view('setup.departments.create', compact('department', 'languages'));
	}

	public function edit($id)
	{
		$department = Department::find($id);
		return view('setup.departments.edit', compact('department'));
	}

	public function store(Request $requests)
	{
		$department = new Department;

		$department->language_id	= $requests->language_id;
		$department->name 			= $requests->name;
		$department->slug 			= str_slug($requests->name);
		$department->save();

		Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');
		return redirect('/departments');
	}

	public function update(Request $requests, $id)
	{
		$department =  Department::find($id);

		$department->language_id	= $requests->language_id;
		$department->name 		= $requests->name;
		$department->save();

		Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');

		return redirect('/departments');
	}
}
