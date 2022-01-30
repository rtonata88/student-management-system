<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentExtraCharge extends Model
{
    protected $fillable = ['transaction_date', 'stuent_id', 'fee_id', 'fee_description', 'amount', 'status'];
}
