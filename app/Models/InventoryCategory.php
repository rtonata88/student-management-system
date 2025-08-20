<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the inventory items for the category.
     */
    public function items()
    {
        return $this->hasMany(InventoryItem::class, 'category_id');
    }

    /**
     * Get active inventory items for the category.
     */
    public function activeItems()
    {
        return $this->hasMany(InventoryItem::class, 'category_id')->where('status', 'active');
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the total number of items in this category.
     */
    public function getTotalItemsAttribute()
    {
        return $this->items()->count();
    }

    /**
     * Get the total stock value for this category.
     */
    public function getTotalValueAttribute()
    {
        return $this->items()->sum(\DB::raw('quantity_in_stock * unit_cost'));
    }
}
