<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
   public function language(){
    	return $this->belongsTo('App\Language');
    }
}
