<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Registration extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function subject(){
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function center(){
        return $this->belongsTo(Center::class, 'center_id');
    }

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }
}
