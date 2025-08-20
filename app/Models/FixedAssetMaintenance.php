<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedAssetMaintenance extends Model
{
    use HasFactory;

    protected $table = 'fixed_asset_maintenance';

    protected $fillable = [
        'asset_id',
        'type',
        'maintenance_date',
        'performed_by',
        'service_provider',
        'description',
        'cost',
        'status',
        'next_due_date',
        'notes',
        'parts_replaced'
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'next_due_date' => 'date',
        'cost' => 'decimal:2',
        'parts_replaced' => 'array'
    ];

    /**
     * Get the asset that owns the maintenance record.
     */
    public function asset()
    {
        return $this->belongsTo(FixedAsset::class, 'asset_id');
    }

    /**
     * Get the type badge color.
     */
    public function getTypeBadgeColorAttribute()
    {
        return match($this->type) {
            'preventive' => 'primary',
            'corrective' => 'warning',
            'emergency' => 'danger',
            'inspection' => 'info',
            default => 'light'
        };
    }

    /**
     * Get the status badge color.
     */
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            'scheduled' => 'secondary',
            'in_progress' => 'warning',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'light'
        };
    }
}
