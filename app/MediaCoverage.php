<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaCoverage extends Model
{
    public function photos(){
    	return $this->hasMany('App\MediaCoveragePhoto');
    }

    public function user(){
    	return $this->belongsTo('App\User', 'created_by');
    }

     public function profile(){
    	return $this->belongsTo('App\Profile', 'profile_id');
    }
}
