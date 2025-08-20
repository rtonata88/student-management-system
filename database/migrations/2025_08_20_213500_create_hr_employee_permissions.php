<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateHrEmployeePermissions extends Migration
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
    {
        $permissions = [
            // Employee Bio/Profile permissions
            [
                'name' => 'employee-bio-view',
                'display_name' => 'View Employee Bio',
                'description' => 'View employee profiles and biographical information'
            ],
            [
                'name' => 'employee-bio-create',
                'display_name' => 'Create Employee Bio',
                'description' => 'Create new employee profiles'
            ],
            [
                'name' => 'employee-bio-edit',
                'display_name' => 'Edit Employee Bio',
                'description' => 'Modify employee profiles and biographical information'
            ],
            [
                'name' => 'employee-bio-delete',
                'display_name' => 'Delete Employee Bio',
                'description' => 'Remove employee profiles from the system'
            ],
            
            // Leave Management permissions
            [
                'name' => 'leave-management-view',
                'display_name' => 'View Leave Management',
                'description' => 'View all leave requests and management dashboard'
            ],
            [
                'name' => 'leave-management-approve',
                'display_name' => 'Approve Leave Requests',
                'description' => 'Approve or reject employee leave requests'
            ],
            [
                'name' => 'leave-management-create',
                'display_name' => 'Create Leave on Behalf',
                'description' => 'Create leave requests on behalf of employees'
            ],
            [
                'name' => 'leave-management-reports',
                'display_name' => 'Leave Management Reports',
                'description' => 'Access leave reports and analytics'
            ],
            
            // Leave Application permissions (for employees)
            [
                'name' => 'leave-application-view',
                'display_name' => 'View Leave Applications',
                'description' => 'View own leave applications and history'
            ],
            [
                'name' => 'leave-application-create',
                'display_name' => 'Create Leave Application',
                'description' => 'Submit new leave applications'
            ],
            [
                'name' => 'leave-application-edit',
                'display_name' => 'Edit Leave Application',
                'description' => 'Modify pending leave applications'
            ],
            [
                'name' => 'leave-application-cancel',
                'display_name' => 'Cancel Leave Application',
                'description' => 'Cancel submitted leave applications'
            ],
            
            // Leave Types management
            [
                'name' => 'leave-types-manage',
                'display_name' => 'Manage Leave Types',
                'description' => 'Create, edit, and delete leave types'
            ],
            
            // HR Dashboard
            [
                'name' => 'hr-dashboard-view',
                'display_name' => 'View HR Dashboard',
                'description' => 'Access HR dashboard and overview'
            ]
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $permission['name']],
                [
                    'name' => $permission['name'],
                    'display_name' => $permission['display_name'],
                    'description' => $permission['description'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissions = [
            'employee-bio-view',
            'employee-bio-create',
            'employee-bio-edit',
            'employee-bio-delete',
            'leave-management-view',
            'leave-management-approve',
            'leave-management-create',
            'leave-management-reports',
            'leave-application-view',
            'leave-application-create',
            'leave-application-edit',
            'leave-application-cancel',
            'leave-types-manage',
            'hr-dashboard-view'
        ];

        DB::table('permissions')->whereIn('name', $permissions)->delete();
    }
}
