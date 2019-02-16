<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campaign;
use App\CampaignReport;
use App\City;
use Session;
use Auth;

class CampaignsController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaign::all();

        return view('campaigns.index',compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Campaign::create($request->all());
        Session::flash('message', 'The record has been added, please confirm that the changes have taken effect in the table below.');
        return redirect('/campaigns');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $campaign = Campaign::find($id);
        return view('campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = request()->except(['_method','_token']);
        Campaign::where('id', $id)->update($data);
        Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');

        return redirect('/campaigns');
    }

    public function report_index($id){
        $cities = City::pluck('name', 'id');
        $campaign = Campaign::find($id);
        return view('campaigns.report.index', compact('cities', 'campaign'));
    }

    public function report(Request $request, $id)
    {
        $report = new CampaignReport;
        $report->campaign_id = $id;
        $report->reported_by = Auth::user()->id;
        $report->report_date = $request->report_date;
        $report->number_of_collections = $request->number_of_collections;
        $report->city_id = $request->city_id;
        $report->save();

        Session::flash('message', $report->number_of_collections.' number of collections added to this campaign. Keep it going. You have done well, but this is not your peek, you can still do better.');

        return redirect('/campaigns');
    }
}
