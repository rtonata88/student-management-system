<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function edit($id){
    	$user = User::find($id);
		$permissions = Permission::all();

    	return view('users.edit', compact('user', 'permissions'));
    }

    public function show($id){
    	$user = User::find($id);
    	return view('users.show', compact('user'));
    }

    public function store(Request $requests)
    {
    	$validated = $this->validate($requests, [
            'email' => 'required|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);

		$data = $requests->all();

		$data['username'] = str_slug($requests->name, '.');

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
            
            $user->update(['password' => Hash::make($request->password)]);
        }

    	$user->update($request->all());

        foreach ($requests->roles as $key) {
            $role = Role::find($key);
            $user->syncRoles([$role->id]);
        }
		
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
