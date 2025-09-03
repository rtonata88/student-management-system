<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFuelReceiptFieldsToTripLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trip_logs', function (Blueprint $table) {
            // Add fuel fill-up question and receipt upload field
            $table->enum('fuel_filled_up', ['yes', 'no'])->nullable()->after('passenger_count');
            $table->string('fuel_receipt_path')->nullable()->after('receipt_number');
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
            $table->dropColumn(['fuel_filled_up', 'fuel_receipt_path']);
        });
    }
}
