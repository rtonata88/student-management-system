<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ReportType;
use App\Language;

use Session;

class ReportTypesController extends Controller
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
    	$report_types = ReportType::all();
    	return view('setup.report-types.index', compact('report_types'));
    }

    public function create()
    {
    	$languages = Language::pluck('name', 'id');
    	return view('setup.report-types.create', compact('languages'));
    }

    public function show($id){
		$report_type =  ReportType::find($id);
		$languages = Language::pluck('name', 'id');
		return view('setup.report-types.edit', compact('report_type', 'languages'));
	}

   	public function edit($slug)
   	{
   		$report_type = ReportType::find($slug);
   		return view('setup.report-types.edit', compact('report_type'));
   	}


   	public function store(Request $request)
   	{
      $this->validate($request, [
            'name' => 'required|max:255|unique:report_types',
       
        ]);

   		$report_type 				= new ReportType;
   		$report_type->language_id 	= $request->language_id;
   		$report_type->name  		= $request->name;
   		$report_type->save();

      Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');

   		return redirect('/report-types');
   	}

    public function update(Request $requests, $id)
    {
      $this->validate($requests, [
            'name' => 'required|max:255|unique:report_types',
       
        ]);
      	$report_type              	= ReportType::find($id);
     	$report_type->language_id 	= $requests->language_id;
   		$report_type->name  		= $requests->name;
   		$report_type->save();

      Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');
      return redirect('/report-types');
    }
}
