<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Profile;
use App\WarpSummitAttendee;

use Session;
use Auth;

class WarpSummitAttendeesController extends Controller
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
        $attendees = WarpSummitAttendee::with('profile')->get();

        $attendees_per_year = WarpSummitAttendee::getWarpSummitAttendeesPerYear();
        $line_graph_data = array();
        array_push($line_graph_data, array('Year', 'Attendee(s)'));
        foreach ($attendees_per_year as $year => $occurence) {
            array_push($line_graph_data, array("$year", $occurence->count()));
        }
        $line_graph_data = json_encode($line_graph_data);

        return view('profiles.warp.index', compact('attendees', 'line_graph_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $profiles = Profile::selectRaw('id, CONCAT(fullname," ",lastname) AS name')
                       ->pluck('name', 'id');
        return view('profiles.warp.create', compact('profiles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        WarpSummitAttendee::create($request->all());
        Profile::where('id', $request->profile_id)->update(['warp_attendee'=>'Yes']);
        Session::flash('message', 'The record has been added, and the fruit profile has been updated accordingly.');
        return redirect('/warp-attendees');

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
        $attendee = WarpSummitAttendee::find($id);
        $profiles = Profile::selectRaw('id, CONCAT(fullname," ",lastname) AS name')
                       ->pluck('name', 'id');
        return view('profiles.warp.edit', compact('attendee', 'profiles'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $attendee = WarpSummitAttendee::find($id);
      Profile::where('id', $attendee->profile_id)->update(['warp_attendee'=>'No']);
      $attendee->delete();
      Session::flash('message', 'The record has been deleted and the Fruit Profile has been updated accordingly.');
      return redirect()->back();
    }
}
