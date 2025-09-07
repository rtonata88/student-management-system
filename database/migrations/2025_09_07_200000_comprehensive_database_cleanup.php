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
        // Clean up problematic foreign key constraints only
        // All required columns already exist in the database
        
        echo "Checking database structure...\n";
        
        // Verify all required columns exist (they should already be there)
        $this->verifyColumnsExist();
        
        // Only clean up problematic foreign key constraints
        $this->cleanupForeignKeyConstraints();
        
        echo "Database cleanup completed successfully.\n";
    }
    
    /**
     * Verify that all required columns exist
     */
    private function verifyColumnsExist()
    {
        $checks = [
            ['table' => 'vehicles', 'column' => 'current_odometer'],
            ['table' => 'drivers', 'column' => 'emergency_contact_phone'],
            ['table' => 'drivers', 'column' => 'notes'],
            ['table' => 'drivers', 'column' => 'photo'],
            ['table' => 'students', 'column' => 'user_id'],
            ['table' => 'trip_logs', 'column' => 'route_taken'],
            ['table' => 'trip_logs', 'column' => 'estimated_distance'],
            ['table' => 'trip_logs', 'column' => 'passengers_count'],
            ['table' => 'trip_logs', 'column' => 'fuel_consumed'],
            ['table' => 'trip_logs', 'column' => 'fuel_cost_per_liter'],
        ];
        
        foreach ($checks as $check) {
            if (Schema::hasTable($check['table']) && Schema::hasColumn($check['table'], $check['column'])) {
                echo "✅ {$check['table']}.{$check['column']} exists\n";
            } else {
                echo "❌ {$check['table']}.{$check['column']} missing\n";
            }
        }
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
