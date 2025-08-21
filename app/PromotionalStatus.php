<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionalStatus extends Model
{
    protected $table = 'promotional_statuses';
    
    protected $fillable = [
        'promoted',
        'description',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Scope to get only active promotional statuses
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope to get only promoted statuses
     */
    public function scopePromoted($query)
    {
        return $query->where('promoted', 'Yes');
    }

    /**
     * Scope to get only non-promoted statuses
     */
    public function scopeNotPromoted($query)
    {
        return $query->where('promoted', 'No');
    }

    /**
     * Get the promoted status as a badge class
     */
    public function getPromotedBadgeAttribute()
    {
        return $this->promoted === 'Yes' ? 'badge-success' : 'badge-danger';
    }

    /**
     * Get the promoted status display text
     */
    public function getPromotedDisplayAttribute()
    {
        return $this->promoted;
    }
}
