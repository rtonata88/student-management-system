<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostelVisitor extends Model
{
    protected $fillable = [
        'student_id', 'hostel_id', 'visitor_name', 'visitor_phone', 'relationship',
        'visit_date', 'check_in_time', 'check_out_time', 'purpose', 'status',
        'approved_by', 'remarks'
    ];

    protected $casts = [
        'visit_date' => 'datetime',
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime'
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeCheckedIn($query)
    {
        return $query->where('status', 'checked_in');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('visit_date', today());
    }
}
