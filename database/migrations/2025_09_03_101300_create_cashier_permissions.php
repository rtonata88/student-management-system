<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateCashierPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
            Permission::create(['name' => $permission]);
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

        Permission::whereIn('name', $permissions)->delete();
    }
}
