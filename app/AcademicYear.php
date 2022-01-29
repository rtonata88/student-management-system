<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $fillable = ['academic_year', 'start_date', 'end_date', 'status'];
}
