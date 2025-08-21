<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StudentNumberReservation extends Model
{
    protected $fillable = ['student_number', 'session_id', 'reserved_at', 'expires_at'];
    
    protected $dates = ['reserved_at', 'expires_at'];

    /**
     * Clean up expired reservations
     */
    public static function cleanupExpired()
    {
        self::where('expires_at', '<', Carbon::now())->delete();
    }

    /**
     * Reserve a student number for a session
     */
    public static function reserve($studentNumber, $sessionId, $minutesToExpire = 30)
    {
        self::cleanupExpired();
        
        return self::create([
            'student_number' => $studentNumber,
            'session_id' => $sessionId,
            'reserved_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addMinutes($minutesToExpire)
        ]);
    }

    /**
     * Check if a student number is reserved
     */
    public static function isReserved($studentNumber)
    {
        self::cleanupExpired();
        
        return self::where('student_number', $studentNumber)
            ->where('expires_at', '>', Carbon::now())
            ->exists();
    }

    /**
     * Release a reservation
     */
    public static function release($studentNumber, $sessionId = null)
    {
        $query = self::where('student_number', $studentNumber);
        
        if ($sessionId) {
            $query->where('session_id', $sessionId);
        }
        
        return $query->delete();
    }
}
