<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventActivity extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User', 'event_activity_user', 'activity_id');
    }

    public function activity_type()
    {
    	return $this->belongsTo('App\ActivityType');
    }

    public function participant(){
    	return $this->belongsTo('App\EventOrganization');	
    }

    public function event(){
    	return $this->belongsTo('App\Event');
    }

    public function photos(){
        return $this->hasMany('App\EventActivityPhoto','activity_id');
    }
}
