<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateClassRoutinePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            [
                'name' => 'view-class-routine',
                'display_name' => 'View Class Routine',
                'description' => 'View class timetables and schedules'
            ],
            [
                'name' => 'create-class-routine',
                'display_name' => 'Create Class Routine',
                'description' => 'Create new class schedules'
            ],
            [
                'name' => 'edit-class-routine',
                'display_name' => 'Edit Class Routine',
                'description' => 'Edit existing class schedules'
            ],
            [
                'name' => 'delete-class-routine',
                'display_name' => 'Delete Class Routine',
                'description' => 'Delete class schedules'
            ],
            [
                'name' => 'manage-venues',
                'display_name' => 'Manage Venues',
                'description' => 'Create, edit and delete venues'
            ],
            [
                'name' => 'manage-class-durations',
                'display_name' => 'Manage Class Durations',
                'description' => 'Define and manage class time periods'
            ],
            [
                'name' => 'print-class-routine',
                'display_name' => 'Print Class Routine',
                'description' => 'Download and print class timetables'
            ]
        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission['name'])->exists()) {
                Permission::create($permission);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissions = [
            'view-class-routine',
            'create-class-routine',
            'edit-class-routine',
            'delete-class-routine',
            'manage-venues',
            'manage-class-durations',
            'print-class-routine'
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->delete();
        }
    }
}
