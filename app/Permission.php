<?php

namespace App;

use Laratrust\Models\LaratrustPermission;
use App\Role;
use DB;

class Permission extends LaratrustPermission
{
    protected $fillable = ['name', 'display_name', 'description'];

    public function role_id()
    {
        // return $this->belongsToMany(Role::class);
        $results = DB::table('permission_role')
	    ->where('permission_id', '=', $this->id)
	    ->first()->role_id;

        return $results;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id');
    }
}
