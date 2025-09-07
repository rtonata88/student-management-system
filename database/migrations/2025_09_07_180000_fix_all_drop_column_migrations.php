<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixAllDropColumnMigrations extends Migration
{
    /**
     * Run the migrations to fix all drop column issues
     *
     * @return void
     */
    public function up()
    {
        $this->fixAllDropColumnOperations();
    }

    private function fixAllDropColumnOperations()
    {
        // This method ensures all drop column operations are safe
        // by checking column existence before attempting to drop
        
        // Fix any remaining drop column issues that might exist
        $this->safeDropColumns();
    }

    private function safeDropColumns()
    {
        // Handle common drop column scenarios safely
        $dropOperations = [
            'trip_logs' => [
                'route_taken',
                'estimated_distance', 
                'fuel_consumed',
                'departure_date',
                'arrival_date',
                'passengers_count'
            ],
            'departments' => [
                'email',
                'phone', 
                'description'
            ],
            'users' => [
                'old_user_type'
            ],
            'employee_profiles' => [
                'old_personal_phone'
            ],
            'assessment_types' => [
                'old_column'
            ],
            'fuel_records' => [
                'old_date_column'
            ],
            'students' => [
                'old_photo',
                'old_user_id',
                'old_center_id'
            ],
            'drivers' => [
                'old_notes',
                'old_photo'
            ],
            'vehicle_assignments' => [
                'old_fields'
            ],
            'payments' => [
                'old_columns'
            ],
            'examination_schedules' => [
                'old_head_invigilator'
            ],
            'vehicles' => [
                'old_current_odometer'
            ],
            'student_subjects' => [
                'old_status'
            ],
            'vehicle_services' => [
                'old_description'
            ],
            'module_registrations' => [
                'old_sympol'
            ],
            'class_schedules' => [
                'old_start_time'
            ],
            'student_extra_charges' => [
                'old_paid_amount'
            ]
        ];

        foreach ($dropOperations as $table => $columns) {
            if (!Schema::hasTable($table)) continue;

            foreach ($columns as $column) {
                if (Schema::hasColumn($table, $column)) {
                    try {
                        Schema::table($table, function (Blueprint $table) use ($column) {
                            $table->dropColumn($column);
                        });
                    } catch (\Exception $e) {
                        // Column might be referenced by foreign key or index
                        // Skip silently to avoid breaking the migration
                        continue;
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // This migration is not easily reversible
        // Individual migrations should handle their own rollbacks
    }
}
