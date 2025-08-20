<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'leave_type_id',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'status',
        'admin_comments',
        'approved_by',
        'approved_at',
        'created_by',
        'is_half_day',
        'half_day_period',
        'attachment'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
        'is_half_day' => 'boolean',
        'total_days' => 'integer'
    ];

    /**
     * Get the user who requested the leave.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the leave type.
     */
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

    /**
     * Get the user who approved the leave.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the user who created the leave (for admin-created leaves).
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to get pending leave requests.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get approved leave requests.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope to get rejected leave requests.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Get status badge class for UI.
     */
    public function getStatusBadgeClassAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'badge-warning';
            case 'approved':
                return 'badge-success';
            case 'rejected':
                return 'badge-danger';
            case 'cancelled':
                return 'badge-secondary';
            default:
                return 'badge-secondary';
        }
    }

    /**
     * Get formatted status for display.
     */
    public function getFormattedStatusAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * Get duration in days as a formatted string.
     */
    public function getDurationAttribute()
    {
        if ($this->is_half_day) {
            return '0.5 day (' . ucfirst($this->half_day_period) . ')';
        }
        
        return $this->total_days . ' day' . ($this->total_days > 1 ? 's' : '');
    }

    /**
     * Check if leave is currently active.
     */
    public function getIsActiveAttribute()
    {
        $today = Carbon::today();
        return $this->status === 'approved' && 
               $this->start_date <= $today && 
               $this->end_date >= $today;
    }
}
