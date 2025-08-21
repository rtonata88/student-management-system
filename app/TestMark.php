<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TestMark extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'student_id',
        'module_id',
        'academic_year_id',
        'assessment_type_id',
        'marks_obtained',
        'total_marks',
        'remarks',
        'captured_at',
        'captured_by'
    ];

    protected $casts = [
        'marks_obtained' => 'decimal:2',
        'total_marks' => 'decimal:2',
        'captured_at' => 'datetime'
    ];

    protected $dates = [
        'captured_at'
    ];

    /**
     * Get the student that owns the test mark
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the module that this test mark belongs to
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Get the academic year for this test mark
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the assessment type for this test mark
     */
    public function assessmentType()
    {
        return $this->belongsTo(AssessmentType::class);
    }

    /**
     * Get the user who captured this mark
     */
    public function capturedBy()
    {
        return $this->belongsTo(User::class, 'captured_by');
    }

    /**
     * Get the assessment weight for this test mark
     */
    public function assessmentWeight()
    {
        return $this->hasOne(AssessmentWeight::class, 'assessment_type_id', 'assessment_type_id')
                    ->where('module_id', $this->module_id)
                    ->where('academic_year_id', $this->academic_year_id);
    }

    /**
     * Calculate percentage score
     */
    public function getPercentageAttribute()
    {
        if ($this->total_marks > 0 && $this->marks_obtained !== null) {
            return round(($this->marks_obtained / $this->total_marks) * 100, 2);
        }
        return 0;
    }

    /**
     * Calculate weighted marks based on assessment weight
     */
    public function getWeightedMarksAttribute()
    {
        $weight = $this->assessmentWeight;
        if ($weight && $this->marks_obtained !== null && $this->total_marks > 0) {
            $percentage = ($this->marks_obtained / $this->total_marks) * 100;
            return round(($percentage * $weight->weight) / 100, 2);
        }
        return 0;
    }

    /**
     * Scope to filter by module and academic year
     */
    public function scopeForModuleAndYear($query, $moduleId, $academicYearId)
    {
        return $query->where('module_id', $moduleId)
                    ->where('academic_year_id', $academicYearId);
    }

    /**
     * Scope to filter by student
     */
    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Scope to filter by assessment type
     */
    public function scopeForAssessmentType($query, $assessmentTypeId)
    {
        return $query->where('assessment_type_id', $assessmentTypeId);
    }
}
