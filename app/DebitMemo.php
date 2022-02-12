<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DebitMemo extends Model
{
    protected $fillable = ['student_id', 'transaction_date','amount','reason','captured_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'captured_by');
    }
}
