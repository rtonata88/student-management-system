<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ComprehensiveTripLogsFix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First, ensure the trip_logs table exists
        if (!Schema::hasTable('trip_logs')) {
            Schema::create('trip_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('vehicle_id');
                $table->unsignedBigInteger('driver_id');
                $table->string('destination');
                $table->datetime('departure_time');
                $table->datetime('arrival_time')->nullable();
                $table->integer('departure_odometer');
                $table->integer('arrival_odometer')->nullable();
                $table->timestamps();
            });
        }

        // Now add all missing columns with proper existence checks
        if (Schema::hasTable('trip_logs')) {
            Schema::table('trip_logs', function (Blueprint $table) {
                // Core missing columns
                if (!Schema::hasColumn('trip_logs', 'fuel_consumed')) {
                    $table->decimal('fuel_consumed', 8, 2)->nullable()->after('arrival_odometer');
                }
                
                if (!Schema::hasColumn('trip_logs', 'route_taken')) {
                    $table->text('route_taken')->nullable()->after('destination');
                }
                
                if (!Schema::hasColumn('trip_logs', 'estimated_distance')) {
                    $table->decimal('estimated_distance', 8, 2)->nullable()->after('route_taken');
                }
                
                if (!Schema::hasColumn('trip_logs', 'passengers_count')) {
                    $table->integer('passengers_count')->nullable()->after('estimated_distance');
                }
                
                if (!Schema::hasColumn('trip_logs', 'notes')) {
                    $table->text('notes')->nullable()->after('passengers_count');
                }
                
                if (!Schema::hasColumn('trip_logs', 'expected_return_time')) {
                    $table->datetime('expected_return_time')->nullable()->after('departure_time');
                }
            });

            // Add fuel-related columns in a separate schema call to avoid dependency issues
            Schema::table('trip_logs', function (Blueprint $table) {
                if (!Schema::hasColumn('trip_logs', 'fuel_cost_per_liter')) {
                    $table->decimal('fuel_cost_per_liter', 8, 2)->nullable()->after('fuel_consumed');
                }
                
                if (!Schema::hasColumn('trip_logs', 'total_fuel_cost')) {
                    $table->decimal('total_fuel_cost', 10, 2)->nullable()->after('fuel_cost_per_liter');
                }
                
                if (!Schema::hasColumn('trip_logs', 'fuel_receipt_number')) {
                    $table->string('fuel_receipt_number')->nullable()->after('total_fuel_cost');
                }
                
                if (!Schema::hasColumn('trip_logs', 'fuel_station_name')) {
                    $table->string('fuel_station_name')->nullable()->after('fuel_receipt_number');
                }
                
                if (!Schema::hasColumn('trip_logs', 'fuel_liters')) {
                    $table->decimal('fuel_liters', 8, 2)->nullable()->after('fuel_station_name');
                }
                
                if (!Schema::hasColumn('trip_logs', 'fuel_town_city')) {
                    $table->string('fuel_town_city')->nullable()->after('fuel_liters');
                }
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
        if (Schema::hasTable('trip_logs')) {
            Schema::table('trip_logs', function (Blueprint $table) {
                $columns = [
                    'fuel_consumed', 'route_taken', 'estimated_distance', 'passengers_count', 
                    'notes', 'expected_return_time', 'fuel_cost_per_liter', 'total_fuel_cost', 
                    'fuel_receipt_number', 'fuel_station_name', 'fuel_liters', 'fuel_town_city'
                ];
                
                foreach ($columns as $column) {
                    if (Schema::hasColumn('trip_logs', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
}
