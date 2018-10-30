<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventActivityLog extends Model
{
    protected $fillable = ['event_id', 'action', 'user_id', 'participant_id', 'description'];


    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function participant(){
    	return $this->belongsTo('App\Profile');
    }
}
