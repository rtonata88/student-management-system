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
            // Add new fuel_date column and copy data from date column
            Schema::table('fuel_records', function (Blueprint $table) {
                $table->date('fuel_date')->nullable()->after('id');
            });
            
            // Copy data from date to fuel_date
            DB::statement('UPDATE fuel_records SET fuel_date = date WHERE date IS NOT NULL');
            
            // Drop the old date column
            Schema::table('fuel_records', function (Blueprint $table) {
                $table->dropColumn('date');
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
                
                // Remove columns that shouldn't be there (handle foreign keys carefully)
                try {
                    if (Schema::hasColumn('fuel_records', 'driver_id')) {
                        // Try to drop foreign key constraint if it exists
                        DB::statement('ALTER TABLE fuel_records DROP FOREIGN KEY fuel_records_driver_id_foreign');
                    }
                } catch (Exception $e) {
                    // Foreign key might not exist or have different name, continue
                }
                
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
            // Add back the date column
            Schema::table('fuel_records', function (Blueprint $table) {
                $table->date('date')->nullable()->after('id');
            });
            
            // Copy data back from fuel_date to date
            DB::statement('UPDATE fuel_records SET date = fuel_date WHERE fuel_date IS NOT NULL');
            
            // Drop the fuel_date column
            Schema::table('fuel_records', function (Blueprint $table) {
                $table->dropColumn('fuel_date');
            });
        }
    }
}
