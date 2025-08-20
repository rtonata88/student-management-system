<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateInventoryPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    {
    {
    {
        // Insert inventory management permissions
        $permissions = [
            [
                'name' => 'inventory-view',
                'display_name' => 'View Inventory',
                'description' => 'View inventory items and stock levels',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'inventory-create',
                'display_name' => 'Create Inventory Items',
                'description' => 'Add new inventory items to the system',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'inventory-edit',
                'display_name' => 'Edit Inventory Items',
                'description' => 'Modify existing inventory item details',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'inventory-delete',
                'display_name' => 'Delete Inventory Items',
                'description' => 'Remove inventory items from the system',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'inventory-adjust-stock',
                'display_name' => 'Adjust Stock Levels',
                'description' => 'Make stock adjustments and corrections',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'inventory-stock-movement',
                'display_name' => 'Process Stock Movements',
                'description' => 'Handle stock in/out transactions',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'inventory-reports',
                'display_name' => 'View Inventory Reports',
                'description' => 'Access low stock, expired items, and other reports',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'inventory-categories-manage',
                'display_name' => 'Manage Inventory Categories',
                'description' => 'Create, edit, and delete inventory categories',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('permissions')->insert($permissions);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('permissions')->whereIn('name', [
            'inventory-view',
            'inventory-create',
            'inventory-edit',
            'inventory-delete',
            'inventory-adjust-stock',
            'inventory-stock-movement',
            'inventory-reports',
            'inventory-categories-manage'
        ])->delete();
    }
}
