<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCoHostContact extends Model
{
    protected $fillable = ['event_co_host_id', 'contact_person', 'contact_number','contact_email'];
}
 