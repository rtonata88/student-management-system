<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class TeamReport extends Model
{
    
    public function sector(){
        return $this->belongsTo('App\Sector');
    }

    public function team(){
        return $this->belongsTo('App\Team');
    }

}
