<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Team;
use App\City;
use App\Role;
use App\Sector;
use App\Country;
use App\Language;
use App\Department;

use Session;


class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(){
    	$users = User::with('country')->get();
    	return view('users.index', compact('users'));
    }

    public function create(){
    	$teams = Team::pluck('name', 'id');
    	$cities = City::pluck('name', 'id');
    	$languages = Language::pluck('name', 'id');
        $roles = Role::pluck('display_name', 'id');
    	$departments = Department::pluck('name', 'id');

    	return view('users.create', compact('teams', 'sectors', 'countries', 'departments', 'cities', 'languages', 'roles'));
    }

    public function edit($id){
    	$user = User::find($id);
    	$teams = Team::pluck('name', 'id');
    	$cities = City::pluck('name', 'id');
    	$sectors = Sector::pluck('name', 'id');
    	$countries = Country::pluck('name', 'id');
    	$languages = Language::pluck('name', 'id');
        $roles = Role::pluck('display_name', 'id');
    	$departments = Department::pluck('name', 'id');

    	return view('users.edit', compact('user', 'teams', 'sectors', 'countries', 'departments', 'cities', 'languages', 'roles'));
    }

    public function show($id){
    	$user = User::find($id);
    	return view('users.show', compact('user'));
    }

    public function store(Request $requests)
    {
    	$validated = $this->validate($requests, [
    		'username' => 'required|string|max:255|unique:users',
            'email' => 'required|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',

        ]);


    	$user = new User;

    	$user->name = $requests->name;
    	$user->email = $requests->email;
    	$user->username = $requests->username;
    	$user->approved = 1;
    	$user->password = bcrypt($requests->password);
    	$user->gender = $requests->gender;
    	$user->department_id = $requests->department_id;
    	$user->country_id = City::find($requests->city_id)->country_id;
    	$user->city_id = $requests->city_id;
    	$user->prefered_language = $requests->language_id;
    	$user->save();

        foreach ($requests->roles as $key) {
            $role = Role::find($key);
            $user->attachRole($role);
        }

        $user->syncRoles($requests->roles);

		$user->team()->sync($requests->teams);
		$user->sector()->sync(Team::whereIn('id', $requests->teams)->pluck('sector_id'));

    	Session::flash('message', 'Saved successfully, please confirm that the changes have taken effect in the table below.');
    	return redirect('/users');
    }


    public function update(Request $requests, $id)
    {
    	$user = User::find($id);

    	$this->validate($requests, [
            'email' => 'required|max:255|email|unique:users,id,'.$id,

        ]);

		if(isset($requests->password)){
            $requests->validate([
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);
            
            $user->update(['password' => Hash::make($request->password)]);
        }

    	$user->name = $requests->name;
    	$user->email = $requests->email;
    	$user->gender = $requests->gender;
    	$user->sector_id = $requests->sector_id;
    	$user->team_id = $requests->team_id;
    	$user->department_id = $requests->department_id;
    	$user->country_id = City::find($requests->city_id)->country_id;
    	$user->city_id = $requests->city_id;
    	$user->prefered_language = $requests->prefered_language;
    	$user->save();

        foreach ($requests->roles as $key) {
            $role = Role::find($key);
            $user->syncRoles([$role->id]);
        }
        $user->syncRoles($requests->roles);

		$user->team()->sync($requests->teams);
		$user->sector()->sync(Team::whereIn('id', $requests->teams)->pluck('sector_id'));

    	Session::flash('message', 'The record has been updated, please confirm that the changes have taken effect in the table below.');
    	return redirect('/users');
    }

    public function disableEnableUser($id){
    	$user = User::find($id);

    	if($user->approved == 1){
    		$user->approved = 0;
    	} else {
    		$user->approved = 1;
    	}
    	$user->save();

    	return redirect('/users');
    }

    public function destroy($id){
    	$user = User::destroy($id);
    	Session::flash('message', 'Deleted Successfully');
    	return redirect('/users');
    }
}
