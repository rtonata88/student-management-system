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
        if (!Schema::hasTable('trip_logs')) return;

        Schema::table('trip_logs', function (Blueprint $table) {
            $columnsToDrop = [];
            
            if (Schema::hasColumn('trip_logs', 'route_taken')) {
                $columnsToDrop[] = 'route_taken';
            }
            if (Schema::hasColumn('trip_logs', 'estimated_distance')) {
                $columnsToDrop[] = 'estimated_distance';
            }
            if (Schema::hasColumn('trip_logs', 'fuel_consumed')) {
                $columnsToDrop[] = 'fuel_consumed';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('trip_logs')) return;

        Schema::table('trip_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('trip_logs', 'route_taken')) {
                $table->text('route_taken')->nullable();
            }
            if (!Schema::hasColumn('trip_logs', 'estimated_distance')) {
                $table->decimal('estimated_distance', 8, 2)->nullable();
            }
            if (!Schema::hasColumn('trip_logs', 'fuel_consumed')) {
                $table->decimal('fuel_consumed', 8, 2)->nullable();
            }
        });
    }
}
