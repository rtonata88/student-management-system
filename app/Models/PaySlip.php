<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PaySlip extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_period_id',
        'user_id',
        'slip_number',
        'basic_salary',
        'gross_pay',
        'total_allowances',
        'total_deductions',
        'tax_amount',
        'net_pay',
        'earnings_breakdown',
        'deductions_breakdown',
        'notes',
        'status',
        'approved_at',
        'paid_at',
        'approved_by',
        'created_by'
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'gross_pay' => 'decimal:2',
        'total_allowances' => 'decimal:2',
        'total_deductions' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'net_pay' => 'decimal:2',
        'earnings_breakdown' => 'array',
        'deductions_breakdown' => 'array',
        'approved_at' => 'datetime',
        'paid_at' => 'datetime'
    ];

    // Relationships
    public function payrollPeriod()
    {
        return $this->belongsTo(PayrollPeriod::class);
    }

    public function employee()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(\App\User::class, 'approved_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeForPeriod($query, $periodId)
    {
        return $query->where('payroll_period_id', $periodId);
    }

    public function scopeForEmployee($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Helper methods
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => 'secondary',
            'approved' => 'success',
            'paid' => 'primary'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function getEmployeeNameAttribute()
    {
        return $this->employee->name ?? 'Unknown Employee';
    }

    public function getEmployeeNumberAttribute()
    {
        $payrollSetting = EmployeePayrollSetting::where('user_id', $this->user_id)->first();
        return $payrollSetting->employee_number ?? 'N/A';
    }

    public function canBeApproved()
    {
        return $this->status === 'draft';
    }

    public function canBePaid()
    {
        return $this->status === 'approved';
    }

    public function approve($approvedBy)
    {
        $this->status = 'approved';
        $this->approved_by = $approvedBy;
        $this->approved_at = now();
        return $this->save();
    }

    public function markAsPaid()
    {
        $this->status = 'paid';
        $this->paid_at = now();
        return $this->save();
    }

    public static function generateSlipNumber($periodId)
    {
        $period = PayrollPeriod::find($periodId);
        $date = $period ? $period->pay_date->format('Ymd') : now()->format('Ymd');
        $count = static::where('payroll_period_id', $periodId)->count() + 1;
        
        return 'PS' . $date . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function getTotalEarningsAttribute()
    {
        if (!$this->earnings_breakdown) return $this->basic_salary;
        
        return collect($this->earnings_breakdown)->sum('amount');
    }

    public function getTotalDeductionsWithTaxAttribute()
    {
        return $this->total_deductions + $this->tax_amount;
    }

    public function getFormattedGrossPayAttribute()
    {
        return 'N$ ' . number_format($this->gross_pay, 2);
    }

    public function getFormattedNetPayAttribute()
    {
        return 'N$ ' . number_format($this->net_pay, 2);
    }

    public function getFormattedTotalDeductionsAttribute()
    {
        return 'N$ ' . number_format($this->total_deductions, 2);
    }

    public function getFormattedTotalEarningsAttribute()
    {
        return 'N$ ' . number_format($this->total_earnings, 2);
    }
}
