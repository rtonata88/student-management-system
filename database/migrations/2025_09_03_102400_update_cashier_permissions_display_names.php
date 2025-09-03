<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class UpdateCashierPermissionsDisplayNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            'view-cashier' => [
                'display_name' => 'View Cashier',
                'description' => 'Allows users to view the cashier interface'
            ],
            'access-cashier' => [
                'display_name' => 'Access Cashier',
                'description' => 'Allows users to access cashier functionality'
            ],
            'process-cashier-payments' => [
                'display_name' => 'Process Cashier Payments',
                'description' => 'Allows users to process payments through the cashier system'
            ],
            'view-cashier-receipts' => [
                'display_name' => 'View Cashier Receipts',
                'description' => 'Allows users to view payment receipts'
            ],
            'print-cashier-receipts' => [
                'display_name' => 'Print Cashier Receipts',
                'description' => 'Allows users to print payment receipts'
            ],
            'manage-cashier-operations' => [
                'display_name' => 'Manage Cashier Operations',
                'description' => 'Full management access to cashier system including all operations'
            ]
        ];

        foreach ($permissions as $name => $data) {
            Permission::where('name', $name)->update([
                'display_name' => $data['display_name'],
                'description' => $data['description']
            ]);
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
            'view-cashier',
            'access-cashier',
            'process-cashier-payments',
            'view-cashier-receipts',
            'print-cashier-receipts',
            'manage-cashier-operations'
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->update([
                'display_name' => null,
                'description' => null
            ]);
        }
    }
}
