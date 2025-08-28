<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassDuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'duration_minutes'
    ];

    /**
     * Get the default class duration in minutes
     * Returns the first (and should be only) duration setting
     */
    public static function getDefaultDuration()
    {
        $duration = self::first();
        return $duration ? $duration->duration_minutes : 60; // Default to 60 minutes if not set
    }

    /**
     * Set the class duration (creates or updates the single record)
     */
    public static function setDuration($minutes)
    {
        $duration = self::first();
        if ($duration) {
            $duration->update(['duration_minutes' => $minutes]);
        } else {
            self::create(['duration_minutes' => $minutes]);
        }
        return $duration ?: self::first();
    }

    /**
     * Get formatted duration display
     */
    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        if ($hours > 0) {
            return $hours . 'h ' . ($minutes > 0 ? $minutes . 'm' : '');
        }
        return $minutes . ' minutes';
    }
}
