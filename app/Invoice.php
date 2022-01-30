<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['student_id','reference_number', 'model', 'model_id', 'financial_year', 'transaction_date', 'line_description', 'debit_amount', 'credit_amount'];
}
