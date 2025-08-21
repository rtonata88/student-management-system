<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradingScale extends Model
{
    protected $fillable = [
        'module_id',
        'academic_year_id', 
        'examination_id',
        'min_mark',
        'max_mark',
        'grade',
        'result_code_id',
        'pass_fail',
        'active'
    ];

    protected $casts = [
        'min_mark' => 'decimal:2',
        'max_mark' => 'decimal:2',
        'active' => 'boolean'
    ];

    // Relationships
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function resultCode()
    {
        return $this->belongsTo(ResultCode::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopePass($query)
    {
        return $query->where('pass_fail', 'Pass');
    }

    public function scopeFail($query)
    {
        return $query->where('pass_fail', 'Fail');
    }

    // Accessor for mark range display
    public function getMarkRangeAttribute()
    {
        return $this->min_mark . ' - ' . $this->max_mark;
    }
}
