<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateFleetManagementPermissions extends Migration
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
            // Fleet Management Menu Access
            [
                'name' => 'fleet-management',
                'display_name' => 'Access Fleet Management Menu',
                'description' => 'Can access the fleet management menu and screens'
            ],
            
            // Vehicle Management
            [
                'name' => 'fleet-vehicles-view',
                'display_name' => 'View Vehicles',
                'description' => 'View vehicle information and details'
            ],
            [
                'name' => 'fleet-vehicles-create',
                'display_name' => 'Add Vehicles',
                'description' => 'Add new vehicles to the fleet'
            ],
            [
                'name' => 'fleet-vehicles-edit',
                'display_name' => 'Edit Vehicles',
                'description' => 'Modify vehicle information and details'
            ],
            [
                'name' => 'fleet-vehicles-delete',
                'display_name' => 'Delete Vehicles',
                'description' => 'Remove vehicles from the fleet'
            ],
            
            // Driver Management
            [
                'name' => 'fleet-drivers-view',
                'display_name' => 'View Drivers',
                'description' => 'View driver information and profiles'
            ],
            [
                'name' => 'fleet-drivers-create',
                'display_name' => 'Add Drivers',
                'description' => 'Add new drivers to the system'
            ],
            [
                'name' => 'fleet-drivers-edit',
                'display_name' => 'Edit Drivers',
                'description' => 'Modify driver information and profiles'
            ],
            [
                'name' => 'fleet-drivers-delete',
                'display_name' => 'Delete Drivers',
                'description' => 'Remove drivers from the system'
            ],
            
            // Trip Management
            [
                'name' => 'fleet-trips-view',
                'display_name' => 'View Trip Logs',
                'description' => 'View trip logs and journey records'
            ],
            [
                'name' => 'fleet-trips-create',
                'display_name' => 'Create Trip Logs',
                'description' => 'Create new trip logs and journey records'
            ],
            [
                'name' => 'fleet-trips-edit',
                'display_name' => 'Edit Trip Logs',
                'description' => 'Modify trip logs and journey records'
            ],
            [
                'name' => 'fleet-trips-delete',
                'display_name' => 'Delete Trip Logs',
                'description' => 'Remove trip logs from the system'
            ],
            
            // Fuel Management
            [
                'name' => 'fleet-fuel-view',
                'display_name' => 'View Fuel Records',
                'description' => 'View fuel consumption and refueling records'
            ],
            [
                'name' => 'fleet-fuel-create',
                'display_name' => 'Add Fuel Records',
                'description' => 'Add new fuel consumption and refueling records'
            ],
            [
                'name' => 'fleet-fuel-edit',
                'display_name' => 'Edit Fuel Records',
                'description' => 'Modify fuel consumption and refueling records'
            ],
            [
                'name' => 'fleet-fuel-delete',
                'display_name' => 'Delete Fuel Records',
                'description' => 'Remove fuel records from the system'
            ],
            
            // Service/Maintenance Management
            [
                'name' => 'fleet-services-view',
                'display_name' => 'View Vehicle Services',
                'description' => 'View vehicle maintenance and service records'
            ],
            [
                'name' => 'fleet-services-create',
                'display_name' => 'Schedule Vehicle Services',
                'description' => 'Schedule new vehicle maintenance and services'
            ],
            [
                'name' => 'fleet-services-edit',
                'display_name' => 'Edit Vehicle Services',
                'description' => 'Modify vehicle maintenance and service records'
            ],
            [
                'name' => 'fleet-services-delete',
                'display_name' => 'Delete Vehicle Services',
                'description' => 'Remove service records from the system'
            ],
            
            // Vehicle Assignments
            [
                'name' => 'fleet-assignments-view',
                'display_name' => 'View Vehicle Assignments',
                'description' => 'View driver-vehicle assignments'
            ],
            [
                'name' => 'fleet-assignments-manage',
                'display_name' => 'Manage Vehicle Assignments',
                'description' => 'Assign and unassign drivers to vehicles'
            ],
            
            // Fleet Reports
            [
                'name' => 'fleet-reports-view',
                'display_name' => 'View Fleet Reports',
                'description' => 'Access fleet management reports and analytics'
            ],
            
            // Vehicle Categories
            [
                'name' => 'fleet-categories-manage',
                'display_name' => 'Manage Vehicle Categories',
                'description' => 'Create, edit, and delete vehicle categories'
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
            'fleet-management',
            'fleet-vehicles-view',
            'fleet-vehicles-create',
            'fleet-vehicles-edit',
            'fleet-vehicles-delete',
            'fleet-drivers-view',
            'fleet-drivers-create',
            'fleet-drivers-edit',
            'fleet-drivers-delete',
            'fleet-trips-view',
            'fleet-trips-create',
            'fleet-trips-edit',
            'fleet-trips-delete',
            'fleet-fuel-view',
            'fleet-fuel-create',
            'fleet-fuel-edit',
            'fleet-fuel-delete',
            'fleet-services-view',
            'fleet-services-create',
            'fleet-services-edit',
            'fleet-services-delete',
            'fleet-assignments-view',
            'fleet-assignments-manage',
            'fleet-reports-view',
            'fleet-categories-manage'
        ];

        DB::table('permissions')->whereIn('name', $permissions)->delete();
    }
}
