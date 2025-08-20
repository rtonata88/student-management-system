<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuelRecord extends Model
{
    protected $fillable = [
        'vehicle_id',
        'date',
        'fuel_type',
        'quantity',
        'price_per_liter',
        'total_cost',
        'odometer_reading',
        'fuel_station',
        'receipt_number',
        'notes'
    ];

    protected $dates = [
        'date'
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'price_per_liter' => 'decimal:2',
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
    public function setPricePerliterAttribute($value)
    {
        $this->attributes['price_per_liter'] = $value;
        
        if ($value && $this->quantity) {
            $this->attributes['total_cost'] = $value * $this->quantity;
        }
    }

    /**
     * Calculate total cost automatically
     */
    public function setQuantityAttribute($value)
    {
        $this->attributes['quantity'] = $value;
        
        if ($value && $this->price_per_liter) {
            $this->attributes['total_cost'] = $value * $this->price_per_liter;
        }
    }

    /**
     * Scope for records within date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope for records by vehicle
     */
    public function scopeByVehicle($query, $vehicleId)
    {
        return $query->where('vehicle_id', $vehicleId);
    }
}
