<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['student_number2','student_number', 'surname', 'student_names', 'initials', 'gender', 'contact_number', 'contact_email', 'date_of_birth', 'id_number', 'birth_certificate'];

    public function guardian(){
        return $this->hasMany(StudentGuardian::class);
    }

    public function registration(){
        return $this->hasMany(Registration::class);
    }

    public function currentRegistration(){
        return $this->hasOne(Registration::class)->where('academic_year', date('Y'));
    }

    public function registered_modules(){
        return $this->hasMany(ModuleRegistration::class);
    }
}
