<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use App\Maintainer;
use App\Profile;

use Session;

class MaintainerAssignmentController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(){
		$countries = Country::pluck('name', 'id');
		$maintainers = Maintainer::pluck('name', 'id');
		$profiles = Profile::selectRaw('id, CONCAT(fullname," ",lastname) AS name')
						   ->pluck('name', 'id');

		return view('profiles.maintainers.index', compact('countries', 'maintainers', 'profiles'));
	}

	public function store(Request $request){
		if(isset($request->countries)){
			Profile::whereIn('country_id', $request->countries)->update(['maintainer_id' => $request->maintainer_id]);
		}

		if(isset($request->profiles)){
			Profile::whereIn('id', $request->profiles)->update(['maintainer_id' => $request->maintainer_id]);	
		}

		Session::flash('message', 'Bulk operation completed successfully');

		return redirect()->back();
	}
}
