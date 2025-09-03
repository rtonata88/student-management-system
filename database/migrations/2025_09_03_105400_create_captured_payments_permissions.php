<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateCapturedPaymentsPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create captured payments permissions with display names and descriptions
        $permissions = [
            [
                'name' => 'view-captured-payments',
                'display_name' => 'View Captured Payments',
                'description' => 'Access to view captured payments from both cashier and manual systems'
            ],
            [
                'name' => 'search-captured-payments',
                'display_name' => 'Search Captured Payments',
                'description' => 'Ability to search and filter captured payments by various criteria'
            ],
            [
                'name' => 'reprint-payment-receipts',
                'display_name' => 'Reprint Payment Receipts',
                'description' => 'Permission to reprint receipts for captured payments'
            ],
            [
                'name' => 'export-captured-payments',
                'display_name' => 'Export Captured Payments',
                'description' => 'Ability to export captured payments data to CSV format'
            ],
            [
                'name' => 'manage-captured-payments',
                'display_name' => 'Manage Captured Payments',
                'description' => 'Full management access to captured payments system'
            ]
        ];

        foreach ($permissions as $permission) {
            try {
                if (!Permission::where('name', $permission['name'])->exists()) {
                    Permission::create($permission);
                } else {
                    // Update existing permission with display name and description
                    Permission::where('name', $permission['name'])->update([
                        'display_name' => $permission['display_name'],
                        'description' => $permission['description']
                    ]);
                }
            } catch (\Exception $e) {
                // Permission might already exist, continue
                continue;
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
            'view-captured-payments',
            'search-captured-payments',
            'reprint-payment-receipts', 
            'export-captured-payments',
            'manage-captured-payments'
        ];

        Permission::whereIn('name', $permissions)->delete();
    }
}
