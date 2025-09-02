<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_name',
        'subject_code',
        'description',
        'credits',
        'subject_fees',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the subject allocations for this subject.
     */
    public function allocations()
    {
        return $this->hasMany(SubjectAllocation::class);
    }

    /**
     * Get the online applications that selected this subject.
     */
    public function onlineApplications()
    {
        return $this->belongsToMany(OnlineApplication::class, 'online_application_subjects');
    }

    /**
     * Scope a query to only include active subjects.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
