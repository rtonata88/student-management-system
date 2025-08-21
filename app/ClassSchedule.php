<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ClassSchedule extends Model
{
    protected $fillable = [
        'academic_year_id', 'center_id', 'subject_allocation_id', 'venue_id',
        'class_duration_id', 'day_of_week', 'effective_from', 'effective_to',
        'notes', 'is_active', 'created_by'
    ];

    protected $casts = [
        'effective_from' => 'date',
        'effective_to' => 'date',
        'is_active' => 'boolean'
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function subjectAllocation()
    {
        return $this->belongsTo(SubjectAllocation::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function classDuration()
    {
        return $this->belongsTo(ClassDuration::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForAcademicYear($query, $academicYearId)
    {
        return $query->where('academic_year_id', $academicYearId);
    }

    public function scopeForCenter($query, $centerId)
    {
        return $query->where('center_id', $centerId);
    }

    public function scopeForDay($query, $dayOfWeek)
    {
        return $query->where('day_of_week', $dayOfWeek);
    }

    public function scopeCurrent($query)
    {
        $today = Carbon::today();
        return $query->where('effective_from', '<=', $today)
                    ->where(function($q) use ($today) {
                        $q->whereNull('effective_to')
                          ->orWhere('effective_to', '>=', $today);
                    });
    }

    public function getFormattedDayAttribute()
    {
        return ucfirst($this->day_of_week);
    }

    public function getTeacherNameAttribute()
    {
        if ($this->subjectAllocation && $this->subjectAllocation->user) {
            $user = $this->subjectAllocation->user;
            $fullName = trim($user->surname . ' ' . $user->other_names);
            return !empty($fullName) ? $fullName : $user->name;
        }
        return 'Not Assigned';
    }

    public function getSubjectNameAttribute()
    {
        return $this->subjectAllocation && $this->subjectAllocation->module 
            ? $this->subjectAllocation->module->subject_name 
            : 'Unknown Subject';
    }

    public function getSubjectCodeAttribute()
    {
        return $this->subjectAllocation && $this->subjectAllocation->module 
            ? $this->subjectAllocation->module->subject_code 
            : 'N/A';
    }

    // Check for teacher conflicts
    public static function hasTeacherConflict($subjectAllocationId, $classDurationId, $dayOfWeek, $effectiveFrom, $excludeId = null)
    {
        $query = self::where('subject_allocation_id', $subjectAllocationId)
                    ->where('class_duration_id', $classDurationId)
                    ->where('day_of_week', $dayOfWeek)
                    ->where('effective_from', '<=', $effectiveFrom)
                    ->where(function($q) use ($effectiveFrom) {
                        $q->whereNull('effective_to')
                          ->orWhere('effective_to', '>=', $effectiveFrom);
                    })
                    ->where('is_active', true);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    // Check for venue conflicts
    public static function hasVenueConflict($venueId, $classDurationId, $dayOfWeek, $effectiveFrom, $excludeId = null)
    {
        $query = self::where('venue_id', $venueId)
                    ->where('class_duration_id', $classDurationId)
                    ->where('day_of_week', $dayOfWeek)
                    ->where('effective_from', '<=', $effectiveFrom)
                    ->where(function($q) use ($effectiveFrom) {
                        $q->whereNull('effective_to')
                          ->orWhere('effective_to', '>=', $effectiveFrom);
                    })
                    ->where('is_active', true);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
