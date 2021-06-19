<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventOrganization extends Model
{
    protected $table = 'event_other_attendees';
    protected $fillable = ['event_id', 'name', 'email', 'participant_role', 'send_email'];


    // public function event(){
    // 	return $this->belongsTo('App\Event', 'participant_role_id');
    // }
}
