<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddMissingFleetAssignmentPermissions extends Migration
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
                'name' => 'fleet-assignments-create',
                'display_name' => 'Create Vehicle Assignments',
                'description' => 'Create new driver-vehicle assignments'
            ],
            [
                'name' => 'fleet-assignments-edit',
                'display_name' => 'Edit Vehicle Assignments',
                'description' => 'Modify existing driver-vehicle assignments'
            ],
            [
                'name' => 'fleet-assignments-delete',
                'display_name' => 'Delete Vehicle Assignments',
                'description' => 'Remove driver-vehicle assignments'
            ]
        ];

        foreach ($permissions as $permission) {
            if (!DB::table('permissions')->where('name', $permission['name'])->exists()) {
                DB::table('permissions')->insert([
                    'name' => $permission['name'],
                    'display_name' => $permission['display_name'],
                    'description' => $permission['description'],
                    'created_at' => now(),
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
        $permissions = [
            'fleet-assignments-create',
            'fleet-assignments-edit',
            'fleet-assignments-delete'
        ];

        DB::table('permissions')->whereIn('name', $permissions)->delete();
    }
}
