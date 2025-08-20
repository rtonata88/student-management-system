<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedAssetCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color',
        'depreciation_rate',
        'useful_life_years',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
        'depreciation_rate' => 'decimal:2',
        'useful_life_years' => 'integer'
    ];

    /**
     * Get the assets for the category.
     */
    public function assets()
    {
        return $this->hasMany(FixedAsset::class, 'category_id');
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Get the total count of assets in this category.
     */
    public function getTotalAssetsAttribute()
    {
        return $this->assets()->count();
    }

    /**
     * Get the total value of assets in this category.
     */
    public function getTotalValueAttribute()
    {
        return $this->assets()->sum('current_value') ?? $this->assets()->sum('purchase_cost');
    }

    /**
     * Get the active assets count.
     */
    public function getActiveAssetsCountAttribute()
    {
        return $this->assets()->where('status', 'active')->count();
    }
}
