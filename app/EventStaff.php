<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventStaff extends Model
{
    public function role(){
    	return $this->belongsTo('App\EventStaffRole', 'role_id');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
