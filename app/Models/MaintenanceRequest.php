<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_number',
        'category_id',
        'requested_by',
        'title',
        'description',
        'location',
        'priority',
        'status',
        'requested_date',
        'required_completion_date',
        'estimated_cost',
        'rejection_reason',
        'approved_by',
        'approved_at',
        'attachments',
        'notes'
    ];

    protected $casts = [
        'requested_date' => 'date',
        'required_completion_date' => 'date',
        'approved_at' => 'datetime',
        'estimated_cost' => 'decimal:2',
        'attachments' => 'array'
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(MaintenanceCategory::class, 'category_id');
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function workOrders()
    {
        return $this->hasMany(MaintenanceWorkOrder::class, 'request_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeOverdue($query)
    {
        return $query->where('required_completion_date', '<', now())
                    ->whereNotIn('status', ['completed', 'cancelled']);
    }

    // Accessors
    public function getStatusBadgeColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'approved' => 'info',
            'in_progress' => 'primary',
            'completed' => 'success',
            'cancelled' => 'secondary',
            'rejected' => 'danger'
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

    public function getIsOverdueAttribute()
    {
        return $this->required_completion_date && 
               $this->required_completion_date < now() && 
               !in_array($this->status, ['completed', 'cancelled']);
    }

    public function getDaysUntilDueAttribute()
    {
        if (!$this->required_completion_date) {
            return null;
        }

        return now()->diffInDays($this->required_completion_date, false);
    }

    // Boot method to auto-generate request number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($request) {
            if (empty($request->request_number)) {
                $request->request_number = 'MR-' . date('Y') . '-' . str_pad(
                    static::whereYear('created_at', date('Y'))->count() + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });
    }
}
