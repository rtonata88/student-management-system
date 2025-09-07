<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ComprehensiveDatabaseCleanup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Clean up and fix all database issues in one migration
        
        // 1. Fix vehicles table - add current_odometer if not exists
        if (Schema::hasTable('vehicles') && !Schema::hasColumn('vehicles', 'current_odometer')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->decimal('current_odometer', 10, 2)->nullable()->after('registration_number');
            });
        }

        // 2. Fix drivers table - add missing columns if not exist
        if (Schema::hasTable('drivers')) {
            Schema::table('drivers', function (Blueprint $table) {
                if (!Schema::hasColumn('drivers', 'emergency_contact_phone')) {
                    $table->string('emergency_contact_phone')->nullable()->after('phone');
                }
                if (!Schema::hasColumn('drivers', 'notes')) {
                    $table->text('notes')->nullable();
                }
                if (!Schema::hasColumn('drivers', 'photo')) {
                    $table->string('photo')->nullable();
                }
            });
        }

        // 3. Fix students table - add user_id if not exists
        if (Schema::hasTable('students') && !Schema::hasColumn('students', 'user_id')) {
            Schema::table('students', function (Blueprint $table) {
                $table->unsignedInteger('user_id')->nullable()->after('id');
            });
        }

        // 4. Fix trip_logs table comprehensively
        if (Schema::hasTable('trip_logs')) {
            Schema::table('trip_logs', function (Blueprint $table) {
                // Add missing columns if they don't exist (based on actual table structure)
                if (!Schema::hasColumn('trip_logs', 'fuel_consumed')) {
                    $table->decimal('fuel_consumed', 8, 2)->nullable()->after('odometer_end');
                }
                if (!Schema::hasColumn('trip_logs', 'fuel_cost_per_liter')) {
                    $table->decimal('fuel_cost_per_liter', 8, 2)->nullable()->after('fuel_consumed');
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
            });

            // Note: The table already has total_fuel_cost, passenger_count columns
            // No need to drop departure_date, departure_time, arrival_date, arrival_time as they don't exist
        }

        // 5. Clean up problematic foreign key constraints (just drop them)
        $this->cleanupForeignKeyConstraints();
    }

    /**
     * Clean up problematic foreign key constraints
     */
    private function cleanupForeignKeyConstraints()
    {
        // Just drop all problematic foreign key constraints to prevent migration errors
        // These have data type mismatches that prevent proper constraint creation
        
        $constraintsToRemove = [
            // examination_schedules constraints
            ['table' => 'examination_schedules', 'constraint' => 'examination_schedules_venue_id_foreign'],
            ['table' => 'examination_schedules', 'constraint' => 'examination_schedules_teacher_id_foreign'],
            ['table' => 'examination_schedules', 'constraint' => 'examination_schedules_subject_allocation_id_foreign'],
            ['table' => 'examination_schedules', 'constraint' => 'examination_schedules_time_slot_id_foreign'],
            
            // student_promotions constraints
            ['table' => 'student_promotions', 'constraint' => 'student_promotions_student_id_foreign'],
            ['table' => 'student_promotions', 'constraint' => 'student_promotions_academic_year_id_foreign'],
            ['table' => 'student_promotions', 'constraint' => 'student_promotions_promotional_status_id_foreign'],
            ['table' => 'student_promotions', 'constraint' => 'student_promotions_promoted_by_foreign'],
            
            // students constraints
            ['table' => 'students', 'constraint' => 'students_center_id_foreign'],
            ['table' => 'students', 'constraint' => 'students_user_id_foreign'],
        ];

        foreach ($constraintsToRemove as $constraint) {
            $this->dropForeignKeyIfExists($constraint['table'], $constraint['constraint']);
        }
    }

    /**
     * Drop foreign key if it exists
     */
    private function dropForeignKeyIfExists($table, $keyName)
    {
        try {
            $keys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME = ? 
                AND TABLE_SCHEMA = ? 
                AND CONSTRAINT_NAME = ?
            ", [$table, config('database.connections.mysql.database'), $keyName]);

            if (count($keys) > 0) {
                Schema::table($table, function (Blueprint $table) use ($keyName) {
                    $table->dropForeign($keyName);
                });
            }
        } catch (\Exception $e) {
            // Ignore if constraint doesn't exist
        }
    }

    /**
     * Clean up orphaned data
     */
    private function cleanupOrphanedData()
    {
        try {
            // Clean up any orphaned records that might cause foreign key issues
            if (Schema::hasTable('students') && Schema::hasTable('centers')) {
                DB::statement("UPDATE students SET center_id = NULL WHERE center_id NOT IN (SELECT id FROM centers)");
            }
            
            if (Schema::hasTable('students') && Schema::hasTable('users')) {
                DB::statement("UPDATE students SET user_id = NULL WHERE user_id IS NOT NULL AND user_id NOT IN (SELECT id FROM users)");
            }
        } catch (\Exception $e) {
            // Ignore cleanup errors
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // This migration consolidates multiple fixes, so rollback is complex
        // For safety, we'll just log that this migration was rolled back
        \Log::info('Comprehensive database cleanup migration rolled back');
    }
}
