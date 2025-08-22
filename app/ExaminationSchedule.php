<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ExaminationSchedule extends Model
{
    protected $fillable = [
        'academic_year_id', 'center_id', 'examination_id', 'subject_id', 'teacher_id',
        'subject_allocation_id', 'venue_id', 'class_duration_id', 'exam_date', 'notes', 'is_active', 'created_by'
    ];

    protected $casts = [
        'exam_date' => 'date',
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

    public function examination()
    {
        return $this->belongsTo(Examination::class, 'examination_id');
    }

    public function subject()
    {
        return $this->belongsTo(Module::class, 'subject_id');
    }

    public function headInvigilator()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
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

    public function scopeForExamination($query, $examinationId)
    {
        return $query->where('examination_id', $examinationId);
    }

    public function scopeForDate($query, $date)
    {
        return $query->where('exam_date', $date);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('exam_date', '>=', Carbon::today());
    }

    public function getHeadInvigilatorNameAttribute()
    {
        if ($this->headInvigilator) {
            $user = $this->headInvigilator;
            $fullName = trim($user->surname . ' ' . $user->other_names);
            return !empty($fullName) ? $fullName : $user->name;
        }
        
        return 'Not Assigned';
    }

    public function getTeacherNameAttribute()
    {
        // First try direct teacher relationship
        if ($this->teacher) {
            $user = $this->teacher;
            $fullName = trim($user->surname . ' ' . $user->other_names);
            return !empty($fullName) ? $fullName : $user->name;
        }
        
        // Fallback to subject allocation if available
        if ($this->subjectAllocation && $this->subjectAllocation->user) {
            $user = $this->subjectAllocation->user;
            $fullName = trim($user->surname . ' ' . $user->other_names);
            return !empty($fullName) ? $fullName : $user->name;
        }
        
        return 'Not Assigned';
    }

    public function getSubjectNameAttribute()
    {
        // First try direct subject relationship
        if ($this->subject) {
            return $this->subject->subject_name;
        }
        
        // Fallback to subject allocation if available
        return $this->subjectAllocation && $this->subjectAllocation->module 
            ? $this->subjectAllocation->module->subject_name 
            : 'Unknown Subject';
    }

    public function getSubjectCodeAttribute()
    {
        // First try direct subject relationship
        if ($this->subject) {
            return $this->subject->subject_code;
        }
        
        // Fallback to subject allocation if available
        return $this->subjectAllocation && $this->subjectAllocation->module 
            ? $this->subjectAllocation->module->subject_code 
            : 'N/A';
    }

    public function getFormattedDateAttribute()
    {
        return $this->exam_date->format('l, F j, Y');
    }

    public function getTimeRangeAttribute()
    {
        return $this->classDuration 
            ? $this->classDuration->time_range 
            : 'Time not set';
    }

    // Check for teacher conflicts
    public static function hasTeacherConflict($subjectAllocationId, $classDurationId, $examDate, $excludeId = null)
    {
        $query = self::where('subject_allocation_id', $subjectAllocationId)
                    ->where('class_duration_id', $classDurationId)
                    ->where('exam_date', $examDate)
                    ->where('is_active', true);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    // Check for venue conflicts
    public static function hasVenueConflict($venueId, $classDurationId, $examDate, $excludeId = null)
    {
        $query = self::where('venue_id', $venueId)
                    ->where('class_duration_id', $classDurationId)
                    ->where('exam_date', $examDate)
                    ->where('is_active', true);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    // Get conflicts for a specific schedule
    public function getConflicts()
    {
        $conflicts = [];

        // Check teacher conflict
        if (self::hasTeacherConflict($this->subject_allocation_id, $this->class_duration_id, $this->exam_date, $this->id)) {
            $conflicts[] = 'Teacher has another exam at the same time';
        }

        // Check venue conflict
        if (self::hasVenueConflict($this->venue_id, $this->class_duration_id, $this->exam_date, $this->id)) {
            $conflicts[] = 'Venue is already booked at this time';
        }

        return $conflicts;
    }

    public function hasConflicts()
    {
        return count($this->getConflicts()) > 0;
    }
}
