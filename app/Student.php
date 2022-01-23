<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['student_number', 'surname', 'student_names', 'initials', 'gender', 'contact_number', 'contact_email'];
}