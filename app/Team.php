<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laratrust\LaratrustTeam;

class Team extends LaratrustTeam 
{
    public function language(){
    	return $this->belongsTo('App\Language');
    }

    public function sector(){
    	return $this->belongsTo('App\Sector');
    }
}
