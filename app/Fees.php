<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fees extends Model
{
    protected $fillable = ['fee_description', 'automatic_charge', 'amount'];
}
