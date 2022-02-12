<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleRegistration extends Model
{
    public function subject(){
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function registration()
    {
        if(is_null($this->student_id)){
            return $this->hasOne(Registration::class, 'academic_year', 'academic_year');
        } else {
            return $this->hasOne(Registration::class, 'academic_year', 'academic_year')->where('registrations.student_id', $this->student_id);
        }
        
    }
}
