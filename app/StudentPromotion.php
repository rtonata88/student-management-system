<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentPromotion extends Model
{
    protected $fillable = [
        'student_id',
        'academic_year_id',
        'promotional_status_id',
        'year_level',
        'remarks',
        'promoted_by',
        'promoted_at'
    ];

    protected $casts = [
        'promoted_at' => 'datetime',
    ];

    /**
     * Get the student that owns the promotion.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the academic year for the promotion.
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the promotional status.
     */
    public function promotionalStatus()
    {
        return $this->belongsTo(PromotionalStatus::class);
    }

    /**
     * Get the user who promoted the student.
     */
    public function promotedBy()
    {
        return $this->belongsTo(User::class, 'promoted_by');
    }

    /**
     * Scope to filter by academic year.
     */
    public function scopeForAcademicYear($query, $academicYearId)
    {
        return $query->where('academic_year_id', $academicYearId);
    }

    /**
     * Scope to filter by promotional status.
     */
    public function scopeByStatus($query, $statusId)
    {
        return $query->where('promotional_status_id', $statusId);
    }
}
