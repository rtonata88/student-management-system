<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_number',
        'department',
        'position',
        'employment_type',
        'hire_date',
        'salary',
        'id_number',
        'passport_number',
        'date_of_birth',
        'gender',
        'marital_status',
        'nationality',
        'home_language',
        'personal_email',
        'work_phone',
        'personal_phone',
        'alternative_personal_phone',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'residential_address',
        'residential_city',
        'residential_province',
        'residential_postal_code',
        'postal_address',
        'postal_city',
        'postal_province',
        'postal_code',
        'bank_name',
        'bank_branch',
        'account_number',
        'account_type',
        'tax_number',
        'uif_number',
        'medical_aid_name',
        'medical_aid_number',
        'qualifications',
        'certifications',
        'skills',
        'employment_history',
        'notes',
        'is_active',
        'profile_photo'
    ];

    protected $casts = [
        'hire_date' => 'date',
        'date_of_birth' => 'date',
        'salary' => 'decimal:2',
        'qualifications' => 'array',
        'certifications' => 'array',
        'skills' => 'array',
        'employment_history' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Get the user that owns the employee profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full name of the employee.
     */
    public function getFullNameAttribute()
    {
        return $this->user->name;
    }

    /**
     * Get the employee's age.
     */
    public function getAgeAttribute()
    {
        if (!$this->date_of_birth) {
            return null;
        }
        return $this->date_of_birth->age;
    }

    /**
     * Get years of service.
     */
    public function getYearsOfServiceAttribute()
    {
        if (!$this->hire_date) {
            return null;
        }
        return $this->hire_date->diffInYears(now());
    }

    /**
     * Scope to get active employees only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by department.
     */
    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    /**
     * Generate a unique employee number in format 1011xxx
     */
    public static function generateEmployeeNumber()
    {
        do {
            // Generate random 3-digit number (001-999)
            $randomNumber = str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            $employeeNumber = '1011' . $randomNumber;
            
            // Check if this number already exists
            $exists = self::where('employee_number', $employeeNumber)->exists();
        } while ($exists);
        
        return $employeeNumber;
    }
}
