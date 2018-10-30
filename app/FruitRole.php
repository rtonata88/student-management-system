<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FruitRole extends Model
{
    public function language(){
    	return $this->belongsTo('App\Language');
    }
}
