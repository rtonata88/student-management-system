<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateFixedAssetsPermissions extends Migration
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
                'name' => 'fixed-assets-view',
                'display_name' => 'View Fixed Assets',
                'description' => 'View fixed assets and asset details'
            ],
            [
                'name' => 'fixed-assets-create',
                'display_name' => 'Create Fixed Assets',
                'description' => 'Add new fixed assets to the system'
            ],
            [
                'name' => 'fixed-assets-edit',
                'display_name' => 'Edit Fixed Assets',
                'description' => 'Modify existing fixed asset details'
            ],
            [
                'name' => 'fixed-assets-delete',
                'display_name' => 'Delete Fixed Assets',
                'description' => 'Remove fixed assets from the system'
            ],
            [
                'name' => 'fixed-assets-maintenance',
                'display_name' => 'Manage Asset Maintenance',
                'description' => 'Schedule and manage asset maintenance activities'
            ],
            [
                'name' => 'fixed-assets-reports',
                'display_name' => 'View Asset Reports',
                'description' => 'Access maintenance due and warranty expired reports'
            ],
            [
                'name' => 'fixed-assets-categories-manage',
                'display_name' => 'Manage Asset Categories',
                'description' => 'Create, edit, and delete fixed asset categories'
            ]
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $permission['name']],
                array_merge($permission, [
                    'created_at' => now(),
                    'updated_at' => now()
                ])
            );
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
            'fixed-assets-view',
            'fixed-assets-create',
            'fixed-assets-edit',
            'fixed-assets-delete',
            'fixed-assets-maintenance',
            'fixed-assets-reports',
            'fixed-assets-categories-manage'
        ];

        DB::table('permissions')->whereIn('name', $permissionNames)->delete();
    }
}
