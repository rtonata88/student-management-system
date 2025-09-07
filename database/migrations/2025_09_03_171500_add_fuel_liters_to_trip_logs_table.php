<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFuelLitersToTripLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('trip_logs') && !Schema::hasColumn('trip_logs', 'fuel_liters')) {
            Schema::table('trip_logs', function (Blueprint $table) {
            $table->decimal('fuel_liters', 8, 2)->nullable()->after('fuel_type');
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
            $table->dropColumn('fuel_liters');
        });
    }
}
