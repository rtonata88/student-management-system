<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostelAllocation extends Model
{
    protected $fillable = [
        'student_id', 'hostel_id', 'block_id', 'room_id', 'bed_id',
        'allocation_date', 'check_in_date', 'check_out_date', 'expected_checkout_date',
        'monthly_fee', 'security_deposit', 'status', 'remarks', 'allocated_by'
    ];

    protected $casts = [
        'allocation_date' => 'date',
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'expected_checkout_date' => 'date',
        'monthly_fee' => 'decimal:2',
        'security_deposit' => 'decimal:2'
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function block()
    {
        return $this->belongsTo(HostelBlock::class, 'block_id');
    }

    public function room()
    {
        return $this->belongsTo(HostelRoom::class, 'room_id');
    }

    public function bed()
    {
        return $this->belongsTo(HostelBed::class, 'bed_id');
    }

    public function allocatedBy()
    {
        return $this->belongsTo(User::class, 'allocated_by');
    }

    public function payments()
    {
        return $this->hasMany(HostelPayment::class, 'allocation_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCheckedIn($query)
    {
        return $query->whereNotNull('check_in_date');
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function getDurationInDays()
    {
        if (!$this->check_in_date) return 0;
        
        $endDate = $this->check_out_date ?: now();
        return $this->check_in_date->diffInDays($endDate);
    }

    // Payment calculation methods
    public function getTotalPaidAmount()
    {
        return $this->payments()->where('status', 'paid')->sum('amount');
    }

    public function getPendingPayments()
    {
        return $this->payments()->where('status', 'pending')->get();
    }

    public function getOverduePayments()
    {
        return $this->payments()->where('status', 'overdue')->get();
    }

    public function calculateMonthlyDue($month = null, $year = null)
    {
        $month = $month ?: now()->month;
        $year = $year ?: now()->year;
        
        // Check if already paid for this month
        $existingPayment = $this->payments()
            ->where('payment_type', 'monthly_fee')
            ->whereMonth('due_date', $month)
            ->whereYear('due_date', $year)
            ->first();
            
        if ($existingPayment && $existingPayment->status === 'paid') {
            return 0;
        }
        
        return $this->monthly_fee;
    }

    public function getTotalOutstandingAmount()
    {
        $monthsOccupied = $this->getMonthsOccupied();
        $totalDue = $monthsOccupied * $this->monthly_fee;
        $totalPaid = $this->getTotalPaidAmount();
        
        return max(0, $totalDue - $totalPaid);
    }

    public function getMonthsOccupied()
    {
        if (!$this->allocation_date) return 0;
        
        $startDate = $this->allocation_date;
        $endDate = $this->check_out_date ?: now();
        
        return $startDate->diffInMonths($endDate) + 1; // +1 to include current month
    }

    public function generateMonthlyPayments()
    {
        $startDate = $this->allocation_date;
        $endDate = $this->expected_checkout_date ?: now()->addYear();
        
        $currentDate = $startDate->copy()->startOfMonth();
        
        while ($currentDate <= $endDate) {
            // Check if payment already exists for this month
            $existingPayment = $this->payments()
                ->where('payment_type', 'monthly_fee')
                ->whereMonth('due_date', $currentDate->month)
                ->whereYear('due_date', $currentDate->year)
                ->first();
                
            if (!$existingPayment) {
                HostelPayment::create([
                    'allocation_id' => $this->id,
                    'student_id' => $this->student_id,
                    'payment_type' => 'monthly_fee',
                    'amount' => $this->monthly_fee,
                    'due_date' => $currentDate->copy()->endOfMonth(),
                    'status' => 'pending'
                ]);
            }
            
            $currentDate->addMonth();
        }
    }
}
