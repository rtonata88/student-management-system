<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TherapistPublication extends Model
{
    protected $fillable = ['therapist_id', 'title', 'abstract', 'other_information'];
}
