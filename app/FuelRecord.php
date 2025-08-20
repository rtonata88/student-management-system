<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuelRecord extends Model
{
    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'fuel_date',
        'liters',
        'cost_per_liter',
        'total_cost',
        'odometer_reading',
        'fuel_station',
        'receipt_number',
        'notes'
    ];

    protected $dates = [
        'fuel_date'
    ];

    protected $casts = [
        'liters' => 'decimal:2',
        'cost_per_liter' => 'decimal:2',
        'total_cost' => 'decimal:2'
    ];

    /**
     * Get the vehicle for this fuel record
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the driver for this fuel record
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Calculate total cost automatically
     */
    public function setCostPerLiterAttribute($value)
    {
        $this->attributes['cost_per_liter'] = $value;
        
        if ($value && $this->liters) {
            $this->attributes['total_cost'] = $value * $this->liters;
        }
    }

    /**
     * Calculate total cost automatically
     */
    public function setLitersAttribute($value)
    {
        $this->attributes['liters'] = $value;
        
        if ($value && $this->cost_per_liter) {
            $this->attributes['total_cost'] = $value * $this->cost_per_liter;
        }
    }

    /**
     * Scope for records within date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('fuel_date', [$startDate, $endDate]);
    }

    /**
     * Scope for records by vehicle
     */
    public function scopeByVehicle($query, $vehicleId)
    {
        return $query->where('vehicle_id', $vehicleId);
    }
}
