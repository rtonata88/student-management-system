<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role;
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
        return view('users.roles.index', compact('roles'));
    }

    //Loads the form for creating new roles
    public function create()
    {
        return view('users.roles.create');
    }

    //loads and populates the form for editing an existing role
    public function edit($id)
    {
        $role = Role::find($id);
        return view('users.roles.edit', compact('role'));
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
        $this->validate($requests, [
            'name' => 'required|max:255|unique:roles,name,' . $role->id,
        ]);
        
        if($role->update($requests->all()))
        {
            Session::flash('success', $requests->display_name.' successfully updated');
        }
        return redirect('/roles');
    }
}
