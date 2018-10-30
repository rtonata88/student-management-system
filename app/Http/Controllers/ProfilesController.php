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
		$profiles = Profile::with(['sector', 'language', 'country', 'city', 'organization'])->paginate(50);
		//$profiles = Laratables::recordsOf(Profile::class);

		return view('profiles.index', compact('profiles'));
	}
	/**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function getSimpleDatatablesData()
    {
        return Laratables::recordsOf(Profile::class);
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
		$titles = Title::pluck('title', 'title');
		$gender = Gender::pluck('gender', 'id');
		$organizations = Organization::pluck('name', 'id');
		$cities = City::pluck('name', 'id');
		$fruit_roles = FruitRole::pluck('role', 'id');
		$teams = Team::pluck('name', 'id');
		$fruit_levels = FruitLevel::pluck('level', 'id');
		$fruit_stages = FruitStage::pluck('stage', 'id');
		$maintainers = Maintainer::pluck('name', 'id');
		$sector_relationships = SectorRelationship::pluck('relationship', 'id');

		return view('profiles.create', compact('languages', 'sectors', 'countries', 'titles', 'gender', 'organizations', 'cities', 'fruit_roles', 'teams', 'fruit_levels', 'fruit_stages', 'maintainers', 'sector_relationships'));
	}

	public function show($slug){
		$profile = Profile::whereSlug($slug)->first();
		
		return view('profiles.show', compact('profile'));
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
		$titles = Title::pluck('title', 'title');
		$gender = Gender::pluck('gender', 'id');
		$organizations = Organization::pluck('name', 'id');
		$cities = City::pluck('name', 'id');
		$fruit_roles = FruitRole::pluck('role', 'id');
		$teams = Team::pluck('name', 'id');
		$fruit_levels = FruitLevel::pluck('level', 'id');
		$fruit_stages = FruitStage::pluck('stage', 'id');
		$maintainers = Maintainer::pluck('name', 'id');
		$sector_relationships = SectorRelationship::pluck('relationship', 'id');

		$profile = Profile::whereSlug($slug)->first();

		return view('profiles.edit', compact('profile','languages', 'sectors', 'countries', 'titles', 'gender', 'organizations', 'cities', 'fruit_roles', 'teams', 'fruit_levels', 'fruit_stages', 'maintainers', 'sector_relationships'));
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

		$profile->title 					= $requests->title;
		$profile->fullname 					= $requests->fullname;
		$profile->lastname 					= $requests->lastname;
		$profile->slug						= str_slug($requests->title." ".$requests->fullname." ".$requests->lastname);
		$profile->gender_id 				= $requests->gender_id;
		$profile->bio 						= $requests->bio;
		$profile->position 					= $requests->position;
		$profile->organization_id 			= $requests->organization_id;
		$profile->photo 					= $profile_photo;
		$profile->sector_id 				= $requests->sector_id;
		$profile->country_id 				= $requests->country_id;
		$profile->city_id 					= $requests->city_id;
		$profile->mobile_no 				= $requests->mobile_no;
		$profile->work_number 				= $requests->work_number;
		$profile->email 					= $requests->email;
		$profile->assistant_name 			= $requests->assistant_name;
		$profile->assistant_number 			= $requests->assistant_number;
		$profile->date_networked 			= $requests->date_networked;
		$profile->fruit_level_id 			= $requests->fruit_level_id;
		$profile->fruit_stage_id 			= $requests->fruit_stage_id;
		$profile->maintainer_id 			= $requests->maintainer_id;
		$profile->fruit_role_id 			= $requests->fruit_role_id;
		$profile->sector_relationship_id 	= $requests->sector_relationship_id;
		$profile->history 					= $requests->history;
		$profile->language_id 				= $requests->language_id;
		$profile->work_number2 				= $requests->work_number2;
		$profile->work_number_other 		= $requests->work_number_other;
		$profile->email2 					= $requests->email2;
		$profile->mobile_no2 				= $requests->mobile_no2;
		$profile->mobile_no_other			= $requests->mobile_no_other;
		$profile->assistant_email			= $requests->assistant_email;
		$profile->team_id					= $requests->team_id;

		$profile->save();

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
			$profile->photo 					= $profile_photo;
		}

		

		$profile->title 					= $requests->title;
		$profile->fullname 					= $requests->fullname;
		$profile->lastname 					= $requests->lastname;
		$profile->slug						= str_slug($requests->title." ".$requests->fullname." ".$requests->lastname);
		$profile->gender_id 				= $requests->gender_id;
		$profile->bio 						= $requests->bio;
		$profile->position 					= $requests->position;
		$profile->organization_id 			= $requests->organization_id;
		$profile->sector_id 				= $requests->sector_id;
		$profile->country_id 				= $requests->country_id;
		$profile->city_id 					= $requests->city_id;
		$profile->mobile_no 				= $requests->mobile_no;
		$profile->work_number 				= $requests->work_number;
		$profile->email 					= $requests->email;
		$profile->assistant_name 			= $requests->assistant_name;
		$profile->assistant_number 			= $requests->assistant_number;
		$profile->date_networked 			= $requests->date_networked;
		$profile->fruit_level_id 			= $requests->fruit_level_id;
		$profile->fruit_stage_id 			= $requests->fruit_stage_id;
		$profile->maintainer_id 			= $requests->maintainer_id;
		$profile->fruit_role_id 			= $requests->fruit_role_id;
		$profile->sector_relationship_id 	= $requests->sector_relationship_id;
		$profile->history 					= $requests->history;
		$profile->language_id 				= $requests->language_id;
		$profile->work_number2 				= $requests->work_number2;
		$profile->work_number_other 		= $requests->work_number_other;
		$profile->email2 					= $requests->email2;
		$profile->mobile_no2 				= $requests->mobile_no2;
		$profile->mobile_no_other			= $requests->mobile_no_other;
		$profile->assistant_email			= $requests->assistant_email;
		$profile->team_id					= $requests->team_id;

		$profile->save();

		Session::flash('message', 'Record successfully updated.');
		return redirect('/profiles/'.$profile->slug);
	}


	public function typeahead($q)
	{
		return Profile::search($q)->get();
	}

}
