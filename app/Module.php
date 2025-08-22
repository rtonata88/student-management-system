<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Module extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['subject_name', 'subject_code', 'subject_fees'];

    public function extra_fees()
    {
        return $this->hasMany(ModuleExtraFee::class);
    }

    public function subjectAllocations()
    {
        return $this->hasMany(SubjectAllocation::class, 'subject_id');
    }

    public function assessmentWeights()
    {
        return $this->hasMany(AssessmentWeight::class);
    }

    public function testMarks()
    {
        return $this->hasMany(TestMark::class);
    }

    public function examPaperWeights()
    {
        return $this->hasMany(ExamPaperWeight::class);
    }

    public function examMarks()
    {
        return $this->hasMany(ExamMark::class);
    }
}
