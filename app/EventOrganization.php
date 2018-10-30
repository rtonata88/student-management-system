<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventOrganization extends Model
{
    protected $table = 'event_other_attendees';
    protected $fillable = ['event_id', 'name', 'email', 'participant_role_id', 'send_email'];


    public function role(){
    	return $this->belongsTo('App\EventParticipantRole', 'participant_role_id');
    }
}
