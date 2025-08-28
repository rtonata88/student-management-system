<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ClassSchedule extends Model
{
    protected $fillable = [
        'academic_year_id', 'center_id', 'subject_allocation_id', 'venue_id',
        'class_duration_id', 'day_of_week', 'start_time', 'effective_from', 'effective_to',
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

    // Check for teacher time conflicts (new time-based method)
    public static function hasTeacherTimeConflict($subjectAllocationId, $startTime, $dayOfWeek, $effectiveFrom, $excludeId = null)
    {
        // Get class duration in minutes
        $durationMinutes = \App\Models\ClassDuration::getDefaultDuration();
        
        // Calculate end time
        $startCarbon = \Carbon\Carbon::createFromFormat('H:i', $startTime);
        $endCarbon = $startCarbon->copy()->addMinutes($durationMinutes);
        $endTime = $endCarbon->format('H:i');

        $query = self::where('subject_allocation_id', $subjectAllocationId)
                    ->where('day_of_week', $dayOfWeek)
                    ->where('effective_from', '<=', $effectiveFrom)
                    ->where(function($q) use ($effectiveFrom) {
                        $q->whereNull('effective_to')
                          ->orWhere('effective_to', '>=', $effectiveFrom);
                    })
                    ->where('is_active', true)
                    ->whereNotNull('start_time');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        // Check for time overlap
        $existingSchedules = $query->get();
        
        foreach ($existingSchedules as $schedule) {
            $existingStart = \Carbon\Carbon::createFromFormat('H:i', substr($schedule->start_time, 0, 5));
            $existingEnd = $existingStart->copy()->addMinutes($durationMinutes);
            
            // Check if times overlap
            if (($startCarbon < $existingEnd) && ($endCarbon > $existingStart)) {
                return true;
            }
        }

        return false;
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

    // Check for venue time conflicts (new time-based method)
    public static function hasVenueTimeConflict($venueId, $startTime, $dayOfWeek, $effectiveFrom, $excludeId = null)
    {
        // Get class duration in minutes
        $durationMinutes = \App\Models\ClassDuration::getDefaultDuration();
        
        // Calculate end time
        $startCarbon = \Carbon\Carbon::createFromFormat('H:i', $startTime);
        $endCarbon = $startCarbon->copy()->addMinutes($durationMinutes);
        $endTime = $endCarbon->format('H:i');

        $query = self::where('venue_id', $venueId)
                    ->where('day_of_week', $dayOfWeek)
                    ->where('effective_from', '<=', $effectiveFrom)
                    ->where(function($q) use ($effectiveFrom) {
                        $q->whereNull('effective_to')
                          ->orWhere('effective_to', '>=', $effectiveFrom);
                    })
                    ->where('is_active', true)
                    ->whereNotNull('start_time');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        // Check for time overlap
        $existingSchedules = $query->get();
        
        foreach ($existingSchedules as $schedule) {
            $existingStart = \Carbon\Carbon::createFromFormat('H:i', substr($schedule->start_time, 0, 5));
            $existingEnd = $existingStart->copy()->addMinutes($durationMinutes);
            
            // Check if times overlap
            if (($startCarbon < $existingEnd) && ($endCarbon > $existingStart)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get formatted start time for display
     */
    public function getFormattedStartTimeAttribute()
    {
        if ($this->start_time) {
            try {
                // Extract time part if it's a datetime string
                $timeString = $this->start_time;
                if (strpos($timeString, ' ') !== false) {
                    $timeString = explode(' ', $timeString)[1]; // Get time part after space
                }
                
                // Parse time (H:i or H:i:s format)
                if (strlen($timeString) === 5) {
                    // Format is H:i (e.g., "14:30")
                    $startTime = \Carbon\Carbon::createFromFormat('H:i', $timeString);
                } else {
                    // Format is H:i:s (e.g., "14:30:00")
                    $startTime = \Carbon\Carbon::createFromFormat('H:i:s', $timeString);
                }
                
                // Format time in 24-hour format with H notation
                return $startTime->format('G\Hi');
            } catch (\Exception $e) {
                // If parsing fails, return raw time
                return $this->start_time;
            }
        }
        
        return 'Not Set';
    }

    /**
     * Get formatted end time for display
     */
    public function getFormattedEndTimeAttribute()
    {
        if ($this->start_time) {
            // Get class duration in minutes
            $durationMinutes = \App\Models\ClassDuration::getDefaultDuration();
            
            try {
                // Extract time part if it's a datetime string
                $timeString = $this->start_time;
                if (strpos($timeString, ' ') !== false) {
                    $timeString = explode(' ', $timeString)[1]; // Get time part after space
                }
                
                // Parse time (H:i or H:i:s format)
                if (strlen($timeString) === 5) {
                    // Format is H:i (e.g., "14:30")
                    $startTime = \Carbon\Carbon::createFromFormat('H:i', $timeString);
                } else {
                    // Format is H:i:s (e.g., "14:30:00")
                    $startTime = \Carbon\Carbon::createFromFormat('H:i:s', $timeString);
                }
                
                // Calculate end time
                $endTime = $startTime->copy()->addMinutes($durationMinutes);
                
                // Format end time in 24-hour format with H notation
                return $endTime->format('G\Hi');
            } catch (\Exception $e) {
                // If parsing fails, return raw time
                return $this->start_time;
            }
        }
        
        return 'Not Set';
    }

    /**
     * Get formatted time range for display (kept for backward compatibility)
     */
    public function getTimeRangeAttribute()
    {
        return $this->formatted_start_time . ' - ' . $this->formatted_end_time;
    }
}
