<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_code',
        'name',
        'description',
        'category_id',
        'unit_of_measure',
        'unit_cost',
        'quantity_in_stock',
        'minimum_stock_level',
        'maximum_stock_level',
        'supplier',
        'location',
        'expiry_date',
        'barcode',
        'specifications',
        'status'
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'expiry_date' => 'date',
        'specifications' => 'array',
    ];

    /**
     * Get the category that owns the inventory item.
     */
    public function category()
    {
        return $this->belongsTo(InventoryCategory::class, 'category_id');
    }

    /**
     * Get the transactions for the inventory item.
     */
    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class, 'item_id');
    }

    /**
     * Get recent transactions for the inventory item.
     */
    public function recentTransactions()
    {
        return $this->hasMany(InventoryTransaction::class, 'item_id')
                    ->orderBy('transaction_date', 'desc')
                    ->limit(10);
    }

    /**
     * Scope a query to only include active items.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include low stock items.
     */
    public function scopeLowStock($query)
    {
        return $query->whereRaw('quantity_in_stock < minimum_stock_level');
    }

    /**
     * Scope a query to only include expired items.
     */
    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', now());
    }

    /**
     * Scope a query to only include items expiring soon.
     */
    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->whereBetween('expiry_date', [now(), now()->addDays($days)]);
    }

    /**
     * Get the total value of this item in stock.
     */
    public function getTotalValueAttribute()
    {
        return $this->quantity_in_stock * $this->unit_cost;
    }

    /**
     * Check if item is low on stock.
     */
    public function getIsLowStockAttribute()
    {
        return $this->quantity_in_stock < $this->minimum_stock_level;
    }

    /**
     * Check if item is expired.
     */
    public function getIsExpiredAttribute()
    {
        return $this->expiry_date && $this->expiry_date < now();
    }

    /**
     * Check if item is expiring soon.
     */
    public function getIsExpiringSoonAttribute()
    {
        return $this->expiry_date && $this->expiry_date <= now()->addDays(30);
    }

    /**
     * Get stock status color for UI.
     */
    public function getStockStatusColorAttribute()
    {
        if ($this->is_expired) {
            return 'danger';
        } elseif ($this->is_expiring_soon) {
            return 'warning';
        } elseif ($this->is_low_stock) {
            return 'warning';
        }
        return 'success';
    }

    /**
     * Get stock status text.
     */
    public function getStockStatusTextAttribute()
    {
        if ($this->is_expired) {
            return 'Expired';
        } elseif ($this->is_expiring_soon) {
            return 'Expiring Soon';
        } elseif ($this->is_low_stock) {
            return 'Low Stock';
        }
        return 'In Stock';
    }
}
