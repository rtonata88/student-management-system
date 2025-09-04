<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveTypePermissions extends Migration
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
                'name' => 'view-leave-types',
                'display_name' => 'View Leave Types',
                'description' => 'Can view leave types list and details'
            ],
            [
                'name' => 'create-leave-types',
                'display_name' => 'Create Leave Types',
                'description' => 'Can create new leave types'
            ],
            [
                'name' => 'edit-leave-types',
                'display_name' => 'Edit Leave Types',
                'description' => 'Can edit existing leave types'
            ],
            [
                'name' => 'delete-leave-types',
                'display_name' => 'Delete Leave Types',
                'description' => 'Can delete leave types'
            ],
            [
                'name' => 'manage-leave-types',
                'display_name' => 'Manage Leave Types',
                'description' => 'Full access to leave type management'
            ],
            [
                'name' => 'toggle-leave-type-status',
                'display_name' => 'Toggle Leave Type Status',
                'description' => 'Can activate/deactivate leave types'
            ]
        ];

        foreach ($permissions as $permission) {
            $existingPermission = DB::table('permissions')
                ->where('name', $permission['name'])
                ->first();

            if (!$existingPermission) {
                DB::table('permissions')->insert([
                    'name' => $permission['name'],
                    'display_name' => $permission['display_name'],
                    'description' => $permission['description'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                DB::table('permissions')
                    ->where('name', $permission['name'])
                    ->update([
                        'display_name' => $permission['display_name'],
                        'description' => $permission['description'],
                        'updated_at' => now()
                    ]);
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
        $permissionNames = [
            'view-leave-types',
            'create-leave-types',
            'edit-leave-types',
            'delete-leave-types',
            'manage-leave-types',
            'toggle-leave-type-status'
        ];

        DB::table('permissions')->whereIn('name', $permissionNames)->delete();
    }
}
