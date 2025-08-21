<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamPaperWeight extends Model
{
    protected $fillable = [
        'module_id',
        'academic_year_id', 
        'examination_id',
        'paper_name',
        'paper_code',
        'weight',
        'description'
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

    /**
     * Get the examination that owns the exam paper weight.
     */
    public function examination()
    {
        return $this->belongsTo('App\Examination');
    }

    /**
     * Get the exam paper that owns the exam paper weight.
     */
    public function examPaper()
    {
        return $this->belongsTo(ExamPaper::class, 'paper_code', 'paper_code');
    }
}
