<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'max_days_per_year',
        'requires_approval',
        'is_active',
        'color'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'requires_approval' => 'boolean',
        'max_days_per_year' => 'integer'
    ];

    /**
     * Scope to get only active leave types
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get only inactive leave types
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Get the status display text
     */
    public function getStatusDisplayAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }

    /**
     * Get the approval requirement display text
     */
    public function getApprovalDisplayAttribute()
    {
        return $this->requires_approval ? 'Required' : 'Not Required';
    }

    /**
     * Get formatted max days display
     */
    public function getMaxDaysDisplayAttribute()
    {
        if ($this->max_days_per_year === null) {
            return 'Unlimited';
        }
        return $this->max_days_per_year . ' days/year';
    }
}
