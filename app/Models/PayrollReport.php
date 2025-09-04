<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_name',
        'report_type',
        'payroll_period_id',
        'report_date',
        'report_data',
        'file_path',
        'generated_by'
    ];

    protected $casts = [
        'report_date' => 'date',
        'report_data' => 'array'
    ];

    // Relationships
    public function payrollPeriod()
    {
        return $this->belongsTo(PayrollPeriod::class);
    }

    public function generatedBy()
    {
        return $this->belongsTo(\App\User::class, 'generated_by');
    }

    // Scopes
    public function scopeByType($query, $type)
    {
        return $query->where('report_type', $type);
    }

    public function scopeForPeriod($query, $periodId)
    {
        return $query->where('payroll_period_id', $periodId);
    }

    // Helper methods
    public function getTypeBadgeAttribute()
    {
        $badges = [
            'payroll_summary' => 'primary',
            'tax_report' => 'warning',
            'bank_transfer' => 'success',
            'employee_summary' => 'info'
        ];

        return $badges[$this->report_type] ?? 'secondary';
    }

    public function getFormattedSizeAttribute()
    {
        if (!$this->file_path || !file_exists(storage_path('app/' . $this->file_path))) {
            return 'N/A';
        }

        $bytes = filesize(storage_path('app/' . $this->file_path));
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function hasFile()
    {
        return !empty($this->file_path) && file_exists(storage_path('app/' . $this->file_path));
    }
}
