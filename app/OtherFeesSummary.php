<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OtherFeesSummary extends Model
{
    protected $table = 'other_fees';
    
    // Override the query to avoid the problematic view
    public static function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        // Create a new query instance that uses the base table instead of the view
        $instance = new static;
        return $instance->newQuery()->where($column, $operator, $value, $boolean);
    }
    
    // Alternative method to get extra charges without using the view
    public static function getExtraCharges($student_id, $academic_year)
    {
        return DB::table('other_fees')
            ->where('student_id', $student_id)
            ->where('academic_year', $academic_year)
            ->where('status', 'active')
            ->get();
    }
}
