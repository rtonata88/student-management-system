<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileDocument extends Model
{
    public function user(){
    	return $this->belongsTo('App\User', 'uploaded_by');
    }
}
