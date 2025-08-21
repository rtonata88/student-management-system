<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassDuration extends Model
{
    protected $fillable = [
        'period_name', 'start_time', 'end_time', 'duration_minutes',
        'day_type', 'is_break', 'sort_order', 'is_active'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_break' => 'boolean',
        'is_active' => 'boolean',
        'duration_minutes' => 'integer',
        'sort_order' => 'integer'
    ];

    public function classSchedules()
    {
        return $this->hasMany(ClassSchedule::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeNotBreak($query)
    {
        return $query->where('is_break', false);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('start_time');
    }

    public function getTimeRangeAttribute()
    {
        return $this->start_time->format('H:i') . ' - ' . $this->end_time->format('H:i');
    }

    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        if ($hours > 0 && $minutes > 0) {
            return "{$hours}h {$minutes}m";
        } elseif ($hours > 0) {
            return "{$hours}h";
        } else {
            return "{$minutes}m";
        }
    }
}
