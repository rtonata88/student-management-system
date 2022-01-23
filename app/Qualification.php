<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $fillable = ['qualification_name','institution', 'start_year', 'end_year', 'model', 'model_id'];
}
