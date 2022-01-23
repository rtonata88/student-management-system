<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationBoard extends Model
{
    protected $fillable = ['name', 'contact_number', 'address', 'country_id'];

    public function country(){
        return $this->belongsTo(Country::class);
    }
}
