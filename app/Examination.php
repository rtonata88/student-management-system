<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'mark_cap', 'active'];

    protected $casts = [
        'active' => 'boolean',
        'mark_cap' => 'decimal:2'
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
