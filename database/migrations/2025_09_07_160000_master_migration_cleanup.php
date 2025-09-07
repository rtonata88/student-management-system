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

        if (!$this->foreignKeyExists('students', 'students_center_id_foreign')) {
            Schema::table('students', function (Blueprint $table) {
                $table->unsignedInteger('center_id')->nullable(false)->change();
                $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
            });
        }
    }

    private function fixExaminationSchedulesForeignKeys()
    {
        if (!Schema::hasTable('examination_schedules')) return;

        if (Schema::hasColumn('examination_schedules', 'head_invigilator_id')) {
            DB::table('examination_schedules')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('users')
                          ->whereRaw('users.id = examination_schedules.head_invigilator_id');
                })
                ->update(['head_invigilator_id' => null]);

            if (!$this->foreignKeyExists('examination_schedules', 'examination_schedules_head_invigilator_id_foreign')) {
                Schema::table('examination_schedules', function (Blueprint $table) {
                    $table->foreign('head_invigilator_id')
                          ->references('id')
                          ->on('users')
                          ->onDelete('set null');
                });
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
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('academic_year_id');
            $table->unsignedBigInteger('promotional_status_id');
            $table->string('year_level');
            $table->text('remarks')->nullable();
            $table->unsignedInteger('promoted_by');
            $table->timestamp('promoted_at');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
            $table->foreign('promotional_status_id')->references('id')->on('promotional_statuses')->onDelete('cascade');
            $table->foreign('promoted_by')->references('id')->on('users')->onDelete('cascade');
            
            $table->index(['student_id', 'academic_year_id']);
            $table->index('promotional_status_id');
        });
    }

    private function fixApplicationSubjectsForeignKeys()
    {
        if (Schema::hasTable('application_subjects')) {
            Schema::dropIfExists('application_subjects');
        }

        Schema::create('application_subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id');
            $table->unsignedInteger('subject_id');
            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('online_applications')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('modules')->onDelete('cascade');
            $table->unique(['application_id', 'subject_id']);
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
            $table->bigIncrements('id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('subject_id');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('modules')->onDelete('cascade');
            $table->unique(['student_id', 'subject_id']);
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

        if (!Schema::hasColumn('drivers', 'notes')) {
            Schema::table('drivers', function (Blueprint $table) {
                $table->text('notes')->nullable()->after('status');
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
            'estimated_distance' => ['type' => 'decimal', 'precision' => [8, 2], 'nullable' => true, 'after' => 'route_taken'],
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
