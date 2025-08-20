<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateHostelManagementPermissions extends Migration
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
        // Define hostel management permissions
        $permissions = [
            // Main permission group
            'HOSTEL_MANAGEMENT' => 'Hostel Management Access',
            
            // Specific permissions
            'hostel-administration' => 'Hostel Administration Dashboard',
            'hostel-view' => 'View Hostels',
            'hostel-create' => 'Create Hostels',
            'hostel-edit' => 'Edit Hostels',
            'hostel-delete' => 'Delete Hostels',
            
            'hostel-block-view' => 'View Hostel Blocks',
            'hostel-block-create' => 'Create Hostel Blocks',
            'hostel-block-edit' => 'Edit Hostel Blocks',
            'hostel-block-delete' => 'Delete Hostel Blocks',
            
            'hostel-room-view' => 'View Hostel Rooms',
            'hostel-room-create' => 'Create Hostel Rooms',
            'hostel-room-edit' => 'Edit Hostel Rooms',
            'hostel-room-delete' => 'Delete Hostel Rooms',
            
            'hostel-bed-view' => 'View Hostel Beds',
            'hostel-bed-create' => 'Create Hostel Beds',
            'hostel-bed-edit' => 'Edit Hostel Beds',
            'hostel-bed-delete' => 'Delete Hostel Beds',
            
            'hostel-allocation-view' => 'View Student Allocations',
            'hostel-allocation-create' => 'Create Student Allocations',
            'hostel-allocation-edit' => 'Edit Student Allocations',
            'hostel-allocation-delete' => 'Delete Student Allocations',
            
            'hostel-fee-structure-view' => 'View Fee Structures',
            'hostel-fee-structure-create' => 'Create Fee Structures',
            'hostel-fee-structure-edit' => 'Edit Fee Structures',
            'hostel-fee-structure-delete' => 'Delete Fee Structures',
            
            'hostel-payment-view' => 'View Hostel Payments',
            'hostel-payment-create' => 'Create Hostel Payments',
            'hostel-payment-edit' => 'Edit Hostel Payments',
            'hostel-payment-delete' => 'Delete Hostel Payments',
            
            'hostel-maintenance-view' => 'View Maintenance Records',
            'hostel-maintenance-create' => 'Create Maintenance Records',
            'hostel-maintenance-edit' => 'Edit Maintenance Records',
            'hostel-maintenance-delete' => 'Delete Maintenance Records',
            
            'hostel-visitor-view' => 'View Visitor Records',
            'hostel-visitor-create' => 'Create Visitor Records',
            'hostel-visitor-edit' => 'Edit Visitor Records',
            'hostel-visitor-delete' => 'Delete Visitor Records',
            
            'hostel-reports-view' => 'View Hostel Reports',
        ];

        // Insert permissions into the database
        foreach ($permissions as $name => $display_name) {
            // Check if permission already exists
            $existingPermission = DB::table('permissions')
                ->where('name', $name)
                ->first();

            if (!$existingPermission) {
                DB::table('permissions')->insert([
                    'name' => $name,
                    'display_name' => $display_name,
                    'description' => $display_name,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
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
    public function down()
    {
        // Remove hostel management permissions
        $permissions = [
            'HOSTEL_MANAGEMENT',
            'hostel-administration',
            'hostel-view',
            'hostel-create',
            'hostel-edit',
            'hostel-delete',
            'hostel-block-view',
            'hostel-block-create',
            'hostel-block-edit',
            'hostel-block-delete',
            'hostel-room-view',
            'hostel-room-create',
            'hostel-room-edit',
            'hostel-room-delete',
            'hostel-bed-view',
            'hostel-bed-create',
            'hostel-bed-edit',
            'hostel-bed-delete',
            'hostel-allocation-view',
            'hostel-allocation-create',
            'hostel-allocation-edit',
            'hostel-allocation-delete',
            'hostel-fee-structure-view',
            'hostel-fee-structure-create',
            'hostel-fee-structure-edit',
            'hostel-fee-structure-delete',
            'hostel-payment-view',
            'hostel-payment-create',
            'hostel-payment-edit',
            'hostel-payment-delete',
            'hostel-maintenance-view',
            'hostel-maintenance-create',
            'hostel-maintenance-edit',
            'hostel-maintenance-delete',
            'hostel-visitor-view',
            'hostel-visitor-create',
            'hostel-visitor-edit',
            'hostel-visitor-delete',
            'hostel-reports-view'
        ];

        DB::table('permissions')->whereIn('name', $permissions)->delete();
    }
}
