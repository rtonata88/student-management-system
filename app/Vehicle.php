<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Vehicle extends Model
{
    protected $fillable = [
        'registration_number',
        'make',
        'model',
        'year',
        'color',
        'engine_number',
        'chassis_number',
        'seating_capacity',
        'fuel_capacity',
        'fuel_type',
        'current_odometer',
        'status',
        'purchase_date',
        'purchase_price',
        'insurance_expiry',
        'license_expiry',
        'notes',
        'category_id'
    ];

    protected $dates = [
        'purchase_date',
        'insurance_expiry',
        'license_expiry'
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'fuel_capacity' => 'decimal:2'
    ];

    /**
     * Get the vehicle category
     */
    public function category()
    {
        return $this->belongsTo(VehicleCategory::class, 'category_id');
    }

    /**
     * Get trip logs for this vehicle
     */
    public function tripLogs()
    {
        return $this->hasMany(TripLog::class);
    }

    /**
     * Get fuel records for this vehicle
     */
    public function fuelRecords()
    {
        return $this->hasMany(FuelRecord::class);
    }

    /**
     * Get service records for this vehicle
     */
    public function services()
    {
        return $this->hasMany(VehicleService::class);
    }

    /**
     * Get vehicle assignments
     */
    public function assignments()
    {
        return $this->hasMany(VehicleAssignment::class);
    }

    /**
     * Get current driver assignment
     */
    public function currentDriver()
    {
        return $this->hasOne(VehicleAssignment::class)
                    ->where(function($query) {
                        $query->where('status', 'active')
                              ->orWhere(function($q) {
                                  $q->whereNull('status')
                                    ->whereNull('unassigned_date');
                              });
                    })
                    ->where(function($query) {
                        $query->where('assignment_type', 'primary')
                              ->orWhere('is_primary', true);
                    })
                    ->with('driver');
    }

    /**
     * Scope for active vehicles
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for vehicles needing maintenance
     */
    public function scopeNeedsMaintenance($query)
    {
        return $query->where('status', 'maintenance');
    }

    /**
     * Check if insurance is expiring soon (within 30 days)
     */
    public function getInsuranceExpiringSoonAttribute()
    {
        if (!$this->insurance_expiry) return false;
        return Carbon::parse($this->insurance_expiry)->diffInDays(now()) <= 30;
    }

    /**
     * Check if license is expiring soon (within 30 days)
     */
    public function getLicenseExpiringSoonAttribute()
    {
        if (!$this->license_expiry) return false;
        return Carbon::parse($this->license_expiry)->diffInDays(now()) <= 30;
    }

    /**
     * Get vehicle age in years
     */
    public function getAgeAttribute()
    {
        return now()->year - $this->year;
    }

    /**
     * Get total distance traveled
     */
    public function getTotalDistanceAttribute()
    {
        return $this->tripLogs()->sum('distance_km') ?? 0;
    }

    /**
     * Get total fuel consumed
     */
    public function getTotalFuelConsumedAttribute()
    {
        return $this->fuelRecords()->sum('liters') ?? 0;
    }
}
