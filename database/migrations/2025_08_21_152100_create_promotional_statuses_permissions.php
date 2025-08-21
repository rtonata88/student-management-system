<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laratrust\Models\LaratrustPermission;

class CreatePromotionalStatusesPermissions extends Migration
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
                'name' => 'promotional-statuses',
                'display_name' => 'View Promotional Statuses',
                'description' => 'View promotional statuses list'
            ],
            [
                'name' => 'add-promotional-statuses',
                'display_name' => 'Add Promotional Statuses',
                'description' => 'Create new promotional statuses'
            ],
            [
                'name' => 'edit-promotional-statuses',
                'display_name' => 'Edit Promotional Statuses',
                'description' => 'Edit existing promotional statuses'
            ],
            [
                'name' => 'delete-promotional-statuses',
                'display_name' => 'Delete Promotional Statuses',
                'description' => 'Delete promotional statuses'
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
        $permissions = [
            'promotional-statuses',
            'add-promotional-statuses',
            'edit-promotional-statuses',
            'delete-promotional-statuses'
        ];

        LaratrustPermission::whereIn('name', $permissions)->delete();
    }
}
