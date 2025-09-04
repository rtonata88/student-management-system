<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePayrollSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_number',
        'basic_salary',
        'pay_frequency',
        'bank_name',
        'account_number',
        'account_type',
        'tax_number',
        'tax_rate',
        'allowances',
        'deductions',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'allowances' => 'array',
        'deductions' => 'array',
        'is_active' => 'boolean'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\User::class, 'updated_by');
    }

    public function paySlips()
    {
        return $this->hasMany(PaySlip::class, 'user_id', 'user_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByPayFrequency($query, $frequency)
    {
        return $query->where('pay_frequency', $frequency);
    }

    // Helper methods
    public function getFullNameAttribute()
    {
        return $this->user->name ?? 'Unknown Employee';
    }

    public function getTotalAllowancesAttribute()
    {
        if (!$this->allowances) return 0;
        
        return collect($this->allowances)->sum('amount');
    }

    public function getTotalDeductionsAttribute()
    {
        if (!$this->deductions) return 0;
        
        return collect($this->deductions)->sum('amount');
    }

    public function calculateGrossPay()
    {
        return $this->basic_salary + $this->getTotalAllowancesAttribute();
    }

    public function calculateTaxAmount($grossPay = null)
    {
        $taxableAmount = $grossPay ?? $this->calculateGrossPay();
        return ($taxableAmount * $this->tax_rate) / 100;
    }

    public function calculateNetPay()
    {
        $grossPay = $this->calculateGrossPay();
        $totalDeductions = $this->getTotalDeductionsAttribute() + $this->calculateTaxAmount($grossPay);
        
        return $grossPay - $totalDeductions;
    }

    public function hasCompletePayrollInfo()
    {
        return !empty($this->bank_name) && 
               !empty($this->account_number) && 
               !empty($this->basic_salary);
    }

    public function hasBankingInfo()
    {
        return !empty($this->bank_name) && !empty($this->account_number);
    }

    public function getFormattedSalaryAttribute()
    {
        return 'N$ ' . number_format($this->basic_salary, 2);
    }

    public function getFormattedGrossPayAttribute()
    {
        return 'N$ ' . number_format($this->calculateGrossPay(), 2);
    }

    public function getFormattedNetPayAttribute()
    {
        return 'N$ ' . number_format($this->calculateNetPay(), 2);
    }
}
