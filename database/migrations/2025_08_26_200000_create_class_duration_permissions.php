<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateClassDurationPermissions extends Migration
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
                'name' => 'view-class-duration',
                'display_name' => 'View Class Duration',
                'description' => 'View class duration settings'
            ],
            [
                'name' => 'create-class-duration',
                'display_name' => 'Create Class Duration',
                'description' => 'Create new class duration settings'
            ],
            [
                'name' => 'edit-class-duration',
                'display_name' => 'Edit Class Duration',
                'description' => 'Edit existing class duration settings'
            ],
            [
                'name' => 'delete-class-duration',
                'display_name' => 'Delete Class Duration',
                'description' => 'Delete class duration settings'
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
            'view-class-duration',
            'create-class-duration',
            'edit-class-duration',
            'delete-class-duration'
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->delete();
        }
    }
}
