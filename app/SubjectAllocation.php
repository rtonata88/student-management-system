<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'module_id', 'center_id' , 'academic_year_id'
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function assessment_types()
    {
            // dd($this);
        return $this->hasMany(AssessmentType::class,'subject_id','module_id');
    }

    // //registered students
    // public function moduleRegistrations()
    // {
    //     return $this->hasMany(ModuleRegistration::class, 'module_id')->where('registration_status','Registered');
    // }

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
