<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToVehicleServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('vehicle_services') && !Schema::hasColumn('vehicle_services', 'description')) {
            Schema::table('vehicle_services', function (Blueprint $table) {
                $table->text('description')->after('service_provider');
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
        if (Schema::hasTable('vehicle_services') && Schema::hasColumn('vehicle_services', 'description')) {
            Schema::table('vehicle_services', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }
    }
}
