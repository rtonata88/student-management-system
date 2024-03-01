<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    public function assessment_type()
    {
        dd($this);
        return $this->belongsTo(AssessmentType::class);
    }
}
