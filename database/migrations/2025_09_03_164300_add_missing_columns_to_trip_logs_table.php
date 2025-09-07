<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToTripLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('trip_logs')) return;

        // First, safely drop old columns if they exist
        Schema::table('trip_logs', function (Blueprint $table) {
            $columnsToDrop = [];
            
            if (Schema::hasColumn('trip_logs', 'departure_date')) {
                $columnsToDrop[] = 'departure_date';
            }
            if (Schema::hasColumn('trip_logs', 'arrival_date')) {
                $columnsToDrop[] = 'arrival_date';
            }
            if (Schema::hasColumn('trip_logs', 'passengers_count')) {
                $columnsToDrop[] = 'passengers_count';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
        
        Schema::table('trip_logs', function (Blueprint $table) {
            // Add new datetime columns if they don't exist
            if (!Schema::hasColumn('trip_logs', 'departure_time')) {
                $table->datetime('departure_time')->after('trip_purpose');
            }
            if (!Schema::hasColumn('trip_logs', 'expected_return_time')) {
                $table->datetime('expected_return_time')->nullable()->after('departure_time');
            }
            if (!Schema::hasColumn('trip_logs', 'arrival_time')) {
                $table->datetime('arrival_time')->nullable()->after('expected_return_time');
            }
            
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('trip_logs', 'estimated_distance')) {
                $table->decimal('estimated_distance', 8, 2)->nullable()->after('end_odometer');
            }
            if (!Schema::hasColumn('trip_logs', 'passenger_count')) {
                $table->integer('passenger_count')->nullable()->after('estimated_distance');
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
            $columnsToDrop = [];
            
            // Check which columns exist before dropping
            if (Schema::hasColumn('trip_logs', 'departure_time')) {
                $columnsToDrop[] = 'departure_time';
            }
            if (Schema::hasColumn('trip_logs', 'expected_return_time')) {
                $columnsToDrop[] = 'expected_return_time';
            }
            if (Schema::hasColumn('trip_logs', 'arrival_time')) {
                $columnsToDrop[] = 'arrival_time';
            }
            if (Schema::hasColumn('trip_logs', 'estimated_distance')) {
                $columnsToDrop[] = 'estimated_distance';
            }
            if (Schema::hasColumn('trip_logs', 'passenger_count')) {
                $columnsToDrop[] = 'passenger_count';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
        
        Schema::table('trip_logs', function (Blueprint $table) {
            // Restore original columns if they don't exist
            if (!Schema::hasColumn('trip_logs', 'departure_date')) {
                $table->date('departure_date')->after('trip_purpose');
            }
            if (!Schema::hasColumn('trip_logs', 'departure_time')) {
                $table->time('departure_time')->after('departure_date');
            }
            if (!Schema::hasColumn('trip_logs', 'arrival_date')) {
                $table->date('arrival_date')->nullable()->after('odometer_end');
            }
            if (!Schema::hasColumn('trip_logs', 'arrival_time')) {
                $table->time('arrival_time')->nullable()->after('arrival_date');
            }
            if (!Schema::hasColumn('trip_logs', 'passengers_count')) {
                $table->integer('passengers_count')->nullable()->after('fuel_consumed');
            }
        });
    }
}
