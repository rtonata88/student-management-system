<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminClerk extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'surname', 'email', 'country_id'];
}
