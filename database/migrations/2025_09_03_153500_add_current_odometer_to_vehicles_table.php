<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrentOdometerToVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('vehicles') && !Schema::hasColumn('vehicles', 'current_odometer')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->integer('current_odometer')->default(0)->after('license_expiry');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('vehicles') && Schema::hasColumn('vehicles', 'current_odometer')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->dropColumn('current_odometer');
            });
        }
    }
}
