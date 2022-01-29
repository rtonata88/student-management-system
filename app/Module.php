<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['subject_name', 'subject_code', 'subject_fees'];

    public function extra_fees(){
        return $this->hasMany(ModuleExtraFee::class);
    }
}
