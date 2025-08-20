<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'requires_approval' => 'boolean',
        'is_active' => 'boolean',
        'max_days_per_year' => 'integer'
    ];

    /**
     * Get leave requests for this leave type.
     */
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    /**
     * Scope to get active leave types only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
