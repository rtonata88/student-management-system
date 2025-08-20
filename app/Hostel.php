<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    protected $fillable = [
        'name', 'code', 'description', 'address', 'phone', 'email',
        'warden_name', 'warden_phone', 'total_capacity', 'gender', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'total_capacity' => 'integer'
    ];

    // Relationships
    public function blocks()
    {
        return $this->hasMany(HostelBlock::class);
    }

    public function rooms()
    {
        return $this->hasMany(HostelRoom::class);
    }

    public function beds()
    {
        return $this->hasMany(HostelBed::class);
    }

    public function allocations()
    {
        return $this->hasMany(HostelAllocation::class);
    }

    public function feeStructures()
    {
        return $this->hasMany(HostelFeeStructure::class);
    }

    public function maintenance()
    {
        return $this->hasMany(HostelMaintenance::class);
    }

    public function visitors()
    {
        return $this->hasMany(HostelVisitor::class);
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
    public function getAvailableBedsCount()
    {
        return $this->beds()->where('status', 'available')->count();
    }

    public function getOccupiedBedsCount()
    {
        return $this->beds()->where('status', 'occupied')->count();
    }

    public function getOccupancyRate()
    {
        $totalBeds = $this->beds()->count();
        if ($totalBeds == 0) return 0;
        
        $occupiedBeds = $this->getOccupiedBedsCount();
        return round(($occupiedBeds / $totalBeds) * 100, 2);
    }
}
