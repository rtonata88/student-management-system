<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateMyModulesPermissions extends Migration
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
                'name' => 'view-my-modules',
                'display_name' => 'View My Modules',
                'description' => 'View modules allocated to the user'
            ],
            [
                'name' => 'view-class-list',
                'display_name' => 'View Class List',
                'description' => 'View class list for allocated modules'
            ],
            [
                'name' => 'view-attendance',
                'display_name' => 'View Attendance',
                'description' => 'View attendance for allocated modules'
            ],
            [
                'name' => 'view-class-notes',
                'display_name' => 'View Class Notes',
                'description' => 'View class notes for allocated modules'
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
            'view-my-modules',
            'view-class-list',
            'view-attendance',
            'view-class-notes'
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->delete();
        }
    }
}
