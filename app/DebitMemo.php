<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DebitMemo extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $fillable = ['student_id', 'transaction_date','amount','reason','captured_by', 'debit_type', 'model', 'model_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'captured_by');
    }
}
