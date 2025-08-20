<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostelFeeStructure extends Model
{
    protected $fillable = [
        'hostel_id', 'fee_type', 'room_type', 'amount', 'security_deposit',
        'description', 'effective_from', 'effective_to', 'is_active'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'security_deposit' => 'decimal:2',
        'effective_from' => 'date',
        'effective_to' => 'date',
        'is_active' => 'boolean'
    ];

    // Relationships
    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCurrent($query)
    {
        return $query->where('effective_from', '<=', now())
                    ->where(function($q) {
                        $q->whereNull('effective_to')
                          ->orWhere('effective_to', '>=', now());
                    });
    }
}
