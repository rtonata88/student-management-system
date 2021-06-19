<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignReport extends Model
{
    public function reportedBy(){
        return $this->belongsTo('App\User', 'reported_by');
    }

    public function campaign(){
        return $this->belongsTo('App\Campaign');
    }

    public function region(){
        return $this->belongsTo('App\City', 'city_id');
    }
}
