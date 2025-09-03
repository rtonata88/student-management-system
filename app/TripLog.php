<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TripLog extends Model
{
    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'trip_purpose',
        'destination',
        'departure_time',
        'expected_return_time',
        'arrival_time',
        'odometer_start',
        'odometer_end',
        'distance_km',
        'fuel_type',
        'fuel_liters',
        'price_per_liter',
        'total_fuel_cost',
        'fuel_station',
        'fuel_town_city',
        'receipt_number',
        'passenger_count',
        'fuel_filled_up',
        'fuel_receipt_path',
        'notes',
        'status'
    ];

    protected $dates = [
        'departure_time',
        'expected_return_time',
        'arrival_time'
    ];

    protected $casts = [
        'fuel_consumed' => 'decimal:2'
    ];

    /**
     * Get the vehicle for this trip
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the driver for this trip
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Calculate distance automatically when odometer readings are set
     */
    public function setOdometerEndAttribute($value)
    {
        $this->attributes['odometer_end'] = $value;
        
        if ($value && $this->odometer_start) {
            $this->attributes['distance_km'] = $value - $this->odometer_start;
        }
    }

    /**
     * Get trip duration in hours
     */
    public function getTripDurationAttribute()
    {
        if (!$this->departure_time || !$this->arrival_time) return null;
        
        return Carbon::parse($this->departure_time)->diffInHours(Carbon::parse($this->arrival_time));
    }

    /**
     * Get fuel efficiency (km per liter)
     */
    public function getFuelEfficiencyAttribute()
    {
        if (!$this->distance_km || !$this->fuel_consumed || $this->fuel_consumed == 0) return null;
        
        return round($this->distance_km / $this->fuel_consumed, 2);
    }

    /**
     * Scope for completed trips
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for ongoing trips
     */
    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    /**
     * Scope for trips within date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('departure_time', [$startDate, $endDate]);
    }
}
