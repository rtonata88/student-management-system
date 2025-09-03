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
        Schema::table('trip_logs', function (Blueprint $table) {
            // First, drop the old columns
            $table->dropColumn(['departure_date', 'departure_time', 'arrival_date', 'arrival_time', 'passengers_count']);
        });
        
        Schema::table('trip_logs', function (Blueprint $table) {
            // Add new datetime columns
            $table->datetime('departure_time')->after('trip_purpose');
            $table->datetime('expected_return_time')->nullable()->after('departure_time');
            $table->datetime('arrival_time')->nullable()->after('expected_return_time');
            
            // Add missing columns
            $table->decimal('estimated_distance', 8, 2)->nullable()->after('route_taken');
            $table->integer('passenger_count')->nullable()->after('estimated_distance');
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
            // Reverse the changes
            $table->dropColumn(['departure_time', 'expected_return_time', 'arrival_time', 'estimated_distance', 'passenger_count']);
            
            // Restore original columns
            $table->date('departure_date')->after('trip_purpose');
            $table->time('departure_time')->after('departure_date');
            $table->date('arrival_date')->nullable()->after('odometer_end');
            $table->time('arrival_time')->nullable()->after('arrival_date');
            $table->integer('passengers_count')->nullable()->after('fuel_consumed');
        });
    }
}
