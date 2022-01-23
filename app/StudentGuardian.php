<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentGuardian extends Model
{
    protected $fillable = ['student_id', 'guardian_names', 'surname', 'relationship', 'contact_number', 'contact_email'];
}
