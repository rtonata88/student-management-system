<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FixedAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_tag',
        'name',
        'description',
        'category_id',
        'brand',
        'model',
        'serial_number',
        'purchase_cost',
        'purchase_date',
        'supplier',
        'warranty_period',
        'warranty_expiry',
        'location',
        'department',
        'assigned_to',
        'condition',
        'status',
        'current_value',
        'accumulated_depreciation',
        'last_maintenance',
        'next_maintenance',
        'specifications',
        'notes'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_expiry' => 'date',
        'last_maintenance' => 'date',
        'next_maintenance' => 'date',
        'purchase_cost' => 'decimal:2',
        'current_value' => 'decimal:2',
        'accumulated_depreciation' => 'decimal:2',
        'specifications' => 'array'
    ];

    /**
     * Get the category that owns the asset.
     */
    public function category()
    {
        return $this->belongsTo(FixedAssetCategory::class, 'category_id');
    }

    /**
     * Get the maintenance records for the asset.
     */
    public function maintenanceRecords()
    {
        return $this->hasMany(FixedAssetMaintenance::class, 'asset_id');
    }

    /**
     * Scope a query to only include active assets.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include assets needing maintenance.
     */
    public function scopeMaintenanceDue($query)
    {
        return $query->where('next_maintenance', '<=', Carbon::now()->addDays(30));
    }

    /**
     * Scope a query to only include assets with expired warranty.
     */
    public function scopeWarrantyExpired($query)
    {
        return $query->where('warranty_expiry', '<', Carbon::now());
    }

    /**
     * Get the asset's depreciation status.
     */
    public function getDepreciationStatusAttribute()
    {
        if (!$this->category || !$this->category->depreciation_rate) {
            return 'No depreciation';
        }

        $yearsOwned = Carbon::parse($this->purchase_date)->diffInYears(Carbon::now());
        $totalDepreciation = ($this->purchase_cost * $this->category->depreciation_rate / 100) * $yearsOwned;
        
        return min($totalDepreciation, $this->purchase_cost);
    }

    /**
     * Get the asset's current book value.
     */
    public function getBookValueAttribute()
    {
        return $this->purchase_cost - $this->accumulated_depreciation;
    }

    /**
     * Check if warranty is expiring soon.
     */
    public function getIsWarrantyExpiringSoonAttribute()
    {
        if (!$this->warranty_expiry) return false;
        return Carbon::parse($this->warranty_expiry)->isBetween(Carbon::now(), Carbon::now()->addDays(90));
    }

    /**
     * Check if warranty is expired.
     */
    public function getIsWarrantyExpiredAttribute()
    {
        if (!$this->warranty_expiry) return false;
        return Carbon::parse($this->warranty_expiry)->isPast();
    }

    /**
     * Check if maintenance is due.
     */
    public function getIsMaintenanceDueAttribute()
    {
        if (!$this->next_maintenance) return false;
        return Carbon::parse($this->next_maintenance)->isPast();
    }

    /**
     * Check if maintenance is due soon.
     */
    public function getIsMaintenanceDueSoonAttribute()
    {
        if (!$this->next_maintenance) return false;
        return Carbon::parse($this->next_maintenance)->isBetween(Carbon::now(), Carbon::now()->addDays(30));
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            'active' => 'success',
            'inactive' => 'secondary',
            'maintenance' => 'warning',
            'disposed' => 'dark',
            'lost', 'stolen' => 'danger',
            default => 'light'
        };
    }

    /**
     * Get condition badge color.
     */
    public function getConditionBadgeColorAttribute()
    {
        return match($this->condition) {
            'excellent' => 'success',
            'good' => 'primary',
            'fair' => 'warning',
            'poor' => 'danger',
            'damaged' => 'dark',
            default => 'light'
        };
    }
}
