<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    protected $fillable = ['center_name', 'location'];

    public function subjectAllocations()
    {
        return $this->hasMany(SubjectAllocation::class);
    }
}
