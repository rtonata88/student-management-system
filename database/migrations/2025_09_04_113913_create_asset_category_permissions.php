<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetCategoryPermissions extends Migration
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
                'name' => 'view-asset-categories',
                'display_name' => 'View Asset Categories',
                'description' => 'Can view asset categories list and details'
            ],
            [
                'name' => 'create-asset-categories',
                'display_name' => 'Create Asset Categories',
                'description' => 'Can create new asset categories'
            ],
            [
                'name' => 'edit-asset-categories',
                'display_name' => 'Edit Asset Categories',
                'description' => 'Can edit existing asset categories'
            ],
            [
                'name' => 'delete-asset-categories',
                'display_name' => 'Delete Asset Categories',
                'description' => 'Can delete asset categories'
            ],
            [
                'name' => 'manage-asset-categories',
                'display_name' => 'Manage Asset Categories',
                'description' => 'Full access to asset category management'
            ],
            [
                'name' => 'toggle-asset-category-status',
                'display_name' => 'Toggle Asset Category Status',
                'description' => 'Can activate/deactivate asset categories'
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
            'view-asset-categories',
            'create-asset-categories',
            'edit-asset-categories',
            'delete-asset-categories',
            'manage-asset-categories',
            'toggle-asset-category-status'
        ];

        DB::table('permissions')->whereIn('name', $permissionNames)->delete();
    }
}
