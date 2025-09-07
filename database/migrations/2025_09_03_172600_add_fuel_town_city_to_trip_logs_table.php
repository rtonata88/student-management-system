<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFuelTownCityToTripLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('trip_logs') && !Schema::hasColumn('trip_logs', 'fuel_town_city')) {
            Schema::table('trip_logs', function (Blueprint $table) {
            $table->string('fuel_town_city')->nullable()->after('fuel_station');
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
        Schema::table('trip_logs', function (Blueprint $table) {
            $table->dropColumn('fuel_town_city');
        });
    }
}
