<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateStudentPromotionsPermissions extends Migration
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
                'name' => 'view-student-promotions',
                'display_name' => 'View Student Promotions',
                'description' => 'Can view student promotions interface and search for students'
            ],
            [
                'name' => 'create-student-promotions',
                'display_name' => 'Create Student Promotions',
                'description' => 'Can create new student promotion records'
            ],
            [
                'name' => 'edit-student-promotions',
                'display_name' => 'Edit Student Promotions',
                'description' => 'Can edit existing student promotion records'
            ],
            [
                'name' => 'delete-student-promotions',
                'display_name' => 'Delete Student Promotions',
                'description' => 'Can delete student promotion records'
            ],
            [
                'name' => 'promote-students',
                'display_name' => 'Promote Students',
                'description' => 'Can promote students and assign promotional statuses'
            ],
            [
                'name' => 'view-promotion-history',
                'display_name' => 'View Promotion History',
                'description' => 'Can view student promotion history across academic years'
            ],
            [
                'name' => 'export-promotion-reports',
                'display_name' => 'Export Promotion Reports',
                'description' => 'Can export promotion reports and statistics'
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
            'view-student-promotions',
            'create-student-promotions', 
            'edit-student-promotions',
            'delete-student-promotions',
            'promote-students',
            'view-promotion-history',
            'export-promotion-reports'
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->delete();
        }
    }
}
