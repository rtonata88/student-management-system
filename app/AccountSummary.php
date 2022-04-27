<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountSummary extends Model
{
    protected $table = 'account_summary';

    public function center()
    {
        return $this->belongsTo(Center::class, 'center_id');
    }
}
