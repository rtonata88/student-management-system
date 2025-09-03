<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class UpdateStudentBlockPermissionsWithDescriptions extends Migration
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
                'name' => 'view-student-blocks',
                'display_name' => 'View Student Blocks',
                'description' => 'Allows user to view the student blocks listing and search functionality'
            ],
            [
                'name' => 'create-student-blocks',
                'display_name' => 'Create Student Blocks',
                'description' => 'Allows user to create new student blocks individually'
            ],
            [
                'name' => 'edit-student-blocks',
                'display_name' => 'Edit Student Blocks',
                'description' => 'Allows user to edit existing student block records'
            ],
            [
                'name' => 'delete-student-blocks',
                'display_name' => 'Delete Student Blocks',
                'description' => 'Allows user to delete student block records'
            ],
            [
                'name' => 'block-students',
                'display_name' => 'Block Students',
                'description' => 'Allows user to block individual students'
            ],
            [
                'name' => 'unblock-students',
                'display_name' => 'Unblock Students',
                'description' => 'Allows user to unblock/revoke student blocks'
            ],
            [
                'name' => 'bulk-block-students',
                'display_name' => 'Bulk Block Students',
                'description' => 'Allows user to perform bulk blocking operations by academic criteria'
            ],
            [
                'name' => 'manage-block-exceptions',
                'display_name' => 'Manage Block Exceptions',
                'description' => 'Allows user to add or remove students from block exceptions'
            ],
            [
                'name' => 'view-block-history',
                'display_name' => 'View Block History',
                'description' => 'Allows user to view student block history and audit trail'
            ],
            [
                'name' => 'export-student-blocks',
                'display_name' => 'Export Student Blocks',
                'description' => 'Allows user to export student block data to various formats'
            ]
        ];

        foreach ($permissions as $permissionData) {
            $permission = Permission::where('name', $permissionData['name'])->first();
            if ($permission) {
                $permission->update([
                    'display_name' => $permissionData['display_name'],
                    'description' => $permissionData['description']
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
            'view-student-blocks',
            'create-student-blocks',
            'edit-student-blocks',
            'delete-student-blocks',
            'block-students',
            'unblock-students',
            'bulk-block-students',
            'manage-block-exceptions',
            'view-block-history',
            'export-student-blocks'
        ];

        foreach ($permissionNames as $name) {
            $permission = Permission::where('name', $name)->first();
            if ($permission) {
                $permission->update([
                    'display_name' => null,
                    'description' => null
                ]);
            }
        }
    }
}
