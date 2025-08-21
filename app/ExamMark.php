<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamMark extends Model
{
    protected $fillable = [
        'student_id',
        'module_id', 
        'academic_year_id',
        'exam_type_id',
        'exam_paper_id',
        'marks_obtained',
        'total_marks',
        'captured_by'
    ];

    protected $casts = [
        'marks_obtained' => 'decimal:2',
        'total_marks' => 'decimal:2',
    ];

    /**
     * Get the student that owns the exam mark.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the module that owns the exam mark.
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Get the academic year that owns the exam mark.
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the exam type that owns the exam mark.
     */
    public function examType()
    {
        return $this->belongsTo(AssessmentType::class, 'exam_type_id');
    }

    /**
     * Get the exam paper that owns the exam mark.
     */
    public function examPaper()
    {
        return $this->belongsTo(ExamPaper::class);
    }

    /**
     * Get the user who captured the mark.
     */
    public function capturedBy()
    {
        return $this->belongsTo(User::class, 'captured_by');
    }

    /**
     * Get the percentage for this exam mark.
     */
    public function getPercentageAttribute()
    {
        if ($this->total_marks > 0) {
            return round(($this->marks_obtained / $this->total_marks) * 100, 2);
        }
        return 0;
    }

    /**
     * Scope to filter by academic year.
     */
    public function scopeForAcademicYear($query, $academicYearId)
    {
        return $query->where('academic_year_id', $academicYearId);
    }

    /**
     * Scope to filter by module.
     */
    public function scopeForModule($query, $moduleId)
    {
        return $query->where('module_id', $moduleId);
    }

    /**
     * Scope to filter by exam type.
     */
    public function scopeForExamType($query, $examTypeId)
    {
        return $query->where('exam_type_id', $examTypeId);
    }
}
