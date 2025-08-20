<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class FleetManagementRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Fleet Manager role
        $fleetManagerRole = Role::updateOrCreate(
            ['name' => 'fleet-manager'],
            [
                'name' => 'fleet-manager',
                'display_name' => 'Fleet Manager',
                'description' => 'Full access to fleet management system'
            ]
        );

        // Create Fleet Coordinator role
        $fleetCoordinatorRole = Role::updateOrCreate(
            ['name' => 'fleet-coordinator'],
            [
                'name' => 'fleet-coordinator',
                'display_name' => 'Fleet Coordinator',
                'description' => 'Limited access to fleet operations'
            ]
        );

        // Create Fleet Driver role
        $fleetDriverRole = Role::updateOrCreate(
            ['name' => 'fleet-driver'],
            [
                'name' => 'fleet-driver',
                'display_name' => 'Fleet Driver',
                'description' => 'Driver access to fleet system'
            ]
        );

        // Get all fleet permissions
        $allFleetPermissions = Permission::where('name', 'like', 'fleet-%')->pluck('id')->toArray();
        
        // Fleet Manager gets all permissions
        $fleetManagerRole->permissions()->sync($allFleetPermissions);

        // Fleet Coordinator gets view and some management permissions
        $coordinatorPermissions = Permission::whereIn('name', [
            'fleet-management',
            'fleet-vehicles-view',
            'fleet-vehicles-edit',
            'fleet-drivers-view',
            'fleet-drivers-edit',
            'fleet-trips-view',
            'fleet-trips-create',
            'fleet-trips-edit',
            'fleet-fuel-view',
            'fleet-fuel-create',
            'fleet-services-view',
            'fleet-services-create',
            'fleet-assignments-view',
            'fleet-reports-view'
        ])->pluck('id')->toArray();
        
        $fleetCoordinatorRole->permissions()->sync($coordinatorPermissions);

        // Fleet Driver gets basic permissions
        $driverPermissions = Permission::whereIn('name', [
            'fleet-management',
            'fleet-vehicles-view',
            'fleet-trips-view',
            'fleet-trips-create',
            'fleet-fuel-view',
            'fleet-fuel-create'
        ])->pluck('id')->toArray();
        
        $fleetDriverRole->permissions()->sync($driverPermissions);
    }
}
