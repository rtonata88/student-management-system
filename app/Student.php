<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['student_number', 'surname', 'student_names', 'initials', 'gender', 'contact_number', 'contact_email', 'date_of_birth', 'id_number', 'birth_certificate'];

    public function guardian(){
        return $this->hasOne(StudentGuardian::class);
    }

    public function registration(){
        return $this->hasMany(Registration::class);
    }
}
