<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password' , 'username'
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