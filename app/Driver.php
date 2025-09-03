<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Driver extends Model
{
    protected $fillable = [
        'employee_number',
        'first_name',
        'last_name',
        'phone',
        'email',
        'license_number',
        'license_expiry',
        'license_class',
        'hire_date',
        'status',
        'address',
        'date_of_birth',
        'emergency_contact_name',
        'emergency_contact_phone',
        'notes',
        'photo'
    ];

    protected $dates = [
        'license_expiry',
        'hire_date',
        'date_of_birth'
    ];

    /**
     * Get trip logs for this driver
     */
    public function tripLogs()
    {
        return $this->hasMany(TripLog::class);
    }

    /**
     * Get fuel records for this driver
     */
    public function fuelRecords()
    {
        return $this->hasMany(FuelRecord::class);
    }

    /**
     * Get vehicle assignments
     */
    public function assignments()
    {
        return $this->hasMany(VehicleAssignment::class);
    }

    /**
     * Get current vehicle assignment
     */
    public function currentVehicle()
    {
        return $this->hasOne(VehicleAssignment::class)
                    ->whereNull('unassigned_date')
                    ->where('is_primary', true)
                    ->with('vehicle');
    }

    /**
     * Scope for active drivers
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get full name
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Get name attribute (alias for full_name)
     */
    public function getNameAttribute()
    {
        return $this->getFullNameAttribute();
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
     * Get driver age
     */
    public function getAgeAttribute()
    {
        if (!$this->date_of_birth) return null;
        return Carbon::parse($this->date_of_birth)->age;
    }

    /**
     * Get years of service
     */
    public function getYearsOfServiceAttribute()
    {
        return Carbon::parse($this->hire_date)->diffInYears(now());
    }

    /**
     * Get total trips completed
     */
    public function getTotalTripsAttribute()
    {
        return $this->tripLogs()->where('status', 'completed')->count();
    }

    /**
     * Get total distance driven
     */
    public function getTotalDistanceAttribute()
    {
        return $this->tripLogs()->where('status', 'completed')->sum('distance_km') ?? 0;
    }
}
