<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class City extends Model
{
	
    

    public function country()
    {
    	return $this->belongsTo('App\Country', 'country_id');
    }

    public function language(){
        return $this->belongsTo('App\Language');
    }
}
