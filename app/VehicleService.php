<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleService extends Model
{
    protected $fillable = [
        'vehicle_id',
        'service_type',
        'service_description',
        'service_date',
        'odometer_reading',
        'cost',
        'service_provider',
        'next_service_date',
        'next_service_odometer',
        'parts_replaced',
        'notes',
        'status'
    ];

    protected $dates = [
        'service_date',
        'next_service_date'
    ];

    protected $casts = [
        'cost' => 'decimal:2'
    ];

    /**
     * Get the vehicle for this service
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Scope for completed services
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for scheduled services
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    /**
     * Scope for services within date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('service_date', [$startDate, $endDate]);
    }

    /**
     * Scope for services by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('service_type', $type);
    }
}
