<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVenueAndTimeSlotPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create venue management permissions
        $venuePermissions = [
            'view-venue',
            'create-venue', 
            'edit-venue',
            'delete-venue'
        ];

        // Create time slot management permissions
        $timeSlotPermissions = [
            'view-time-slot',
            'create-time-slot',
            'edit-time-slot', 
            'delete-time-slot'
        ];

        $allPermissions = array_merge($venuePermissions, $timeSlotPermissions);

        foreach ($allPermissions as $permission) {
            if (!\App\Permission::where('name', $permission)->exists()) {
                \App\Permission::create([
                    'name' => $permission,
                    'display_name' => ucwords(str_replace('-', ' ', $permission)),
                    'description' => 'Permission to ' . str_replace('-', ' ', $permission)
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
        $permissions = [
            'view-venue', 'create-venue', 'edit-venue', 'delete-venue',
            'view-time-slot', 'create-time-slot', 'edit-time-slot', 'delete-time-slot'
        ];

        foreach ($permissions as $permission) {
            \App\Permission::where('name', $permission)->delete();
        }
    }
}
