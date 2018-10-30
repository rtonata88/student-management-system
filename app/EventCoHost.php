<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCoHost extends Model
{
    public function event(){
    	return $this->belongsTo('App\Event');
    }

    public function contacts()
    {
    	return $this->hasMany('App\EventCoHostContact');
    }
}
