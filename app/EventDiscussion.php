<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventDiscussion extends Model
{
    protected $fillable = ['event_id', 'discussion_point'];
}
