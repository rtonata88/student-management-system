<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateDepartmentPermissions extends Migration
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
                'name' => 'view-departments',
                'display_name' => 'View Departments',
                'description' => 'Allow user to view department listings and details'
            ],
            [
                'name' => 'create-departments',
                'display_name' => 'Create Departments',
                'description' => 'Allow user to create new departments'
            ],
            [
                'name' => 'edit-departments',
                'display_name' => 'Edit Departments',
                'description' => 'Allow user to edit existing department information'
            ],
            [
                'name' => 'delete-departments',
                'display_name' => 'Delete Departments',
                'description' => 'Allow user to delete departments from the system'
            ],
            [
                'name' => 'manage-departments',
                'display_name' => 'Manage Departments',
                'description' => 'Allow user to perform all department management operations'
            ],
            [
                'name' => 'toggle-department-status',
                'display_name' => 'Toggle Department Status',
                'description' => 'Allow user to activate or deactivate departments'
            ]
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                [
                    'display_name' => $permission['display_name'],
                    'description' => $permission['description']
                ]
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
        $permissions = [
            'view-departments',
            'create-departments',
            'edit-departments',
            'delete-departments',
            'manage-departments',
            'toggle-department-status'
        ];

        Permission::whereIn('name', $permissions)->delete();
    }
}
