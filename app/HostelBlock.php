<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostelBlock extends Model
{
    protected $fillable = [
        'hostel_id', 'name', 'code', 'description', 'floor_count',
        'total_rooms', 'gender', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'floor_count' => 'integer',
        'total_rooms' => 'integer'
    ];

    // Relationships
    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function rooms()
    {
        return $this->hasMany(HostelRoom::class, 'block_id');
    }

    public function beds()
    {
        return $this->hasMany(HostelBed::class, 'block_id');
    }

    public function allocations()
    {
        return $this->hasMany(HostelAllocation::class, 'block_id');
    }

    public function maintenance()
    {
        return $this->hasMany(HostelMaintenance::class, 'block_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    // Helper methods
    public function getAvailableRoomsCount()
    {
        return $this->rooms()->where('status', 'available')->count();
    }

    public function getOccupiedRoomsCount()
    {
        return $this->rooms()->where('status', 'occupied')->count();
    }
}
