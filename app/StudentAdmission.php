<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StudentAdmission extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['student_id', 'admission_status', 'remarks', 'status_date'];

    protected $dates = ['status_date'];

    public function student(){
        return $this->belongsTo(Student::class);
    }
}
