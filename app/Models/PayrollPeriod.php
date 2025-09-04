<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PayrollPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_name',
        'start_date',
        'end_date',
        'pay_date',
        'status',
        'description',
        'total_gross_pay',
        'total_deductions',
        'total_net_pay',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'pay_date' => 'date',
        'total_gross_pay' => 'decimal:2',
        'total_deductions' => 'decimal:2',
        'total_net_pay' => 'decimal:2'
    ];

    // Relationships
    public function paySlips()
    {
        return $this->hasMany(PaySlip::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\User::class, 'updated_by');
    }

    public function reports()
    {
        return $this->hasMany(PayrollReport::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'cancelled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    // Helper methods
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => 'secondary',
            'processing' => 'warning',
            'completed' => 'success',
            'cancelled' => 'danger'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function getDurationAttribute()
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    public function getEmployeeCountAttribute()
    {
        return $this->paySlips()->distinct('user_id')->count();
    }

    public function canBeProcessed()
    {
        return in_array($this->status, ['draft', 'processing']);
    }

    public function canBeDeleted()
    {
        return $this->status === 'draft';
    }

    public function calculateTotals()
    {
        $paySlips = $this->paySlips;
        
        $this->total_gross_pay = $paySlips->sum('gross_pay');
        $this->total_deductions = $paySlips->sum('total_deductions');
        $this->total_net_pay = $paySlips->sum('net_pay');
        
        $this->save();
    }
}
