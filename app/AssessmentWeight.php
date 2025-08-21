<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentWeight extends Model
{
    protected $fillable = [
        'module_id',
        'academic_year_id', 
        'assessment_type_id',
        'description',
        'weight'
    ];

    protected $casts = [
        'weight' => 'decimal:2'
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function assessmentType()
    {
        return $this->belongsTo(AssessmentType::class);
    }
}
