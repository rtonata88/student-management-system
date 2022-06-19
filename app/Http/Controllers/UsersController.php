<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use App\Permission;

use Session;
use Hash;


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
    	$users = User::select('name', 'username', 'email')->get();

    	return view('Users.Index', compact('users'));
    }

    public function create(){
    
        $permissions = Permission::all();

    	return view('Users.Create', compact('permissions'));
    }

    public function edit($username){
    	$user = User::where('username', $username)->first();

		$permissions = Permission::all();

		$assigned_permissions = $user->permissions->pluck('id')->toArray();

    	return view('Users.Edit', compact('user', 'permissions', 'assigned_permissions'));
    }

    public function show($username){
		$user = User::where('username', $username)->first();

    	return view('Users.Show', compact('user', 'assigned_permissions'));
    }

    public function store(Request $requests)
    {
    	$validated = $this->validate($requests, [
            'email' => 'required|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);

		$data = $requests->all();

		$data['username'] = Str::slug($requests->name, '.');

    	$user = User::create($data);

        $user->syncPermissions($requests->permissions);

    	Session::flash('message', 'User created successfully!!');

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

            $user->update(['password' => Hash::make($requests->password)]);
        }

    	$user->update($requests->except('password'));
		
		$user->syncPermissions($requests->permissions);

		Session::flash('message', 'User record updated successfully!!!');
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

		Session::flash('message', 'User record updated successfully!!!');
    	return redirect('/users');
    }
}
