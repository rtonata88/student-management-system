<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Laratrust\Models\LaratrustPermission;

class CreateGradingScalesPermissions extends Migration
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
                'name' => 'grading-scales',
                'display_name' => 'View Grading Scales',
                'description' => 'View grading scales list'
            ],
            [
                'name' => 'add-grading-scales',
                'display_name' => 'Add Grading Scales',
                'description' => 'Create new grading scales'
            ],
            [
                'name' => 'edit-grading-scales',
                'display_name' => 'Edit Grading Scales',
                'description' => 'Edit existing grading scales'
            ],
            [
                'name' => 'delete-grading-scales',
                'display_name' => 'Delete Grading Scales',
                'description' => 'Delete grading scales'
            ]
        ];

        foreach ($permissions as $permission) {
            $existingPermission = LaratrustPermission::where('name', $permission['name'])->first();
            if (!$existingPermission) {
                $newPermission = new LaratrustPermission();
                $newPermission->name = $permission['name'];
                $newPermission->display_name = $permission['display_name'];
                $newPermission->description = $permission['description'];
                $newPermission->save();
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
        $permissions = ['grading-scales', 'add-grading-scales', 'edit-grading-scales', 'delete-grading-scales'];
        
        LaratrustPermission::whereIn('name', $permissions)->delete();
    }
}
