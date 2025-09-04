<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignationPermissions extends Migration
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
                'name' => 'view-designations',
                'display_name' => 'View Designations',
                'description' => 'View designation list and details'
            ],
            [
                'name' => 'create-designations',
                'display_name' => 'Create Designations',
                'description' => 'Create new designations'
            ],
            [
                'name' => 'edit-designations',
                'display_name' => 'Edit Designations',
                'description' => 'Edit existing designations'
            ],
            [
                'name' => 'delete-designations',
                'display_name' => 'Delete Designations',
                'description' => 'Delete designations'
            ],
            [
                'name' => 'manage-designations',
                'display_name' => 'Manage Designations',
                'description' => 'Full access to designation management'
            ],
            [
                'name' => 'toggle-designation-status',
                'display_name' => 'Toggle Designation Status',
                'description' => 'Activate or deactivate designations'
            ]
        ];

        foreach ($permissions as $permission) {
            $existing = \DB::table('permissions')->where('name', $permission['name'])->first();
            
            if (!$existing) {
                \DB::table('permissions')->insert([
                    'name' => $permission['name'],
                    'display_name' => $permission['display_name'],
                    'description' => $permission['description'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                \DB::table('permissions')->where('name', $permission['name'])->update([
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
        $permissions = [
            'view-designations',
            'create-designations',
            'edit-designations',
            'delete-designations',
            'manage-designations',
            'toggle-designation-status'
        ];

        \DB::table('permissions')->whereIn('name', $permissions)->delete();
    }
}
