<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Payment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['receipt_number','student_id', 'payment_date', 'payment_amount', 'payment_method', 'document_type', 'received_by'];


    public function user(){
        return $this->belongsTo(User::class, 'received_by');
    }

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }
}
