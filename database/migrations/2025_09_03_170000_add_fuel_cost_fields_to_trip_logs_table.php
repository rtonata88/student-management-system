<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFuelCostFieldsToTripLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trip_logs', function (Blueprint $table) {
            // Add fuel cost related fields
            $table->string('fuel_type')->nullable()->after('fuel_consumed');
            $table->decimal('price_per_liter', 8, 3)->nullable()->after('fuel_type');
            $table->decimal('total_fuel_cost', 10, 2)->nullable()->after('price_per_liter');
            $table->string('fuel_station')->nullable()->after('total_fuel_cost');
            $table->string('receipt_number')->nullable()->after('fuel_station');
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
            $table->dropColumn([
                'fuel_type',
                'price_per_liter', 
                'total_fuel_cost',
                'fuel_station',
                'receipt_number'
            ]);
        });
    }
}
