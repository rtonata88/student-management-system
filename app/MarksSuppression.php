<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarksSuppression extends Model
{
    protected $fillable = [
        'academic_year_id',
        'intake',
        'campus',
        'mark_type',
        'study_mode',
        'is_suppressed',
        'reason',
        'created_by'
    ];

    protected $casts = [
        'is_suppressed' => 'boolean',
    ];

    /**
     * Get the academic year that owns the suppression.
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the user who created the suppression.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check if marks are suppressed for given criteria
     */
    public static function isMarksSuppressed($academicYearId, $intake, $campus, $markType, $studyMode)
    {
        return self::where([
            'academic_year_id' => $academicYearId,
            'intake' => $intake,
            'campus' => $campus,
            'mark_type' => $markType,
            'study_mode' => $studyMode,
            'is_suppressed' => true
        ])->exists();
    }

    /**
     * Get suppression status for given criteria
     */
    public static function getSuppressionStatus($academicYearId, $intake, $campus, $markType, $studyMode)
    {
        return self::where([
            'academic_year_id' => $academicYearId,
            'intake' => $intake,
            'campus' => $campus,
            'mark_type' => $markType,
            'study_mode' => $studyMode
        ])->first();
    }

    /**
     * Scope to filter by academic year
     */
    public function scopeByAcademicYear($query, $academicYearId)
    {
        return $query->where('academic_year_id', $academicYearId);
    }

    /**
     * Scope to filter by intake
     */
    public function scopeByIntake($query, $intake)
    {
        return $query->where('intake', $intake);
    }

    /**
     * Scope to filter by campus
     */
    public function scopeByCampus($query, $campus)
    {
        return $query->where('campus', $campus);
    }

    /**
     * Scope to filter by mark type
     */
    public function scopeByMarkType($query, $markType)
    {
        return $query->where('mark_type', $markType);
    }

    /**
     * Scope to filter by study mode
     */
    public function scopeByStudyMode($query, $studyMode)
    {
        return $query->where('study_mode', $studyMode);
    }

    /**
     * Scope to get only suppressed marks
     */
    public function scopeSuppressed($query)
    {
        return $query->where('is_suppressed', true);
    }
}
