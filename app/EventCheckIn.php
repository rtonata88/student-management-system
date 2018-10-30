<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class EventCheckIn extends Model
{
    public function profile(){
    	return $this->belongsTo('App\Profile');
    }

    public function participant_role(){
    	return DB::table('event_participants')
    		->select('event_participant_roles.role_name')
    		->join('event_participant_roles', 'event_participant_roles.id', '=', 'event_participants.participant_role_id')
    		->where('event_participants.profile_id', $this->profile_id)
    		->first();
    }
}
