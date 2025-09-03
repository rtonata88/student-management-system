<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUnnecessaryColumnsFromTripLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trip_logs', function (Blueprint $table) {
            $table->dropColumn(['route_taken', 'estimated_distance', 'fuel_consumed']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trip_logs', function (Blueprint $table) {
            $table->text('route_taken')->nullable();
            $table->decimal('estimated_distance', 8, 2)->nullable();
            $table->decimal('fuel_consumed', 8, 2)->nullable();
        });
    }
}
