<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExaminationSchedulePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if permissions table exists before inserting
        if (Schema::hasTable('permissions')) {
            $permissions = [
                [
                    'name' => 'view-examination-schedule',
                    'display_name' => 'View Examination Schedule',
                    'description' => 'Can view examination schedules',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'create-examination-schedule',
                    'display_name' => 'Create Examination Schedule',
                    'description' => 'Can create new examination schedules',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'edit-examination-schedule',
                    'display_name' => 'Edit Examination Schedule',
                    'description' => 'Can edit existing examination schedules',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'delete-examination-schedule',
                    'display_name' => 'Delete Examination Schedule',
                    'description' => 'Can delete examination schedules',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'print-examination-schedule',
                    'display_name' => 'Print Examination Schedule',
                    'description' => 'Can print and download examination schedules',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'manage-examination-schedule',
                    'display_name' => 'Manage Examination Schedule',
                    'description' => 'Full access to examination schedule management',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ];

            foreach ($permissions as $permission) {
                // Check if permission already exists
                $exists = \DB::table('permissions')
                    ->where('name', $permission['name'])
                    ->exists();

                if (!$exists) {
                    \DB::table('permissions')->insert($permission);
                }
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
        if (Schema::hasTable('permissions')) {
            $permissionNames = [
                'view-examination-schedule',
                'create-examination-schedule',
                'edit-examination-schedule',
                'delete-examination-schedule',
                'print-examination-schedule',
                'manage-examination-schedule'
            ];

            \DB::table('permissions')->whereIn('name', $permissionNames)->delete();
        }
    }
}
