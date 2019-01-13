<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizationProfile extends Model
{
    public function organization(){
    	return $this->belongsTo('App\Organization');
    }
}
