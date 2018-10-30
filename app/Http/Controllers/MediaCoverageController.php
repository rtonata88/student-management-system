<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MediaCoverage;
use App\Country;
use App\City;
use App\Event;
use App\Profile;
use App\MediaCoveragePhoto;

use Session;


class MediaCoverageController extends Controller
{
     public function __construct()
	{
		$this->middleware('auth');
	}

	public function index($profileSlug)
	{
		$profile = Profile::whereSlug($profileSlug)->first();
		$media_coverages = MediaCoverage::where('profile_id', $profile->id)->get();

		return view('media-coverage.index', compact('media_coverages', 'profile'));
	}


	public function create($profileSlug)
	{
		$countries = Country::pluck('name', 'id');
		$cities = City::pluck('name', 'id');
		$events = Event::pluck('name', 'id');	

		$profile = Profile::whereSlug($profileSlug)->first();

		return view('media-coverage.create', compact('countries', 'cities', 'events', 'profile'));
	}

	public function edit($id)
	{
		$media_coverage = MediaCoverage::find($id);
		$countries = Country::pluck('name', 'id');
		$cities = City::pluck('name', 'id');
		$events = Event::pluck('name', 'id');	

		$profile = Profile::find($media_coverage->profile_id)->first();

		return view('media-coverage.edit', compact('countries', 'cities', 'events', 'profile', 'media_coverage'));
	}

	public function store(Request $requests){
		$coverage = new MediaCoverage;

		$coverage->media_house = $requests->media_house;
		$coverage->profile_id = $requests->profile_id;
		$coverage->when = $requests->when;
		$coverage->event_id = $requests->event_id;
		$coverage->country_id = $requests->country_id;
		$coverage->city_id = $requests->city_id;
		$coverage->title = $requests->title;
		$coverage->platform = $requests->platform;
		$coverage->short_summary = $requests->short_summary;
		$coverage->url = $requests->url;
		$coverage->location = $requests->location;
		$coverage->save();

		$profile = Profile::find($requests->profile_id);

		// COVERAGE PHOTOS
		if(isset($requests->photos)){
			foreach ($requests->photos as $key => $photo) {
				if (!is_null($photo)) {	
					$photo = $photo->store('coverage-photos/'.$profile->slug.'/'.$coverage->id, 'public');
					$coverage_photo = new MediaCoveragePhoto;
					$coverage_photo->media_coverage_id = $coverage->id;
					$coverage_photo->path = $photo;
					$coverage_photo->caption = $requests->caption[$key];
					$coverage_photo->save();
				}
			}
			
		}

		
		Session::flash('message', 'Media Coverage successfully recorded. If you would like to make changes, please edit and save again. If you are happy, click <strong><a href="/profiles/'.$profile->slug.'" >go to profile</a></strong>');

		return redirect('/media-coverage/'.$coverage->id.'/edit');
	}

	public function update(Request $requests, $id){
		$coverage =  MediaCoverage::find($id);

		$coverage->media_house = $requests->media_house;
		$coverage->profile_id = $requests->profile_id;
		$coverage->when = $requests->when;
		$coverage->event_id = $requests->event_id;
		$coverage->country_id = $requests->country_id;
		$coverage->city_id = $requests->city_id;
		$coverage->title = $requests->title;
		$coverage->platform = $requests->platform;
		$coverage->short_summary = $requests->short_summary;
		$coverage->url = $requests->url;
		$coverage->location = $requests->location;
		$coverage->save();

		$profile = Profile::find($requests->profile_id);

		// COVERAGE PHOTOS
		if(isset($requests->photos)){
			foreach ($requests->photos as $key => $photo) {
				if (!is_null($photo)) {	
					$photo = $photo->store('coverage-photos/'.$profile->slug.'/'.$coverage->id, 'public');
					$coverage_photo = new MediaCoveragePhoto;
					$coverage_photo->media_coverage_id = $coverage->id;
					$coverage_photo->path = $photo;
					$coverage_photo->caption = $requests->caption[$key];
					$coverage_photo->save();
				}
			}
			
		}

		
		Session::flash('message', 'Media Coverage successfully recorded. If you would like to make changes, please edit and save again. If you are happy, click <strong><a href="/profiles/'.$profile->slug.'" >go to profile</a></strong>');

		return redirect('/media-coverage/'.$coverage->id.'/edit');
	}
}
