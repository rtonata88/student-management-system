<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public function profiles()
    {
        return $this->belongsToMany('App\Profile');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function activity_type()
    {
    	return $this->belongsTo('App\ActivityType');
    }

    public function photos()
    {
    	return $this->hasMany('App\ActivityPhoto');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function liaising_activities(){
        
    }
}
