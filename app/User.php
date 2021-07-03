<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use LaratrustUserTrait;
    use Notifiable;
    use \OwenIt\Auditing\Auditable;

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
        return $this->belongsToMany('App\Team');
    }

    public function country(){
        return $this->belongsTo('App\Country');
    }

    public function sector(){
        return $this->belongsToMany('App\Sector');
    }

    public function language(){
        return $this->belongsTo('App\Language', 'prefered_language', 'id');
    }

    public function city(){
        return $this->belongsTo('App\City');
    }

     public function department(){
        return $this->belongsTo('App\Department');
    }

    public function roles(){
        return $this->belongsToMany('App\Role');
    }


}