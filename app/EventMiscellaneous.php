<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventMiscellaneous extends Model
{
    public function files(){
    	return $this->hasMany('App\EventMiscellaneousFile');
    }

    public function event(){
    	return $this->belongsTo('App\Event');
    }
}
