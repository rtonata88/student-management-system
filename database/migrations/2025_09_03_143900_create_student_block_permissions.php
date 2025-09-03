<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateStudentBlockPermissions extends Migration
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

        Permission::whereIn('name', $permissions)->delete();
    }
}
