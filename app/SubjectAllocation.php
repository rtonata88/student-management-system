<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'subject_id', 'center_id' , 'academic_year_id'
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'subject_id');
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assessment_types()
    {
            // dd($this);
        return $this->hasMany(AssessmentType::class,'subject_id','subject_id');
    }

    //registered students
    public function moduleRegistrations()
    {
        return $this->hasMany(ModuleRegistration::class, 'module_id', 'subject_id');
    }

    // //count of registered students
    // public function getCountOfStudents()
    // {
    //     return $this->moduleRegistrations()
    //         ->whereHas('registration', function ($query) {
    //             $query->where('academic_year', $this->academicYear->academic_year)
    //                   ->where('center_id', $this->center->id);
    //         })
    //         ->count();
    // }

}
