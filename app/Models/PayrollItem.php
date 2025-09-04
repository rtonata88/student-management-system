<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'item_code',
        'item_type',
        'calculation_method',
        'default_amount',
        'percentage_rate',
        'formula',
        'is_taxable',
        'is_active',
        'description',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'default_amount' => 'decimal:2',
        'percentage_rate' => 'decimal:2',
        'is_taxable' => 'boolean',
        'is_active' => 'boolean'
    ];

    // Relationships
    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\User::class, 'updated_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeEarnings($query)
    {
        return $query->where('item_type', 'earning');
    }

    public function scopeDeductions($query)
    {
        return $query->where('item_type', 'deduction');
    }

    public function scopeAllowances($query)
    {
        return $query->where('item_type', 'allowance');
    }

    public function scopeTaxes($query)
    {
        return $query->where('item_type', 'tax');
    }

    public function scopeTaxable($query)
    {
        return $query->where('is_taxable', true);
    }

    // Helper methods
    public function getTypeBadgeAttribute()
    {
        $badges = [
            'earning' => 'success',
            'deduction' => 'danger',
            'allowance' => 'info',
            'tax' => 'warning'
        ];

        return $badges[$this->item_type] ?? 'secondary';
    }

    public function getCalculationDisplayAttribute()
    {
        switch ($this->calculation_method) {
            case 'fixed':
                return 'Fixed Amount: ' . number_format($this->default_amount, 2);
            case 'percentage':
                return 'Percentage: ' . $this->percentage_rate . '%';
            case 'hourly':
                return 'Hourly Rate: ' . number_format($this->default_amount, 2);
            case 'formula':
                return 'Formula: ' . $this->formula;
            default:
                return 'Not Set';
        }
    }

    public function calculateAmount($basicSalary, $grossPay = null, $hoursWorked = null)
    {
        switch ($this->calculation_method) {
            case 'fixed':
                return $this->default_amount;
            
            case 'percentage':
                $baseAmount = $grossPay ?? $basicSalary;
                return ($baseAmount * $this->percentage_rate) / 100;
            
            case 'hourly':
                return $this->default_amount * ($hoursWorked ?? 0);
            
            case 'formula':
                // Simple formula evaluation - can be extended
                $formula = str_replace(
                    ['basic_salary', 'gross_pay'],
                    [$basicSalary, $grossPay ?? $basicSalary],
                    $this->formula
                );
                
                try {
                    return eval("return $formula;");
                } catch (Exception $e) {
                    return 0;
                }
            
            default:
                return 0;
        }
    }
}
