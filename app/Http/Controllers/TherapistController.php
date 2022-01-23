<?php

namespace App\Http\Controllers;

use App\Specialty;
use App\Therapist;
use App\Language;
use App\Gender;
use App\Country;
use App\User;
use App\Qualification;
use App\LicenceType;
use App\RegistrationBoard;
use App\TherapistPublication;
use Illuminate\Http\Request;
use Auth;
use Image;

class TherapistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $therapists = Therapist::paginate(50);
        $specialiaties = Specialty::pluck('specialty', 'id');
        $countries = Country::pluck('name', 'id');
        $license_types = LicenceType::pluck('type', 'id');

        return view('therapists.index', compact('therapists', 'specialiaties', 'countries', 'license_types'));
    }

    public function filter(Request $request)
    {
        $user = Auth::user();

        $profiles = Profile::whereIn('team_id', $user->team->pluck('id'))->with(['sector', 'language', 'country', 'city']);

        $profiles = EloquentBuilder::to($profiles, $request->except(['_token']));
        $profiles = $profiles->paginate(1000);

        $sectors = Sector::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        $organisations = Organization::pluck('name', 'id');
        $cities = City::pluck('name', 'id');
        $fruit_roles = FruitRole::pluck('role', 'id');
        $teams = Team::pluck('name', 'id');
        $fruit_levels = FruitLevel::pluck('level', 'id');
        $fruit_stages = FruitStage::pluck('stage', 'id');

        session()->put('profiles_filter', $request->except(['_token']));

        return view('profiles.index', compact('profiles', 'teams', 'profiles', 'sectors', 'countries', 'organisations', 'cities', 'fruit_stages', 'fruit_levels', 'fruit_roles'));
    }
    /**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function getSimpleDatatablesData()
    {
        return Laratables::recordsOf(
            Profile::class,
            function ($query) {
                $user = Auth::user();
                if ($user->hasRole('department leader')) {
                    return $query;
                } else {
                    return $query->where('team_id', $user->team_id);
                }
            }
        );
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
        $countries = Country::pluck('name', 'id');
        $sex = Gender::pluck('gender', 'id');
        $specialties = Specialty::pluck('specialty', 'id');
        $license_types = LicenceType::pluck('type', 'id');
        $boards = RegistrationBoard::pluck('name', 'id');


        return view('therapists.create', compact('languages', 'boards', 'countries', 'specialties', 'sex', 'license_types'));
    }

    public function edit($id)
    {
        $therapist = Therapist::find($id);
        $languages = Language::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        $sex = Gender::pluck('gender', 'id');
        $specialties = Specialty::pluck('specialty', 'id');
        $license_types = LicenceType::pluck('type', 'id');
        $boards = RegistrationBoard::pluck('name', 'id');

        return view('therapists.edit', compact('therapist','languages', 'boards', 'countries', 'specialties', 'sex', 'license_types'));
    } 

    public function show($id)
    {
        $therapist = Therapist::find($id);

        return view('therapists.show', compact('therapist'));
    }

    public function store(Request $request){
        $request->validate([
            'email' => 'string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);

        $profile_photo = "";
        if ($request->hasFile('photo')) {
            $original_photo = $request->file('photo');
            $thumbnail_photo = Image::make($original_photo);
            $thumbnail_path = public_path('storage') . '/therapists/thumbnail/';
            $original_path = public_path('storage') . '/therapists/photos/';

            $thumbnail_photo->save($original_path . time() . "_" . $original_photo->getClientOriginalName());
            $thumbnail_photo->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $thumbnail_photo->save($thumbnail_path . time() . "_" . $original_photo->getClientOriginalName());
            $profile_photo =  time() . "_" . $original_photo->getClientOriginalName();
        }
        $data = $request->all();
        $data['photo'] = $profile_photo;
        $therapist = Therapist::create($data);

        $therapist->specialties()->sync($request->specialties);
        $therapist->languages()->sync($request->languages);
        $this->createQualification($therapist, $request);
        $this->createPublication($therapist, $request);
        $this->createUser($request);

        return redirect()->route('therapists.index');
    }

    public function update(Request $request, $id){

        $therapist = Therapist::find($id);
         $therapist->update($request->all());

        Qualification::where('model', 'Therapist')
                    ->where('model_id', $id)
                    ->delete();

        TherapistPublication::where('therapist_id', $id)
                            ->delete();


        $therapist->specialties()->sync($request->specialties);
        $therapist->languages()->sync($request->languages);
        $this->createQualification($therapist, $request);
        $this->createPublication($therapist, $request);
        
        return redirect()->route('therapists.show', $id);
    }

    private function createQualification($therapist, $request){
        for ($i = 0; $i < count($request->qualification_name); $i++) {

            Qualification::create([
                'model' => "Therapist",
                'model_id' => $therapist->id,
                'qualification_name' => $request->qualification_name[$i],
                'institution' => $request->institution[$i],
                'start_year' => $request->start_year[$i],
                'end_year' => $request->end_year[$i]
            ]);
        }
    }

    private function createPublication($therapist, $request){
        for ($i = 0; $i < count($request->title); $i++) {
            TherapistPublication::create([
                'therapist_id' => $therapist->id,
                'title' => $request->title[$i],
                'abstract' => $request->abstract[$i],
                'other_information' => $request->other_information[$i],
            ]);
        }
    }

    private function createUser($request)
    {
        return User::create([
            'name' => $request->name . ' ' . $request->surname,
            'username' => $request->email,
            'password' => bcrypt($request->password),
            'email' => $request->email
        ]);
    }
}
