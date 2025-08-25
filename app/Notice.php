<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'category',
        'title',
        'short_description',
        'body',
        'publish',
        'target_campus',
        'attachments',
        'created_by'
    ];

    protected $casts = [
        'attachments' => 'array',
        'publish' => 'boolean'
    ];

    /**
     * Get the user who created the notice
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope for published notices
     */
    public function scopePublished($query)
    {
        return $query->where('publish', true);
    }

    /**
     * Scope for notices by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get formatted created date
     */
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d M Y');
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        return $this->publish ? 'badge-success' : 'badge-warning';
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        return $this->publish ? 'Published' : 'Draft';
    }

    /**
     * Get category badge class
     */
    public function getCategoryBadgeAttribute()
    {
        $badges = [
            'Announcement' => 'badge-primary',
            'Deadline' => 'badge-danger',
            'Information' => 'badge-info',
            'Event' => 'badge-success',
            'Academic' => 'badge-warning'
        ];

        return $badges[$this->category] ?? 'badge-secondary';
    }
}
