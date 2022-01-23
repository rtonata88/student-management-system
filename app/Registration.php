<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    public function subject(){
        return $this->belongsTo(Module::class, 'module_id');
    }
}
