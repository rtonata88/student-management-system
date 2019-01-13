<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventStaffRole extends Model
{
    protected $fillable = ['event_id', 'role_name'];
}
