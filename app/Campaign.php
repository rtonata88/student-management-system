<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;

class Campaign extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable;
    protected $fillable = ['name', 'status'];

    public function report(){
    	return $this->hasMany(CampaignReport::class);
    }
}
