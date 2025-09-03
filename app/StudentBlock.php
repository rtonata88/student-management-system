<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StudentBlock extends Model
{
    protected $fillable = [
        'student_id',
        'student_number',
        'reason',
        'block_amount',
        'batch_number',
        'is_exception',
        'is_active',
        'blocked_by',
        'blocked_at',
        'unblocked_by',
        'unblocked_at'
    ];

    protected $dates = [
        'blocked_at',
        'unblocked_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'is_exception' => 'boolean',
        'is_active' => 'boolean',
        'block_amount' => 'decimal:2'
    ];

    /**
     * Relationship to Student model
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relationship to User who blocked the student
     */
    public function blockedBy()
    {
        return $this->belongsTo(User::class, 'blocked_by');
    }

    /**
     * Relationship to User who unblocked the student
     */
    public function unblockedBy()
    {
        return $this->belongsTo(User::class, 'unblocked_by');
    }

    /**
     * Scope for active blocks
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for inactive blocks
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope for exceptions
     */
    public function scopeExceptions($query)
    {
        return $query->where('is_exception', true);
    }

    /**
     * Scope for non-exceptions
     */
    public function scopeNonExceptions($query)
    {
        return $query->where('is_exception', false);
    }

    /**
     * Check if student is currently blocked
     */
    public static function isStudentBlocked($studentId)
    {
        return self::where('student_id', $studentId)
                   ->where('is_active', true)
                   ->where('is_exception', false)
                   ->exists();
    }

    /**
     * Check if student has block exception
     */
    public static function hasBlockException($studentId)
    {
        return self::where('student_id', $studentId)
                   ->where('is_exception', true)
                   ->where('is_active', true)
                   ->exists();
    }

    /**
     * Get formatted blocked date
     */
    public function getFormattedBlockedAtAttribute()
    {
        return $this->blocked_at ? $this->blocked_at->format('Y-m-d H:i:s') : null;
    }

    /**
     * Get formatted unblocked date
     */
    public function getFormattedUnblockedAtAttribute()
    {
        return $this->unblocked_at ? $this->unblocked_at->format('Y-m-d H:i:s') : null;
    }

    /**
     * Get block status text
     */
    public function getStatusTextAttribute()
    {
        if ($this->is_exception) {
            return 'Exception';
        }
        
        return $this->is_active ? 'Blocked' : 'Unblocked';
    }

    /**
     * Generate batch number
     */
    public static function generateBatchNumber()
    {
        $date = Carbon::now()->format('ymd');
        $random = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        return $date . $random;
    }
}
