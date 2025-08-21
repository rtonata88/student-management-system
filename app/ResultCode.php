<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultCode extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'description', 'pass_fail', 'active'];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopePass($query)
    {
        return $query->where('pass_fail', 'Pass');
    }

    public function scopeFail($query)
    {
        return $query->where('pass_fail', 'Fail');
    }
}
