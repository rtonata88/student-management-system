<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleAssignment extends Model
{
    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'assignment_type',
        'start_date',
        'end_date',
        'status',
        'notes',
        // Legacy fields for backward compatibility
        'assigned_date',
        'unassigned_date',
        'is_primary'
    ];

    protected $dates = [
        'start_date',
        'end_date',
        // Legacy fields for backward compatibility
        'assigned_date',
        'unassigned_date'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    /**
     * Get the vehicle for this assignment
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the driver for this assignment
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Scope for active assignments
     */
    public function scopeActive($query)
    {
        return $query->whereNull('unassigned_date');
    }

    /**
     * Scope for primary assignments
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Check if assignment is currently active
     */
    public function getIsActiveAttribute()
    {
        // Check new status field first, fallback to legacy logic
        if ($this->status) {
            return $this->status === 'active';
        }
        
        // Legacy logic for backward compatibility
        return is_null($this->unassigned_date);
    }

    /**
     * Check if assignment is currently active (method version)
     */
    public function isActive()
    {
        return $this->getIsActiveAttribute();
    }
}
