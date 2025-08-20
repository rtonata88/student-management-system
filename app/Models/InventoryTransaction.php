<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'transaction_type',
        'quantity',
        'unit_cost',
        'total_cost',
        'reference_number',
        'notes',
        'performed_by',
        'transaction_date',
        'supplier',
        'recipient',
        'location_from',
        'location_to'
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'transaction_date' => 'datetime',
    ];

    /**
     * Get the inventory item that owns the transaction.
     */
    public function item()
    {
        return $this->belongsTo(InventoryItem::class, 'item_id');
    }

    /**
     * Scope a query to only include incoming transactions.
     */
    public function scopeIncoming($query)
    {
        return $query->where('transaction_type', 'in');
    }

    /**
     * Scope a query to only include outgoing transactions.
     */
    public function scopeOutgoing($query)
    {
        return $query->where('transaction_type', 'out');
    }

    /**
     * Scope a query to only include adjustments.
     */
    public function scopeAdjustments($query)
    {
        return $query->where('transaction_type', 'adjustment');
    }

    /**
     * Scope a query to only include transfers.
     */
    public function scopeTransfers($query)
    {
        return $query->where('transaction_type', 'transfer');
    }

    /**
     * Get transaction type badge color for UI.
     */
    public function getTransactionTypeBadgeAttribute()
    {
        switch ($this->transaction_type) {
            case 'in':
                return 'success';
            case 'out':
                return 'danger';
            case 'adjustment':
                return 'warning';
            case 'transfer':
                return 'info';
            default:
                return 'secondary';
        }
    }

    /**
     * Get formatted transaction type for display.
     */
    public function getFormattedTransactionTypeAttribute()
    {
        switch ($this->transaction_type) {
            case 'in':
                return 'Stock In';
            case 'out':
                return 'Stock Out';
            case 'adjustment':
                return 'Adjustment';
            case 'transfer':
                return 'Transfer';
            default:
                return ucfirst($this->transaction_type);
        }
    }
}
