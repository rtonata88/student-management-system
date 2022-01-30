<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['student_id', 'payment_date', 'payment_amount', 'payment_method', 'received_by'];
    
}
