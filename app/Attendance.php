<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $fillable = [
        'student_id',
        'subject_allocation_id',
        'attendance_date',
        'class_time',
        'status',
        'notes',
        'recorded_by'
    ];

    protected $dates = [
        'attendance_date',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'class_time' => 'datetime:H:i',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subjectAllocation()
    {
        return $this->belongsTo(SubjectAllocation::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    // Scopes
    public function scopeForDate($query, $date)
    {
        return $query->where('attendance_date', $date);
    }

    public function scopeForSubject($query, $subjectAllocationId)
    {
        return $query->where('subject_allocation_id', $subjectAllocationId);
    }

    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }

    public function scopeLate($query)
    {
        return $query->where('status', 'late');
    }

    public function scopeExcused($query)
    {
        return $query->where('status', 'excused');
    }

    // Helper methods
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'present':
                return 'success';
            case 'absent':
                return 'danger';
            case 'late':
                return 'warning';
            case 'excused':
                return 'info';
            default:
                return 'secondary';
        }
    }

    public function getStatusIconAttribute()
    {
        switch ($this->status) {
            case 'present':
                return 'fa-check-circle';
            case 'absent':
                return 'fa-times-circle';
            case 'late':
                return 'fa-clock';
            case 'excused':
                return 'fa-info-circle';
            default:
                return 'fa-question-circle';
        }
    }

    public function getFormattedDateAttribute()
    {
        return $this->attendance_date->format('d F Y');
    }

    public function getFormattedTimeAttribute()
    {
        return $this->class_time ? Carbon::parse($this->class_time)->format('H:i') : null;
    }

    // Static methods for statistics
    public static function getAttendanceStats($subjectAllocationId, $startDate = null, $endDate = null)
    {
        $query = self::where('subject_allocation_id', $subjectAllocationId);
        
        if ($startDate) {
            $query->where('attendance_date', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('attendance_date', '<=', $endDate);
        }

        return [
            'total' => $query->count(),
            'present' => $query->where('status', 'present')->count(),
            'absent' => $query->where('status', 'absent')->count(),
            'late' => $query->where('status', 'late')->count(),
            'excused' => $query->where('status', 'excused')->count(),
        ];
    }

    public static function getStudentAttendancePercentage($studentId, $subjectAllocationId, $startDate = null, $endDate = null)
    {
        $query = self::where('student_id', $studentId)
                    ->where('subject_allocation_id', $subjectAllocationId);
        
        if ($startDate) {
            $query->where('attendance_date', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('attendance_date', '<=', $endDate);
        }

        $total = $query->count();
        $present = $query->whereIn('status', ['present', 'late'])->count();

        return $total > 0 ? round(($present / $total) * 100, 2) : 0;
    }
}
