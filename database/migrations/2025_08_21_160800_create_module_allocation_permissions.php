<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateModuleAllocationPermissions extends Migration
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
                'name' => 'view-module-allocations',
                'display_name' => 'View Module Allocations',
                'description' => 'View module allocations'
            ],
            [
                'name' => 'create-module-allocations',
                'display_name' => 'Create Module Allocations',
                'description' => 'Create new module allocations'
            ],
            [
                'name' => 'edit-module-allocations',
                'display_name' => 'Edit Module Allocations',
                'description' => 'Edit existing module allocations'
            ],
            [
                'name' => 'delete-module-allocations',
                'display_name' => 'Delete Module Allocations',
                'description' => 'Delete module allocations'
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
            'view-module-allocations',
            'create-module-allocations', 
            'edit-module-allocations',
            'delete-module-allocations'
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->delete();
        }
    }
}
