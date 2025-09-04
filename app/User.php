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
        'name', 'email', 'password' , 'username', 'user_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function subjectAllocations()
    {
        return $this->hasMany(SubjectAllocation::class);
    }

    public function employeeProfile()
    {
        return $this->hasOne(EmployeeProfile::class);
    }

    public function employeePayrollSetting()
    {
        return $this->hasOne(\App\Models\EmployeePayrollSetting::class, 'user_id');
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // Assign default student permissions when user is created
        static::created(function ($user) {
            if ($user->user_type === 'student') {
                $user->assignDefaultStudentPermissions();
            }
        });

        // Assign default student permissions when user_type is updated to student
        static::updated(function ($user) {
            if ($user->isDirty('user_type') && $user->user_type === 'student') {
                $user->assignDefaultStudentPermissions();
            }
        });
    }

    /**
     * Assign default permissions for student users
     */
    public function assignDefaultStudentPermissions()
    {
        $studentPermissions = [
            'access-student-portal',
            'view-student-profile',
            'view-student-academics',
            'view-student-finance',
            'view-student-subjects',
            'access-online-learning',
            'view-library-management',
            'view-hostel-management',
            'access-marketplace'
        ];

        foreach ($studentPermissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            if ($permission && !$this->hasPermission($permissionName)) {
                $this->attachPermission($permission);
            }
        }
    }
    
}