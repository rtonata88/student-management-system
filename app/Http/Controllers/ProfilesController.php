<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Profile;
use App\Language;
use App\Country;
use App\City;
use App\Title;
use App\Sector;
use App\Gender;
use App\Organization;
use App\FruitRole;
use App\SectorRelationship;
use App\FruitLevel;
use App\FruitStage;
use App\Maintainer;
use App\Team;
use App\ProfileDocument;
use App\ProfileAssistant;
use App\OrganizationProfile;
use App\Religion;
use Auth;
use Freshbitsweb\Laratables\Laratables;

use Session;
use Image;

class ProfilesController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$user = Auth::user();
		if($user->hasRole('department leader')){
			$profiles = Profile::with(['sector', 'language', 'country', 'city', 'organization'])->paginate(50);
		} else {
			$profiles = Profile::where('team_id', $user->team_id)->with(['sector', 'language', 'country', 'city', 'organization'])->paginate(50);
		}
	

		return view('profiles.index', compact('profiles'));
	}
	/**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function getSimpleDatatablesData()
    {
        return Laratables::recordsOf(Profile::class, 
        		function($query){
        			$user = Auth::user();
        			if($user->hasRole('department leader')){
        				return $query;
        			} else {
        				return $query->where('team_id', $user->team_id);
        			}

        		});
    }
    /**
     * return data of the Custom columns datatables.
     *
     * @return Json
     */
    public function getCustomColumnDatatablesData()
    {
        return Laratables::recordsOf(Profile::class);
    }

    /**
     * return data of the Extra data datatables attribute data.
     *
     * @return Json
     */
    public function getExtraDataDatatablesAttributesData()
    {
        return Laratables::recordsOf(Profile::class);
    }


	public function create()
	{
		$languages = Language::pluck('name', 'id');
		$sectors = Sector::pluck('name', 'id');
		$countries = Country::pluck('name', 'id');
		$titles = Title::pluck('title', 'id');
		$gender = Gender::pluck('gender', 'id');
		$organizations = Organization::pluck('name', 'id');
		$cities = City::pluck('name', 'id');
		$fruit_roles = FruitRole::pluck('role', 'id');
		$teams = Team::pluck('name', 'id');
		$fruit_levels = FruitLevel::pluck('level', 'id');
		$fruit_stages = FruitStage::pluck('stage', 'id');
		$maintainers = Maintainer::pluck('name', 'id');
		$religions = Religion::pluck('name', 'id');
		$sector_relationships = SectorRelationship::pluck('relationship', 'id');

		return view('profiles.create', compact('languages', 'sectors', 'countries', 'titles', 'gender', 'organizations', 'cities', 'fruit_roles', 'teams', 'fruit_levels', 'fruit_stages', 'maintainers', 'sector_relationships', 'religions', 'languages'));
	}

	public function show($slug){
		$profile = Profile::whereSlug($slug)->first();

		$organizations = $profile->organization_profile;
		$assistants = $profile->profile_assistant;
		return view('profiles.show', compact('profile', 'organizations', 'assistants'));
	}

	public function upload_document(Request $requests){
		//dd($requests->document);
		$profile = Profile::where('slug', $requests->profile)->first();
		$document = new ProfileDocument;

		$document->profile_id = $profile->id;
		$document->description = $requests->description;
		$document->uploaded_by = Auth::user()->id;
		$document->document_path = $requests->file('document')->store('profile-documents/'.$profile->slug);
		$document->save();

		return redirect()->back();
	}

	public function download_document($id){
		$document = ProfileDocument::find($id);
		$profile = Profile::find($document->profile_id);

		return response()->download(storage_path('app').'/'.$document->document_path, $profile->fullname."_".$profile->lastname."_".$document->description);
	}

	public function delete_document($id){
		$document = ProfileDocument::find($id);
		if(file_exists(storage_path('app').'/'.$document->document_path)){
			unlink(storage_path('app').'/'.$document->document_path);
		}
		$document->delete();

		return redirect()->back();

	}
	
	public function edit($slug)
	{
		$languages = Language::pluck('name', 'id');
		$sectors = Sector::pluck('name', 'id');
		$countries = Country::pluck('name', 'id');
		$titles = Title::pluck('title', 'id');
		$gender = Gender::pluck('gender', 'id');
		$organizations = Organization::pluck('name', 'id');
		$cities = City::pluck('name', 'id');
		$fruit_roles = FruitRole::pluck('role', 'id');
		$teams = Team::pluck('name', 'id');
		$fruit_levels = FruitLevel::pluck('level', 'id');
		$fruit_stages = FruitStage::pluck('stage', 'id');
		$maintainers = Maintainer::pluck('name', 'id');
		$sector_relationships = SectorRelationship::pluck('relationship', 'id');
		$religions = Religion::pluck('name', 'id');

		$profile = Profile::whereSlug($slug)->first();

		$profile_organizations = $profile->organization_profile;
		$assistants = $profile->profile_assistant;


		return view('profiles.edit', compact('profile','languages', 'sectors', 'countries', 'titles', 'gender', 'organizations', 'cities', 'fruit_roles', 'teams', 'fruit_levels', 'fruit_stages', 'maintainers', 'sector_relationships', 'profile_organizations', 'assistants', 'religions'));
	}

	public function store(Request $requests)
	{
		$profile_photo = "";
		if ($requests->hasFile('photo')) {
			$original_photo		= $requests->file('photo');
			$thumbnail_photo 	= Image::make($original_photo);
			$thumbnail_path 	= public_path().'/fruit_profiles/thumbnail/';
			$original_path 		= public_path().'/fruit_profiles/photos/';

			$thumbnail_photo->save($original_path.time()."_".$original_photo->getClientOriginalName());
			$thumbnail_photo->resize(150,150);
			$thumbnail_photo->save($thumbnail_path.time()."_".$original_photo->getClientOriginalName()); 
			$profile_photo = time()."_".$original_photo->getClientOriginalName();
		}
		


		$profile = new Profile;

		$profile->fullname 					= $requests->fullname;
		$profile->lastname 					= $requests->lastname;
		$profile->dob 						= $requests->dob;
		$profile->slug						= str_slug($requests->fullname." ".$requests->lastname);
		$profile->gender_id 				= $requests->gender_id;
		$profile->bio 						= $requests->bio;
		$profile->photo 					= $profile_photo;
		$profile->sector_id 				= $requests->sector_id;
		$profile->country_id 				= $requests->country_id;
		$profile->city_id 					= $requests->city_id;
		$profile->date_networked 			= $requests->date_networked;
		$profile->fruit_level_id 			= $requests->fruit_level_id;
		$profile->fruit_stage_id 			= $requests->fruit_stage_id;
		$profile->maintainer_id 			= $requests->maintainer_id;
		$profile->fruit_role_id 			= $requests->fruit_role_id;
		$profile->religion_id 				= $requests->religion_id;
		$profile->history 					= $requests->history;
		$profile->pre_poisoned 				= $requests->pre_poisoned;
		$profile->cult_awareness 			= $requests->cult_awareness;
		$profile->warp_attendee 			= $requests->warp_attendee;
		$profile->team_id					= $requests->team_id;

		$profile->save();
		

		$profile->title()->sync($requests->titles);
		$profile->language()->sync($requests->languages);

		foreach ($requests->organization as $key1 => $organization) {
			if($organization){
				$organization_profile = new OrganizationProfile;
				$organization_profile->profile_id 		= $profile->id;
				$organization_profile->organization_id 	= $organization;
				$organization_profile->position 		= $requests->position[$key1];
				$organization_profile->work_number 		= $requests->work_number[$key1];
				$organization_profile->work_number2 	= $requests->work_number2[$key1];
				$organization_profile->work_number_other = $requests->work_number_other[$key1];
				$organization_profile->email 			= $requests->email[$key1];
				$organization_profile->email2 			= $requests->email2[$key1];
				$organization_profile->email_other 		= $requests->email_other[$key1];
				$organization_profile->save();
			}
		}

		foreach ($requests->assistant_name as $key2 => $assistant) {
			if($assistant){
				$assistant_profile = new ProfileAssistant;
				$assistant_profile->profile_id = $profile->id;
				$assistant_profile->assistant_name = $assistant;
				$assistant_profile->assistant_email1 = $requests->assistant_email1[$key2];
				$assistant_profile->assistant_email2 = $requests->assistant_email2[$key2];
				$assistant_profile->assistant_email3 = $requests->assistant_email3[$key2];
				$assistant_profile->assistant_number1 = $requests->assistant_number1[$key2];
				$assistant_profile->assistant_number2 = $requests->assistant_number2[$key2];
				$assistant_profile->assistant_number3 = $requests->assistant_number3[$key2];
				$assistant_profile->save();
			}
		}

		Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');
		return redirect('/profiles/'.$profile->slug);
	}

	public function update(Request $requests, $slug)
	{
		$profile =  Profile::whereSlug($slug)->first();
		$profile_photo = "";
		if ($requests->hasFile('photo')) {

			if($profile->photo !== '')
			{
				if(file_exists(public_path()."/fruit_profiles/thumbnail/".$profile->photo))
				{
					unlink(public_path()."/fruit_profiles/thumbnail/".$profile->photo);
				}

				if(file_exists(public_path()."/fruit_profiles/photos/".$profile->photo))
				{
					unlink(public_path()."/fruit_profiles/photos/".$profile->photo);
				}
			}
			
			$original_photo		= $requests->file('photo');
			$thumbnail_photo 	= Image::make($original_photo);
			$thumbnail_path 	= public_path().'/fruit_profiles/thumbnail/';
			$original_path 		= public_path().'/fruit_profiles/photos/';

			$thumbnail_photo->save($original_path.time()."_".$original_photo->getClientOriginalName());
			$thumbnail_photo->resize(150,150);
			$thumbnail_photo->save($thumbnail_path.time()."_".$original_photo->getClientOriginalName());
			$profile_photo = time()."_".$original_photo->getClientOriginalName();    
			$profile->photo = $profile_photo;
		}
		$profile->fullname 					= $requests->fullname;
		$profile->lastname 					= $requests->lastname;
		$profile->dob 						= $requests->dob;
		//$profile->slug						= str_slug($requests->fullname." ".$requests->lastname);
		$profile->gender_id 				= $requests->gender_id;
		$profile->bio 						= $requests->bio;
		$profile->sector_id 				= $requests->sector_id;
		$profile->country_id 				= $requests->country_id;
		$profile->city_id 					= $requests->city_id;
		$profile->date_networked 			= $requests->date_networked;
		$profile->fruit_level_id 			= $requests->fruit_level_id;
		$profile->fruit_stage_id 			= $requests->fruit_stage_id;
		$profile->maintainer_id 			= $requests->maintainer_id;
		$profile->fruit_role_id 			= $requests->fruit_role_id;
		$profile->religion_id 				= $requests->religion_id;
		$profile->history 					= $requests->history;
		$profile->pre_poisoned 				= $requests->pre_poisoned;
		$profile->cult_awareness 			= $requests->cult_awareness;
		$profile->warp_attendee 			= $requests->warp_attendee;
		$profile->team_id					= $requests->team_id;

		$profile->save();

		$profile->title()->sync($requests->titles);
		$profile->language()->sync($requests->languages);

		foreach ($requests->organization as $key1 => $organization) {
			if($organization){
				$organization_profile = new OrganizationProfile;
				$organization_profile->profile_id 		= $profile->id;
				$organization_profile->organization_id 	= $organization;
				$organization_profile->position 		= $requests->position[$key1];
				$organization_profile->work_number 		= $requests->work_number[$key1];
				$organization_profile->work_number2 	= $requests->work_number2[$key1];
				$organization_profile->work_number_other = $requests->work_number_other[$key1];
				$organization_profile->email 			= $requests->email[$key1];
				$organization_profile->email2 			= $requests->email2[$key1];
				$organization_profile->email_other 		= $requests->email_other[$key1];
				$organization_profile->save();
			}
		}

		foreach ($requests->assistant_name as $key2 => $assistant) {
			if($assistant){
				$assistant_profile = new ProfileAssistant;
				$assistant_profile->profile_id = $profile->id;
				$assistant_profile->assistant_name = $assistant;
				$assistant_profile->assistant_email1 = $requests->assistant_email1[$key2];
				$assistant_profile->assistant_email2 = $requests->assistant_email2[$key2];
				$assistant_profile->assistant_email3 = $requests->assistant_email3[$key2];
				$assistant_profile->assistant_number1 = $requests->assistant_number1[$key2];
				$assistant_profile->assistant_number2 = $requests->assistant_number2[$key2];
				$assistant_profile->assistant_number3 = $requests->assistant_number3[$key2];
				$assistant_profile->save();
			}
		}

		Session::flash('message', 'Record successfully updated.');
		return redirect('/profiles/'.$profile->slug);
	}


	public function typeahead($q)
	{
		return Profile::search($q)->get();
	}

	public function print($slug){
		$profile = Profile::whereSlug($slug)->first();
		return view('profiles.print', compact('profile'));
	}

}
