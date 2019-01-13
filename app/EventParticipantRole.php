<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventParticipantRole extends Model
{
    protected $fillable = ['event_id', 'role_name'];
}
