<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\Role;
use App\User;
use Session;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //Lists all roles
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    //Loads the form for creating new roles
    public function create()
    {
        return view('roles.create');
    }

    //loads and populates the form for editing an existing role
    public function edit($id)
    {
        $role = Role::find($id);
        return view('roles.edit', compact('role'));
    }

    public function show($id){
        $role = Role::where('id', $id)->first();
        $permissions = Permission::all();
        $assigned_permissions = $role->permissions->pluck('id')->toArray();
        return view('Roles.Show', compact('role','permissions','assigned_permissions'));
    }

    //saves a new role to the database
    public function store(Request $requests)
    {
        $this->validate($requests, [
            'name' => 'required|max:255|unique:roles',
        ]);
        $role = new Role;
        if($role->create($requests->all()))
        {
            Session::flash('success', $requests->display_name.' successfully created');
        }
        return redirect('/roles');
    }

    //updates and saves role to the database
    public function update(Request $requests, $id)
    {
        $role = Role::find($id);
        
        if($role->update($requests->all()))
        {
            Session::flash('success', $requests->display_name.' successfully updated');
        }

        // Attach the permission to the specified role
        $role->syncPermissions($requests->permissions);
        $users = $role->users;

        foreach ($users as $key => $user) 
        {
            $user = User::find($user['id']);
            $user->syncRoles([$role->id]);
            $user->syncPermissions([$requests->permissions[$key]]);
        }
        return redirect('/roles');
    }
}
