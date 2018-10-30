<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public function language(){
    	return $this->belongsTo('App\Language');
    }

    public function sector()
    {
    	return $this->belongsTo('App\Sector');
    }

    public function country()
    {
    	return $this->belongsTo('App\Country');
    }

    public function industry()
    {
    	return $this->belongsTo('App\Industry');
    }
}
