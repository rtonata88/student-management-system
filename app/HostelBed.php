<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostelBed extends Model
{
    protected $fillable = [
        'hostel_id', 'block_id', 'room_id', 'bed_number', 'bed_type',
        'bed_fee', 'status', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'bed_fee' => 'decimal:2'
    ];

    // Relationships
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

    public function allocation()
    {
        return $this->hasOne(HostelAllocation::class, 'bed_id')->where('status', 'active');
    }

    public function allocations()
    {
        return $this->hasMany(HostelAllocation::class, 'bed_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeOccupied($query)
    {
        return $query->where('status', 'occupied');
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->status === 'available' && $this->is_active;
    }

    public function getCurrentStudent()
    {
        return $this->allocation ? $this->allocation->student : null;
    }

    public function getBedDisplayName()
    {
        return $this->room->getRoomDisplayName() . ' - Bed ' . $this->bed_number;
    }
}
