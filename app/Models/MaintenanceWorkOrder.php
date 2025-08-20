<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class MaintenanceWorkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_number',
        'request_id',
        'assigned_to',
        'created_by',
        'title',
        'work_description',
        'status',
        'priority',
        'scheduled_date',
        'started_at',
        'completed_at',
        'actual_cost',
        'hours_spent',
        'materials_used',
        'work_performed',
        'completion_notes',
        'before_photos',
        'after_photos',
        'quality_rating',
        'quality_notes'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'actual_cost' => 'decimal:2',
        'hours_spent' => 'integer',
        'before_photos' => 'array',
        'after_photos' => 'array'
    ];

    // Relationships
    public function request()
    {
        return $this->belongsTo(MaintenanceRequest::class, 'request_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeAssigned($query)
    {
        return $query->where('status', 'assigned');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOverdue($query)
    {
        return $query->where('scheduled_date', '<', now())
                    ->whereNotIn('status', ['completed', 'cancelled']);
    }

    // Accessors
    public function getStatusBadgeColorAttribute()
    {
        $colors = [
            'assigned' => 'info',
            'in_progress' => 'primary',
            'completed' => 'success',
            'cancelled' => 'secondary',
            'on_hold' => 'warning'
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    public function getPriorityBadgeColorAttribute()
    {
        $colors = [
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger',
            'critical' => 'dark'
        ];

        return $colors[$this->priority] ?? 'secondary';
    }

    public function getQualityBadgeColorAttribute()
    {
        $colors = [
            'poor' => 'danger',
            'fair' => 'warning',
            'good' => 'info',
            'excellent' => 'success'
        ];

        return $colors[$this->quality_rating] ?? 'secondary';
    }

    // Boot method to auto-generate work order number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($workOrder) {
            if (empty($workOrder->work_order_number)) {
                $workOrder->work_order_number = 'WO-' . date('Y') . '-' . str_pad(
                    static::whereYear('created_at', date('Y'))->count() + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });
    }
}
