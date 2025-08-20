<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color',
        'priority_level',
        'expected_completion_hours',
        'requires_approval',
        'active'
    ];

    protected $casts = [
        'requires_approval' => 'boolean',
        'active' => 'boolean',
        'expected_completion_hours' => 'integer'
    ];

    // Relationships
    public function requests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'category_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority_level', $priority);
    }

    // Accessors
    public function getTotalRequestsAttribute()
    {
        return $this->requests()->count();
    }

    public function getPendingRequestsAttribute()
    {
        return $this->requests()->where('status', 'pending')->count();
    }

    public function getCompletedRequestsAttribute()
    {
        return $this->requests()->where('status', 'completed')->count();
    }

    public function getPriorityBadgeColorAttribute()
    {
        $colors = [
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger',
            'critical' => 'dark'
        ];

        return $colors[$this->priority_level] ?? 'secondary';
    }
}
