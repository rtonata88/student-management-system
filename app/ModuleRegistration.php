<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleRegistration extends Model
{
    public function subject(){
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }
}
