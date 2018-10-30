<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function language(){
    	return $this->belongsTo('App\Language');
    }

    public function sector(){
    	return $this->belongsTo('App\Sector');
    }
}
