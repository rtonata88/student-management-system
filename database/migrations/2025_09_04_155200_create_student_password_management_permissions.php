<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateStudentPasswordManagementPermissions extends Migration
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
                'name' => 'view-student-passwords',
                'display_name' => 'View Student Passwords',
                'description' => 'Allow user to view student password reset interface'
            ],
            [
                'name' => 'reset-student-passwords',
                'display_name' => 'Reset Student Passwords',
                'description' => 'Allow user to reset passwords for students'
            ],
            [
                'name' => 'manage-student-passwords',
                'display_name' => 'Manage Student Passwords',
                'description' => 'Allow user to manage all student password operations'
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
            'view-student-passwords',
            'reset-student-passwords',
            'manage-student-passwords'
        ];

        Permission::whereIn('name', $permissions)->delete();
    }
}
