<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventParticipant extends Model
{
    protected $fillable = ['event_id', 'profile_id', 'participant_role_id', 'rsvp_status'];

    public function profile(){
    	return $this->belongsTo('App\Profile');
    }

    public function role(){
    	return $this->belongsTo('App\EventParticipantRole', 'participant_role_id');
    }
}
