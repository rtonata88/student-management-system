<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = ['name', 'status'];

    public function report(){
    	return $this->hasMany(CampaignReport::class);
    }
}
