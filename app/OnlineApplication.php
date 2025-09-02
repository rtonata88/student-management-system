<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineApplication extends Model
{
    protected $fillable = [
        'user_id', 'application_number', 'status', 'admin_notes', 
        'submitted_at', 'reviewed_at', 'reviewed_by'
    ];

    protected $dates = [
        'submitted_at', 'reviewed_at', 'created_at', 'updated_at'
    ];

    /**
     * Generate unique application number
     */
    public static function generateApplicationNumber()
    {
        $year = date('Y');
        $lastApplication = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastApplication ? (int)substr($lastApplication->application_number, -4) + 1 : 1;
        
        return 'APP' . $year . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id', 'user_id');
    }

    public function documents()
    {
        return $this->hasMany(ApplicationDocument::class, 'application_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Module::class, 'application_subjects', 'application_id', 'subject_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeUnderReview($query)
    {
        return $query->where('status', 'under_review');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Helper methods
     */
    public function isSubmitted()
    {
        return !is_null($this->submitted_at);
    }

    public function canBeEdited()
    {
        return in_array($this->status, ['pending']) && is_null($this->submitted_at);
    }

    public function getStatusBadgeClass()
    {
        switch ($this->status) {
            case 'pending':
                return 'badge-warning';
            case 'under_review':
                return 'badge-info';
            case 'approved':
                return 'badge-success';
            case 'rejected':
                return 'badge-danger';
            default:
                return 'badge-secondary';
        }
    }

    public function getStatusLabel()
    {
        return ucwords(str_replace('_', ' ', $this->status));
    }
}
