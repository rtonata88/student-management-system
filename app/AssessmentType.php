<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentType extends Model
{
    use HasFactory;

    public function assessments()
    {
        return $this->hasMany(Assessment::class,'assessment_type_id');
    }

}
