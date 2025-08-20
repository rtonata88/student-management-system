<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostelPayment extends Model
{
    protected $fillable = [
        'allocation_id', 'student_id', 'payment_type', 'amount', 'payment_date',
        'due_date', 'payment_method', 'reference_number', 'status', 'remarks', 'received_by'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'due_date' => 'date'
    ];

    // Relationships
    public function allocation()
    {
        return $this->belongsTo(HostelAllocation::class, 'allocation_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    // Scopes
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue');
    }
}
