<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportType extends Model
{
    public function language(){
    	return $this->belongsTo('App\Language');
    }
}
