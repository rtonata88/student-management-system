<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Permission;

class CreateVoidPaymentPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            // Create void payment permission
            if (!Permission::where('name', 'void-payments')->exists()) {
                Permission::create([
                    'name' => 'void-payments',
                    'display_name' => 'Void Payments',
                    'description' => 'Allow user to void/reverse payment transactions'
                ]);
            }
        } catch (\Exception $e) {
            // Permission might already exist, continue
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {
            Permission::where('name', 'void-payments')->delete();
        } catch (\Exception $e) {
            // Continue if permission doesn't exist
        }
    }
}
