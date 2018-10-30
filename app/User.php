<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password' , 'username', 'gender_id', 'sector_id', 'team_id', 'department_id', 'prefered_language', 'country_id', 'city_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function team(){
        return $this->belongsTo('\App\Team', 'team_id');
    }

    public function country(){
        return $this->belongsTo('App\Country');
    }
}