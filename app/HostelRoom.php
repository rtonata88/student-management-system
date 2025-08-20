<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostelRoom extends Model
{
    protected $fillable = [
        'hostel_id', 'block_id', 'room_number', 'room_type', 'floor_number',
        'bed_capacity', 'occupied_beds', 'room_fee', 'has_bathroom', 'has_ac',
        'has_wifi', 'amenities', 'status', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'has_bathroom' => 'boolean',
        'has_ac' => 'boolean',
        'has_wifi' => 'boolean',
        'bed_capacity' => 'integer',
        'occupied_beds' => 'integer',
        'floor_number' => 'integer',
        'room_fee' => 'decimal:2',
        'amenities' => 'array'
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

    public function beds()
    {
        return $this->hasMany(HostelBed::class, 'room_id');
    }

    public function allocations()
    {
        return $this->hasMany(HostelAllocation::class, 'room_id');
    }

    public function maintenance()
    {
        return $this->hasMany(HostelMaintenance::class, 'room_id');
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

    public function scopeByType($query, $type)
    {
        return $query->where('room_type', $type);
    }

    public function scopeByFloor($query, $floor)
    {
        return $query->where('floor_number', $floor);
    }

    // Helper methods
    public function getAvailableBedsCount()
    {
        return $this->beds()->where('status', 'available')->count();
    }

    public function isFullyOccupied()
    {
        return $this->occupied_beds >= $this->bed_capacity;
    }

    public function getRoomDisplayName()
    {
        return $this->block->name . ' - ' . $this->room_number;
    }
}
