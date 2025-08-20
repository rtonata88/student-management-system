<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostelAllocation extends Model
{
    protected $fillable = [
        'student_id', 'hostel_id', 'block_id', 'room_id', 'bed_id',
        'allocation_date', 'check_in_date', 'check_out_date', 'expected_checkout_date',
        'monthly_fee', 'security_deposit', 'status', 'remarks', 'allocated_by'
    ];

    protected $casts = [
        'allocation_date' => 'date',
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'expected_checkout_date' => 'date',
        'monthly_fee' => 'decimal:2',
        'security_deposit' => 'decimal:2'
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

    public function block()
    {
        return $this->belongsTo(HostelBlock::class, 'block_id');
    }

    public function room()
    {
        return $this->belongsTo(HostelRoom::class, 'room_id');
    }

    public function bed()
    {
        return $this->belongsTo(HostelBed::class, 'bed_id');
    }

    public function allocatedBy()
    {
        return $this->belongsTo(User::class, 'allocated_by');
    }

    public function payments()
    {
        return $this->hasMany(HostelPayment::class, 'allocation_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCheckedIn($query)
    {
        return $query->whereNotNull('check_in_date');
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function getDurationInDays()
    {
        if (!$this->check_in_date) return 0;
        
        $endDate = $this->check_out_date ?: now();
        return $this->check_in_date->diffInDays($endDate);
    }
}
