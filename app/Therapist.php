<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Therapist extends Model
{
    protected $fillable = ['name', 'surname', 'email', 'contact_number', 'sex', 'practice_number', 'id_number', 'work_permit_yn', 'country_id', 'board_id', 'licence_type_id', 'photo'];

    public function country(){
        return $this->belongsTo('App\Country');
    }

    public function qualification(){
        return $this->hasMany(Qualification::class, 'model_id');
    }

    public function publication(){
        return $this->hasMany(TherapistPublication::class);
    }

    public function specialties(){
        return $this->belongsToMany(Specialty::class, 'therapists_specialty', 'therapist_id', 'therapist_specialty_id');
    }

    public function languages(){
        return $this->belongsToMany(Language::class, 'language_therapist', 'therapist_id', 'therapist_languages_id');
    }
    
    public function licence_type(){
        return $this->belongsTo(LicenceType::class);
    }

    public function board(){
        return $this->belongsTo(RegistrationBoard::class);
    }
}
