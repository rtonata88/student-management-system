<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashierPayment extends Model
{
    protected $fillable = [
        'student_id',
        'receipt_number',
        'amount',
        'payment_method',
        'reference_number',
        'notes',
        'cashier_id',
        'payment_date'
    ];

    protected $dates = [
        'payment_date',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime'
    ];

    /**
     * Get the student that owns the payment.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the cashier (user) who processed the payment.
     */
    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    /**
     * Generate a unique receipt number in format YYMMDD#####
     */
    public static function generateReceiptNumber()
    {
        $datePrefix = now()->format('ymd'); // YYMMDD format
        
        // Generate random 5-digit number
        do {
            $randomNumber = str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $receiptNumber = $datePrefix . $randomNumber;
        } while (
            self::where('receipt_number', $receiptNumber)->exists() ||
            \App\Payment::where('receipt_number', $receiptNumber)->exists()
        );
        
        return $receiptNumber;
    }

    /**
     * Scope to filter payments by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('payment_date', [$startDate, $endDate]);
    }

    /**
     * Scope to filter payments by student
     */
    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Scope to filter payments by cashier
     */
    public function scopeByCashier($query, $cashierId)
    {
        return $query->where('cashier_id', $cashierId);
    }
}
