<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixFuelRecordsDateColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('fuel_records') && Schema::hasColumn('fuel_records', 'date') && !Schema::hasColumn('fuel_records', 'fuel_date')) {
            // Rename 'date' column to 'fuel_date'
            Schema::table('fuel_records', function (Blueprint $table) {
                $table->renameColumn('date', 'fuel_date');
            });
        }

        // Also ensure we have the missing columns that should be in fuel_records
        if (Schema::hasTable('fuel_records')) {
            Schema::table('fuel_records', function (Blueprint $table) {
                // Add missing columns if they don't exist
                if (!Schema::hasColumn('fuel_records', 'liters')) {
                    $table->decimal('liters', 8, 2)->after('fuel_date');
                }
                if (!Schema::hasColumn('fuel_records', 'cost_per_liter')) {
                    $table->decimal('cost_per_liter', 8, 2)->after('liters');
                }
                
                // Remove columns that shouldn't be there
                if (Schema::hasColumn('fuel_records', 'driver_id')) {
                    $table->dropColumn('driver_id');
                }
                if (Schema::hasColumn('fuel_records', 'fuel_type')) {
                    $table->dropColumn('fuel_type');
                }
                if (Schema::hasColumn('fuel_records', 'quantity')) {
                    $table->dropColumn('quantity');
                }
                if (Schema::hasColumn('fuel_records', 'price_per_liter')) {
                    $table->dropColumn('price_per_liter');
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
        if (Schema::hasTable('fuel_records') && Schema::hasColumn('fuel_records', 'fuel_date')) {
            Schema::table('fuel_records', function (Blueprint $table) {
                $table->renameColumn('fuel_date', 'date');
            });
        }
    }
}
