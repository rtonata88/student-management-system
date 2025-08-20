<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostelMaintenance extends Model
{
    protected $fillable = [
        'hostel_id', 'block_id', 'room_id', 'maintenance_type', 'description',
        'priority', 'reported_date', 'scheduled_date', 'completed_date',
        'estimated_cost', 'actual_cost', 'status', 'reported_by', 'assigned_to', 'remarks'
    ];

    protected $casts = [
        'reported_date' => 'date',
        'scheduled_date' => 'date',
        'completed_date' => 'date',
        'estimated_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2'
    ];

    // Relationships
    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function block()
    {
        return $this->belongsTo(HostelBlock::class, 'block_id');
    }

    public function room()
    {
        return $this->belongsTo(HostelRoom::class, 'room_id');
    }

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->whereIn('status', ['reported', 'scheduled']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }
}
