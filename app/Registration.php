<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    //protected $with = array('center');

    public function subject(){
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function center(){
        return $this->belongsTo(Center::class, 'center_id');
    }
}
