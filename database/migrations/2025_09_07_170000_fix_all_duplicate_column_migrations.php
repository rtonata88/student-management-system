<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixAllDuplicateColumnMigrations extends Migration
{
    /**
     * Run the migrations to fix all duplicate column issues
     *
     * @return void
     */
    public function up()
    {
        $this->fixStudentsTable();
        $this->fixUsersTable();
        $this->fixClassSchedulesTable();
        $this->fixExaminationSchedulesTable();
        $this->fixStudentSubjectsTable();
        $this->fixVehiclesTable();
        $this->fixDriversTable();
        $this->fixTripLogsTable();
        $this->fixVehicleServicesTable();
        $this->fixVehicleAssignmentsTable();
        $this->fixEmployeeProfilesTable();
        $this->fixStudentExtraChargesTable();
    }

    private function fixStudentsTable()
    {
        if (!Schema::hasTable('students')) return;

        // Fix center_id
        if (!Schema::hasColumn('students', 'center_id')) {
            Schema::table('students', function (Blueprint $table) {
                $table->unsignedInteger('center_id')->nullable()->after('student_names');
            });
        }

        // Fix photo
        if (!Schema::hasColumn('students', 'photo')) {
            Schema::table('students', function (Blueprint $table) {
                $table->string('photo')->nullable()->after('birth_certificate');
            });
        }

        // Fix user_id
        if (!Schema::hasColumn('students', 'user_id')) {
            Schema::table('students', function (Blueprint $table) {
                $table->unsignedInteger('user_id')->nullable()->after('student_names');
            });
        }
    }

    private function fixUsersTable()
    {
        if (!Schema::hasTable('users')) return;

        // Fix user_type
        if (!Schema::hasColumn('users', 'user_type')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('user_type')->default('student')->after('password');
            });
        }

        // Fix email_verified_at if missing
        if (!Schema::hasColumn('users', 'email_verified_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            });
        }

        // Fix remember_token if missing
        if (!Schema::hasColumn('users', 'remember_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->rememberToken();
            });
        }
    }

    private function fixClassSchedulesTable()
    {
        if (!Schema::hasTable('class_schedules')) return;

        // Fix start_time
        if (!Schema::hasColumn('class_schedules', 'start_time')) {
            Schema::table('class_schedules', function (Blueprint $table) {
                $table->time('start_time')->nullable()->after('day_of_week');
            });
        }
    }

    private function fixExaminationSchedulesTable()
    {
        if (!Schema::hasTable('examination_schedules')) return;

        // Fix head_invigilator_id
        if (!Schema::hasColumn('examination_schedules', 'head_invigilator_id')) {
            Schema::table('examination_schedules', function (Blueprint $table) {
                $table->unsignedBigInteger('head_invigilator_id')->nullable()->after('class_duration_id');
                $table->index(['head_invigilator_id', 'exam_date', 'class_duration_id']);
            });
        }
    }

    private function fixStudentSubjectsTable()
    {
        if (!Schema::hasTable('student_subjects')) return;

        // Fix status
        if (!Schema::hasColumn('student_subjects', 'status')) {
            Schema::table('student_subjects', function (Blueprint $table) {
                $table->enum('status', ['active', 'inactive', 'completed', 'dropped'])->default('active')->after('subject_id');
            });
        }
    }

    private function fixVehiclesTable()
    {
        if (!Schema::hasTable('vehicles')) return;

        // Fix current_odometer
        if (!Schema::hasColumn('vehicles', 'current_odometer')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->integer('current_odometer')->default(0)->after('license_expiry');
            });
        }
    }

    private function fixDriversTable()
    {
        if (!Schema::hasTable('drivers')) return;

        // Fix notes
        if (!Schema::hasColumn('drivers', 'notes')) {
            Schema::table('drivers', function (Blueprint $table) {
                $table->text('notes')->nullable()->after('status');
            });
        }

        // Fix photo
        if (!Schema::hasColumn('drivers', 'photo')) {
            Schema::table('drivers', function (Blueprint $table) {
                $table->string('photo')->nullable()->after('notes');
            });
        }
    }

    private function fixTripLogsTable()
    {
        if (!Schema::hasTable('trip_logs')) return;

        // Fix route_taken first (required for other columns)
        if (!Schema::hasColumn('trip_logs', 'route_taken')) {
            Schema::table('trip_logs', function (Blueprint $table) {
                $table->text('route_taken')->nullable()->after('destination');
            });
        }

        // Fix expected_return_time
        if (!Schema::hasColumn('trip_logs', 'expected_return_time')) {
            Schema::table('trip_logs', function (Blueprint $table) {
                $table->datetime('expected_return_time')->nullable()->after('departure_time');
            });
        }

        // Fix estimated_distance
        if (!Schema::hasColumn('trip_logs', 'estimated_distance')) {
            Schema::table('trip_logs', function (Blueprint $table) {
                $table->decimal('estimated_distance', 8, 2)->nullable()->after('route_taken');
            });
        }

        // Fix passengers_count
        if (!Schema::hasColumn('trip_logs', 'passengers_count')) {
            Schema::table('trip_logs', function (Blueprint $table) {
                $table->integer('passengers_count')->nullable()->after('estimated_distance');
            });
        }

        // Fix notes
        if (!Schema::hasColumn('trip_logs', 'notes')) {
            Schema::table('trip_logs', function (Blueprint $table) {
                $table->text('notes')->nullable()->after('passengers_count');
            });
        }

        // Fix fuel_cost_per_liter
        if (!Schema::hasColumn('trip_logs', 'fuel_cost_per_liter')) {
            Schema::table('trip_logs', function (Blueprint $table) {
                $table->decimal('fuel_cost_per_liter', 8, 2)->nullable()->after('fuel_consumed');
            });
        }

        // Fix total_fuel_cost
        if (!Schema::hasColumn('trip_logs', 'total_fuel_cost')) {
            Schema::table('trip_logs', function (Blueprint $table) {
                $table->decimal('total_fuel_cost', 10, 2)->nullable()->after('fuel_cost_per_liter');
            });
        }

        // Fix fuel_receipt_number
        if (!Schema::hasColumn('trip_logs', 'fuel_receipt_number')) {
            Schema::table('trip_logs', function (Blueprint $table) {
                $table->string('fuel_receipt_number')->nullable()->after('total_fuel_cost');
            });
        }

        // Fix fuel_station_name
        if (!Schema::hasColumn('trip_logs', 'fuel_station_name')) {
            Schema::table('trip_logs', function (Blueprint $table) {
                $table->string('fuel_station_name')->nullable()->after('fuel_receipt_number');
            });
        }

        // Fix fuel_liters
        if (!Schema::hasColumn('trip_logs', 'fuel_liters')) {
            Schema::table('trip_logs', function (Blueprint $table) {
                $table->decimal('fuel_liters', 8, 2)->nullable()->after('fuel_station_name');
            });
        }

        // Fix fuel_town_city
        if (!Schema::hasColumn('trip_logs', 'fuel_town_city')) {
            Schema::table('trip_logs', function (Blueprint $table) {
                $table->string('fuel_town_city')->nullable()->after('fuel_liters');
            });
        }
    }

    private function fixVehicleServicesTable()
    {
        if (!Schema::hasTable('vehicle_services')) return;

        // Fix description (might be duplicate with existing description)
        if (!Schema::hasColumn('vehicle_services', 'service_description')) {
            Schema::table('vehicle_services', function (Blueprint $table) {
                $table->text('service_description')->nullable()->after('description');
            });
        }
    }

    private function fixVehicleAssignmentsTable()
    {
        if (!Schema::hasTable('vehicle_assignments')) return;

        // Fix assignment_type
        if (!Schema::hasColumn('vehicle_assignments', 'assignment_type')) {
            Schema::table('vehicle_assignments', function (Blueprint $table) {
                $table->enum('assignment_type', ['permanent', 'temporary', 'backup'])->default('permanent')->after('is_primary');
            });
        }

        // Fix status
        if (!Schema::hasColumn('vehicle_assignments', 'status')) {
            Schema::table('vehicle_assignments', function (Blueprint $table) {
                $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('assignment_type');
            });
        }

        // Fix assigned_by
        if (!Schema::hasColumn('vehicle_assignments', 'assigned_by')) {
            Schema::table('vehicle_assignments', function (Blueprint $table) {
                $table->unsignedBigInteger('assigned_by')->nullable()->after('status');
            });
        }
    }

    private function fixEmployeeProfilesTable()
    {
        if (!Schema::hasTable('employee_profiles')) return;

        // Fix alternative_personal_phone
        if (!Schema::hasColumn('employee_profiles', 'alternative_personal_phone')) {
            Schema::table('employee_profiles', function (Blueprint $table) {
                $table->string('alternative_personal_phone')->nullable()->after('personal_phone');
            });
        }
    }

    private function fixStudentExtraChargesTable()
    {
        if (!Schema::hasTable('student_extra_charges')) return;

        // Fix amount_paid
        if (!Schema::hasColumn('student_extra_charges', 'amount_paid')) {
            Schema::table('student_extra_charges', function (Blueprint $table) {
                $table->decimal('amount_paid', 15, 2)->after('amount')->default(0.00);
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
        // This migration is not easily reversible due to the nature of fixing duplicates
        // Individual migrations should handle their own rollbacks
    }
}
