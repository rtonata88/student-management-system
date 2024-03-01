<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use App\Role;

use Session;
use Hash;
use DB;

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
    
        $roles = Role::all();
    	return view('Users.Create', compact('roles'));
    }

    public function edit($username)
    {
    	$user = User::where('username', $username)->first();
		$roles = Role::all();
		$assigned_roles = $user->roles->pluck('id')->toArray();
    	return view('Users.Edit', compact('user', 'roles', 'assigned_roles'));
    }

    public function show($username)
    {
		$user = User::where('username', $username)->first();
    	return view('Users.Show', compact('user'));
    }

    public function store(Request $requests)
    {
    	$validated = $this->validate($requests, [
            'email' => 'required|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);

		$data = $requests->all();
		$data['username'] = Str::slug($requests->name, '.');
        $data['password'] = bcrypt($requests->password);
    	$user = User::create($data);
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
        
        // Sync roles
        $user->syncRoles($requests->roles);
        if($requests->roles)
        {
            $roleNames = Role::whereIn('id',$requests->roles)->get()->pluck('name');
            // Sync permissions based on the assigned roles
            $permissions = Role::whereIn('name', $roleNames)
            ->with('permissions')->get()->pluck('permissions')
            ->flatten()->unique('id')->pluck('name')->toArray();
            $user->syncPermissions($permissions); 
        }else
        {   
            $permissions = [];
            $user->syncPermissions($permissions); 
        }
        
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
