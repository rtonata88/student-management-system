<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UniversalTripLogsFix extends Migration
{
    /**
     * Run the migrations.
     * This migration is designed to work on ANY server regardless of current table state
     *
     * @return void
     */
    public function up()
    {
        try {
            // First, ensure the trip_logs table exists with all required columns
            if (!Schema::hasTable('trip_logs')) {
                // Create complete table if it doesn't exist
                Schema::create('trip_logs', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('vehicle_id');
                    $table->unsignedBigInteger('driver_id');
                    $table->string('destination');
                    $table->datetime('departure_time');
                    $table->datetime('arrival_time')->nullable();
                    $table->integer('departure_odometer');
                    $table->integer('arrival_odometer')->nullable();
                    $table->decimal('fuel_consumed', 8, 2)->nullable();
                    $table->text('route_taken')->nullable();
                    $table->decimal('estimated_distance', 8, 2)->nullable();
                    $table->integer('passengers_count')->nullable();
                    $table->text('notes')->nullable();
                    $table->datetime('expected_return_time')->nullable();
                    $table->decimal('fuel_cost_per_liter', 8, 2)->nullable();
                    $table->decimal('total_fuel_cost', 10, 2)->nullable();
                    $table->string('fuel_receipt_number')->nullable();
                    $table->string('fuel_station_name')->nullable();
                    $table->decimal('fuel_liters', 8, 2)->nullable();
                    $table->string('fuel_town_city')->nullable();
                    $table->timestamps();
                    
                    // Add foreign key constraints if tables exist
                    if (Schema::hasTable('vehicles')) {
                        $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
                    }
                    if (Schema::hasTable('drivers')) {
                        $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
                    }
                });
                
                echo "Created trip_logs table with all columns.\n";
                return;
            }

            // If table exists, add missing columns individually
            $columnsToAdd = [
                'fuel_consumed' => ['type' => 'decimal', 'precision' => 8, 'scale' => 2, 'nullable' => true],
                'route_taken' => ['type' => 'text', 'nullable' => true],
                'estimated_distance' => ['type' => 'decimal', 'precision' => 8, 'scale' => 2, 'nullable' => true],
                'passengers_count' => ['type' => 'integer', 'nullable' => true],
                'notes' => ['type' => 'text', 'nullable' => true],
                'expected_return_time' => ['type' => 'datetime', 'nullable' => true],
                'fuel_cost_per_liter' => ['type' => 'decimal', 'precision' => 8, 'scale' => 2, 'nullable' => true],
                'total_fuel_cost' => ['type' => 'decimal', 'precision' => 10, 'scale' => 2, 'nullable' => true],
                'fuel_receipt_number' => ['type' => 'string', 'nullable' => true],
                'fuel_station_name' => ['type' => 'string', 'nullable' => true],
                'fuel_liters' => ['type' => 'decimal', 'precision' => 8, 'scale' => 2, 'nullable' => true],
                'fuel_town_city' => ['type' => 'string', 'nullable' => true]
            ];

            foreach ($columnsToAdd as $columnName => $config) {
                if (!Schema::hasColumn('trip_logs', $columnName)) {
                    try {
                        Schema::table('trip_logs', function (Blueprint $table) use ($columnName, $config) {
                            switch ($config['type']) {
                                case 'decimal':
                                    $column = $table->decimal($columnName, $config['precision'], $config['scale']);
                                    break;
                                case 'text':
                                    $column = $table->text($columnName);
                                    break;
                                case 'integer':
                                    $column = $table->integer($columnName);
                                    break;
                                case 'datetime':
                                    $column = $table->datetime($columnName);
                                    break;
                                case 'string':
                                default:
                                    $column = $table->string($columnName);
                                    break;
                            }
                            
                            if ($config['nullable']) {
                                $column->nullable();
                            }
                        });
                        echo "Added column: {$columnName}\n";
                    } catch (Exception $e) {
                        echo "Warning: Could not add column {$columnName}: " . $e->getMessage() . "\n";
                        // Continue with other columns
                    }
                } else {
                    echo "Column {$columnName} already exists.\n";
                }
            }

            // Ensure foreign key constraints exist if possible
            try {
                if (Schema::hasTable('vehicles') && Schema::hasTable('drivers')) {
                    // Check if foreign keys exist, add if they don't
                    $foreignKeys = DB::select("
                        SELECT CONSTRAINT_NAME 
                        FROM information_schema.KEY_COLUMN_USAGE 
                        WHERE TABLE_SCHEMA = DATABASE() 
                        AND TABLE_NAME = 'trip_logs' 
                        AND REFERENCED_TABLE_NAME IS NOT NULL
                    ");
                    
                    $existingConstraints = array_column($foreignKeys, 'CONSTRAINT_NAME');
                    
                    if (!in_array('trip_logs_vehicle_id_foreign', $existingConstraints)) {
                        Schema::table('trip_logs', function (Blueprint $table) {
                            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
                        });
                        echo "Added vehicle_id foreign key constraint.\n";
                    }
                    
                    if (!in_array('trip_logs_driver_id_foreign', $existingConstraints)) {
                        Schema::table('trip_logs', function (Blueprint $table) {
                            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
                        });
                        echo "Added driver_id foreign key constraint.\n";
                    }
                }
            } catch (Exception $e) {
                echo "Warning: Could not add foreign key constraints: " . $e->getMessage() . "\n";
            }

            echo "Trip logs table migration completed successfully.\n";

        } catch (Exception $e) {
            echo "Migration error: " . $e->getMessage() . "\n";
            throw $e;
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
            try {
                // Drop foreign key constraints first
                Schema::table('trip_logs', function (Blueprint $table) {
                    try {
                        $table->dropForeign(['vehicle_id']);
                    } catch (Exception $e) {
                        // Constraint might not exist
                    }
                    try {
                        $table->dropForeign(['driver_id']);
                    } catch (Exception $e) {
                        // Constraint might not exist
                    }
                });

                // Drop columns if they exist
                $columnsToRemove = [
                    'fuel_consumed', 'route_taken', 'estimated_distance', 'passengers_count', 
                    'notes', 'expected_return_time', 'fuel_cost_per_liter', 'total_fuel_cost', 
                    'fuel_receipt_number', 'fuel_station_name', 'fuel_liters', 'fuel_town_city'
                ];
                
                Schema::table('trip_logs', function (Blueprint $table) use ($columnsToRemove) {
                    foreach ($columnsToRemove as $column) {
                        if (Schema::hasColumn('trip_logs', $column)) {
                            $table->dropColumn($column);
                        }
                    }
                });
                
                echo "Rollback completed successfully.\n";
            } catch (Exception $e) {
                echo "Rollback error: " . $e->getMessage() . "\n";
            }
        }
    }
}
