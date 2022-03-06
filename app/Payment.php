<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['receipt_number','student_id', 'payment_date', 'payment_amount', 'payment_method', 'document_type', 'received_by'];


    public function user(){
        return $this->belongsTo(User::class, 'received_by');
    }

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }
}
