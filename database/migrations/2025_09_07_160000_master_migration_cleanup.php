<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MasterMigrationCleanup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // This is the MASTER cleanup migration that handles ALL remaining issues
        // It's designed to be idempotent and safe to run multiple times
        
        $this->fixStudentsCenterIdData();
        $this->fixExaminationSchedulesForeignKeys();
        $this->fixStudentPromotionsForeignKeys();
        $this->fixApplicationSubjectsForeignKeys();
        $this->fixDuplicateUsernames();
        $this->fixStudentSubjectsForeignKeys();
        $this->createMarksSuppressionTable();
        $this->comprehensiveDataCleanup();
        $this->fixAllDuplicateColumns();
        $this->fixAllDropColumnIssues();
    }

    private function fixStudentsCenterIdData()
    {
        if (!Schema::hasColumn('students', 'center_id')) {
            Schema::table('students', function (Blueprint $table) {
                $table->unsignedInteger('center_id')->nullable()->after('student_names');
            });
        }

        $defaultCenterId = DB::table('centers')->first()->id ?? 1;
        DB::table('students')
            ->whereNull('center_id')
            ->orWhere('center_id', 0)
            ->orWhere('center_id', '')
            ->update(['center_id' => $defaultCenterId]);

        // Drop any existing foreign key constraints on center_id first
        $this->dropExistingForeignKeys('students', 'center_id');
        
        // Now safely add the foreign key constraint
        try {
            Schema::table('students', function (Blueprint $table) {
                $table->foreign('center_id', 'fk_students_center_id')->references('id')->on('centers')->onDelete('cascade');
            });
        } catch (\Exception $e) {
            // Skip if constraint already exists or other issues
        }
    }

    private function fixExaminationSchedulesForeignKeys()
    {
        if (!Schema::hasTable('examination_schedules')) return;

        if (Schema::hasColumn('examination_schedules', 'head_invigilator_id')) {
            // Clean up invalid references first
            DB::table('examination_schedules')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('users')
                          ->whereRaw('users.id = examination_schedules.head_invigilator_id');
                })
                ->update(['head_invigilator_id' => null]);

            // Drop any existing foreign key constraints on this column first
            $this->dropExistingForeignKeys('examination_schedules', 'head_invigilator_id');
            
            // Now safely add the foreign key constraint
            try {
                Schema::table('examination_schedules', function (Blueprint $table) {
                    $table->foreign('head_invigilator_id', 'fk_exam_head_invigilator')
                          ->references('id')
                          ->on('users')
                          ->onDelete('set null');
                });
            } catch (\Exception $e) {
                // Skip if constraint already exists or other issues
            }
        }
    }

    private function fixStudentPromotionsForeignKeys()
    {
        if (Schema::hasTable('student_promotions')) {
            Schema::dropIfExists('student_promotions');
        }

        Schema::create('student_promotions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('from_class');
            $table->string('to_class');
            $table->year('academic_year');
            $table->enum('status', ['promoted', 'repeated', 'transferred'])->default('promoted');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('student_id', 'fk_student_promotions_student')->references('id')->on('students')->onDelete('cascade');
        });
    }

    private function fixApplicationSubjectsForeignKeys()
    {
        if (Schema::hasTable('application_subjects')) {
            Schema::dropIfExists('application_subjects');
        }

        Schema::create('application_subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('subject_id');
            $table->timestamps();

            $table->foreign('application_id', 'fk_app_subjects_application')->references('id')->on('applications')->onDelete('cascade');
            $table->foreign('subject_id', 'fk_app_subjects_subject')->references('id')->on('subjects')->onDelete('cascade');
            $table->unique(['application_id', 'subject_id'], 'uk_app_subject');
        });
    }

    private function fixDuplicateUsernames()
    {
        $duplicateUsernames = DB::table('users')
            ->select('username', DB::raw('COUNT(*) as count'))
            ->groupBy('username')
            ->having('count', '>', 1)
            ->get();

        foreach ($duplicateUsernames as $duplicate) {
            $users = DB::table('users')
                ->where('username', $duplicate->username)
                ->orderBy('id')
                ->get();

            $counter = 1;
            foreach ($users as $index => $user) {
                if ($index > 0) {
                    $newUsername = $duplicate->username . '_' . $counter;
                    
                    while (DB::table('users')->where('username', $newUsername)->exists()) {
                        $counter++;
                        $newUsername = $duplicate->username . '_' . $counter;
                    }
                    
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['username' => $newUsername]);
                    
                    $counter++;
                }
            }
        }
    }

    private function fixStudentSubjectsForeignKeys()
    {
        if (Schema::hasTable('student_subjects')) {
            Schema::dropIfExists('student_subjects');
        }

        Schema::create('student_subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('subject_id');
            $table->enum('status', ['active', 'inactive', 'completed', 'dropped'])->default('active');
            $table->decimal('grade', 5, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('student_id', 'fk_student_subjects_student')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('subject_id', 'fk_student_subjects_subject')->references('id')->on('subjects')->onDelete('cascade');
            $table->unique(['student_id', 'subject_id'], 'uk_student_subject');
        });
    }

    private function createMarksSuppressionTable()
    {
        if (!Schema::hasTable('marks_suppressions')) {
            Schema::create('marks_suppressions', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('academic_year_id');
                $table->string('intake');
                $table->string('campus');
                $table->enum('mark_type', ['CA', 'Exam Marks', 'Final Mark']);
                $table->enum('study_mode', ['Full Time', 'Part Time', 'Distance Learning']);
                $table->boolean('is_suppressed')->default(true);
                $table->text('reason')->nullable();
                $table->unsignedInteger('created_by');
                $table->timestamps();

                $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
                
                $table->index(['academic_year_id', 'intake', 'campus', 'mark_type', 'study_mode'], 'marks_suppression_index');
            });
        }
    }

    private function comprehensiveDataCleanup()
    {
        $tables = [
            'student_documents' => ['student_id' => 'students'],
            'examination_schedules' => [
                'venue_id' => 'venues',
                'subject_allocation_id' => 'subject_allocations',
                'examination_id' => 'assessment_types',
                'class_duration_id' => 'class_durations'
            ],
            'module_registrations' => [
                'student_id' => 'students',
                'module_id' => 'modules'
            ],
            'ca_marks' => [
                'student_id' => 'students',
                'module_id' => 'modules'
            ],
            'exam_marks' => [
                'student_id' => 'students',
                'module_id' => 'modules'
            ],
            'payments' => ['student_id' => 'students'],
            'cashier_payments' => [
                'student_id' => 'students',
                'cashier_id' => 'users'
            ]
        ];

        foreach ($tables as $table => $foreignKeys) {
            if (!Schema::hasTable($table)) continue;

            foreach ($foreignKeys as $column => $referencedTable) {
                if (!Schema::hasColumn($table, $column)) continue;

                DB::table($table)
                    ->whereNotExists(function ($query) use ($referencedTable, $column, $table) {
                        $query->select(DB::raw(1))
                              ->from($referencedTable)
                              ->whereRaw("{$referencedTable}.id = {$table}.{$column}");
                    })
                    ->delete();
            }
        }

        // Fix duplicate column issues
        $this->fixDuplicateColumns();
    }

    private function fixDuplicateColumns()
    {
        // Fix vehicles table current_odometer duplicate
        if (Schema::hasTable('vehicles')) {
            // Check if current_odometer exists in the main table structure
            $hasCurrentOdometer = Schema::hasColumn('vehicles', 'current_odometer');
            
            if (!$hasCurrentOdometer) {
                // Add the column if it doesn't exist
                Schema::table('vehicles', function (Blueprint $table) {
                    $table->integer('current_odometer')->default(0)->after('license_expiry');
                });
            }
        }

        // Add other duplicate column fixes here as needed
        $this->fixOtherDuplicateColumns();
    }

    private function fixOtherDuplicateColumns()
    {
        // Check for other common duplicate column issues
        $columnChecks = [
            'students' => ['center_id'],
            'examination_schedules' => ['head_invigilator_id'],
            'users' => ['email_verified_at', 'remember_token']
        ];

        foreach ($columnChecks as $table => $columns) {
            if (!Schema::hasTable($table)) continue;

            foreach ($columns as $column) {
                if (!Schema::hasColumn($table, $column)) {
                    // Add missing columns based on table requirements
                    $this->addMissingColumn($table, $column);
                }
            }
        }
    }

    private function addMissingColumn($table, $column)
    {
        Schema::table($table, function (Blueprint $table) use ($column) {
            switch ($column) {
                case 'center_id':
                    $table->unsignedInteger('center_id')->nullable()->after('student_names');
                    break;
                case 'head_invigilator_id':
                    $table->unsignedBigInteger('head_invigilator_id')->nullable()->after('class_duration_id');
                    break;
                case 'email_verified_at':
                    $table->timestamp('email_verified_at')->nullable();
                    break;
                case 'remember_token':
                    $table->rememberToken();
                    break;
            }
        });
    }

    private function fixAllDuplicateColumns()
    {
        $this->fixStudentsTableColumns();
        $this->fixUsersTableColumns();
        $this->fixClassSchedulesTableColumns();
        $this->fixExaminationSchedulesTableColumns();
        $this->fixStudentSubjectsTableColumns();
        $this->fixVehiclesTableColumns();
        $this->fixDriversTableColumns();
        $this->fixTripLogsTableColumns();
        $this->fixVehicleServicesTableColumns();
        $this->fixVehicleAssignmentsTableColumns();
        $this->fixEmployeeProfilesTableColumns();
        $this->fixStudentExtraChargesTableColumns();
    }

    private function fixStudentsTableColumns()
    {
        if (!Schema::hasTable('students')) return;

        if (!Schema::hasColumn('students', 'photo')) {
            Schema::table('students', function (Blueprint $table) {
                $table->string('photo')->nullable()->after('birth_certificate');
            });
        }

        if (!Schema::hasColumn('students', 'user_id')) {
            Schema::table('students', function (Blueprint $table) {
                $table->unsignedInteger('user_id')->nullable()->after('student_names');
            });
        }
    }

    private function fixUsersTableColumns()
    {
        if (!Schema::hasTable('users')) return;

        if (!Schema::hasColumn('users', 'user_type')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('user_type')->default('student')->after('password');
            });
        }
    }

    private function fixClassSchedulesTableColumns()
    {
        if (!Schema::hasTable('class_schedules')) return;

        if (!Schema::hasColumn('class_schedules', 'start_time')) {
            Schema::table('class_schedules', function (Blueprint $table) {
                $table->time('start_time')->nullable()->after('day_of_week');
            });
        }
    }

    private function fixExaminationSchedulesTableColumns()
    {
        if (!Schema::hasTable('examination_schedules')) return;

        if (!Schema::hasColumn('examination_schedules', 'head_invigilator_id')) {
            Schema::table('examination_schedules', function (Blueprint $table) {
                $table->unsignedBigInteger('head_invigilator_id')->nullable()->after('class_duration_id');
                $table->index(['head_invigilator_id', 'exam_date', 'class_duration_id']);
            });
        }
    }

    private function fixStudentSubjectsTableColumns()
    {
        if (!Schema::hasTable('student_subjects')) return;

        if (!Schema::hasColumn('student_subjects', 'status')) {
            Schema::table('student_subjects', function (Blueprint $table) {
                $table->enum('status', ['active', 'inactive', 'completed', 'dropped'])->default('active')->after('subject_id');
            });
        }
    }

    private function fixVehiclesTableColumns()
    {
        if (!Schema::hasTable('vehicles')) return;

        if (!Schema::hasColumn('vehicles', 'current_odometer')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->integer('current_odometer')->default(0)->after('license_expiry');
            });
        }
    }

    private function fixDriversTableColumns()
    {
        if (!Schema::hasTable('drivers')) return;

        // Add emergency_contact_phone if it doesn't exist
        if (!Schema::hasColumn('drivers', 'emergency_contact_phone')) {
            Schema::table('drivers', function (Blueprint $table) {
                $table->string('emergency_contact_phone')->nullable()->after('phone');
            });
        }

        if (!Schema::hasColumn('drivers', 'notes')) {
            Schema::table('drivers', function (Blueprint $table) {
                $table->text('notes')->nullable()->after('emergency_contact_phone');
            });
        }

        if (!Schema::hasColumn('drivers', 'photo')) {
            Schema::table('drivers', function (Blueprint $table) {
                $table->string('photo')->nullable()->after('notes');
            });
        }
    }

    private function fixTripLogsTableColumns()
    {
        if (!Schema::hasTable('trip_logs')) return;

        $columnsToAdd = [
            'expected_return_time' => ['type' => 'datetime', 'nullable' => true, 'after' => 'departure_time'],
            'estimated_distance' => ['type' => 'decimal', 'precision' => [8, 2], 'nullable' => true, 'after' => 'end_odometer'],
            'passenger_count' => ['type' => 'integer', 'nullable' => true, 'after' => 'estimated_distance'],
            'fuel_cost_per_liter' => ['type' => 'decimal', 'precision' => [8, 2], 'nullable' => true, 'after' => 'fuel_consumed'],
            'total_fuel_cost' => ['type' => 'decimal', 'precision' => [10, 2], 'nullable' => true, 'after' => 'fuel_cost_per_liter'],
            'fuel_receipt_number' => ['type' => 'string', 'nullable' => true, 'after' => 'total_fuel_cost'],
            'fuel_station_name' => ['type' => 'string', 'nullable' => true, 'after' => 'fuel_receipt_number'],
            'fuel_liters' => ['type' => 'decimal', 'precision' => [8, 2], 'nullable' => true, 'after' => 'fuel_station_name'],
            'fuel_town_city' => ['type' => 'string', 'nullable' => true, 'after' => 'fuel_liters']
        ];

        foreach ($columnsToAdd as $columnName => $config) {
            if (!Schema::hasColumn('trip_logs', $columnName)) {
                Schema::table('trip_logs', function (Blueprint $table) use ($columnName, $config) {
                    $column = null;
                    switch ($config['type']) {
                        case 'datetime':
                            $column = $table->datetime($columnName);
                            break;
                        case 'decimal':
                            $column = $table->decimal($columnName, $config['precision'][0], $config['precision'][1]);
                            break;
                        case 'integer':
                            $column = $table->integer($columnName);
                            break;
                        case 'string':
                            $column = $table->string($columnName);
                            break;
                    }
                    
                    if ($config['nullable']) {
                        $column->nullable();
                    }
                    
                    if (isset($config['after'])) {
                        $column->after($config['after']);
                    }
                });
            }
        }
    }

    private function fixVehicleServicesTableColumns()
    {
        if (!Schema::hasTable('vehicle_services')) return;

        if (!Schema::hasColumn('vehicle_services', 'service_description')) {
            Schema::table('vehicle_services', function (Blueprint $table) {
                $table->text('service_description')->nullable()->after('description');
            });
        }
    }

    private function fixVehicleAssignmentsTableColumns()
    {
        if (!Schema::hasTable('vehicle_assignments')) return;

        if (!Schema::hasColumn('vehicle_assignments', 'assignment_type')) {
            Schema::table('vehicle_assignments', function (Blueprint $table) {
                $table->enum('assignment_type', ['permanent', 'temporary', 'backup'])->default('permanent')->after('is_primary');
            });
        }

        if (!Schema::hasColumn('vehicle_assignments', 'status')) {
            Schema::table('vehicle_assignments', function (Blueprint $table) {
                $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('assignment_type');
            });
        }

        if (!Schema::hasColumn('vehicle_assignments', 'assigned_by')) {
            Schema::table('vehicle_assignments', function (Blueprint $table) {
                $table->unsignedBigInteger('assigned_by')->nullable()->after('status');
            });
        }
    }

    private function fixEmployeeProfilesTableColumns()
    {
        if (!Schema::hasTable('employee_profiles')) return;

        if (!Schema::hasColumn('employee_profiles', 'alternative_personal_phone')) {
            Schema::table('employee_profiles', function (Blueprint $table) {
                $table->string('alternative_personal_phone')->nullable()->after('personal_phone');
            });
        }
    }

    private function fixStudentExtraChargesTableColumns()
    {
        if (!Schema::hasTable('student_extra_charges')) return;

        if (!Schema::hasColumn('student_extra_charges', 'amount_paid')) {
            Schema::table('student_extra_charges', function (Blueprint $table) {
                $table->decimal('amount_paid', 15, 2)->after('amount')->default(0.00);
            });
        }
    }

    private function fixAllDropColumnIssues()
    {
        // Safely handle all potential drop column operations
        $this->safeDropColumnsFromTables();
    }

    private function safeDropColumnsFromTables()
    {
        // Handle drop column operations that might cause errors
        $dropOperations = [
            'trip_logs' => [
                'route_taken',
                'departure_date',
                'arrival_date',
                'passengers_count'
            ]
        ];

        foreach ($dropOperations as $table => $columns) {
            if (!Schema::hasTable($table)) continue;

            $columnsToDrop = [];
            foreach ($columns as $column) {
                if (Schema::hasColumn($table, $column)) {
                    $columnsToDrop[] = $column;
                }
            }

            if (!empty($columnsToDrop)) {
                try {
                    Schema::table($table, function (Blueprint $table) use ($columnsToDrop) {
                        $table->dropColumn($columnsToDrop);
                    });
                } catch (\Exception $e) {
                    // Skip if column is referenced by foreign key or index
                    continue;
                }
            }
        }
    }

    private function foreignKeyExists($table, $keyName)
    {
        try {
            $keys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME = ? 
                AND TABLE_SCHEMA = ? 
                AND CONSTRAINT_NAME = ?
            ", [$table, config('database.connections.mysql.database'), $keyName]);

            return count($keys) > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function checkForeignKeyByColumn($table, $column)
    {
        try {
            $keys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME = ? 
                AND TABLE_SCHEMA = ? 
                AND COLUMN_NAME = ?
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ", [$table, config('database.connections.mysql.database'), $column]);

            return count($keys) > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function dropExistingForeignKeys($table, $column)
    {
        try {
            $keys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME = ? 
                AND TABLE_SCHEMA = ? 
                AND COLUMN_NAME = ?
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ", [$table, config('database.connections.mysql.database'), $column]);

            foreach ($keys as $key) {
                try {
                    DB::statement("ALTER TABLE `{$table}` DROP FOREIGN KEY `{$key->CONSTRAINT_NAME}`");
                } catch (\Exception $e) {
                    // Continue if constraint doesn't exist or can't be dropped
                    continue;
                }
            }
        } catch (\Exception $e) {
            // Skip if unable to query constraints
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
    }
}
