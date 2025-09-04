<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Student extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['user_id', 'student_number2','student_number', 'surname', 'student_names', 'initials', 'center_id', 'gender', 'contact_number', 'contact_email', 'date_of_birth', 'id_number', 'birth_certificate', 'photo'];

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

    public function extra_charges(){
        return $this->hasMany(StudentExtraCharge::class);
    }

    public function admission(){
        return $this->hasOne(StudentAdmission::class);
    }

    public function center(){
        return $this->belongsTo(Center::class);
    }

    public function testMarks(){
        return $this->hasMany(TestMark::class);
    }

    public function examMarks(){
        return $this->hasMany(ExamMark::class);
    }

    public function promotions(){
        return $this->hasMany(StudentPromotion::class);
    }

    // Relationship with User model
    public function user(){
        return $this->belongsTo(User::class);
    }

    // Accessor to get admission status directly from the student model
    public function getAdmissionStatusAttribute(){
        return $this->admission ? $this->admission->admission_status : null;
    }
}
