<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSearchIndexesForUsersResetStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // Add indexes for search fields
                if (!Schema::hasColumn('users', 'idx_users_name')) {
                    $table->index('name', 'idx_users_name');
                }
                if (!Schema::hasColumn('users', 'idx_users_username')) {
                    $table->index('username', 'idx_users_username');
                }
                if (!Schema::hasColumn('users', 'idx_users_email')) {
                    $table->index('email', 'idx_users_email');
                }
                if (!Schema::hasColumn('users', 'idx_users_user_type')) {
                    $table->index('user_type', 'idx_users_user_type');
                }
                if (!Schema::hasColumn('users', 'idx_users_type_name')) {
                    $table->index(['user_type', 'name'], 'idx_users_type_name');
                }
            });
        }

        if (Schema::hasTable('students')) {
            Schema::table('students', function (Blueprint $table) {
                // Add indexes for student search fields
                if (!Schema::hasColumn('students', 'idx_students_number')) {
                    $table->index('student_number', 'idx_students_number');
                }
                if (!Schema::hasColumn('students', 'idx_students_number2')) {
                    $table->index('student_number2', 'idx_students_number2');
                }
                if (!Schema::hasColumn('students', 'idx_students_center')) {
                    $table->index('center_id', 'idx_students_center');
                }
            });
        }

        if (Schema::hasTable('registrations')) {
            Schema::table('registrations', function (Blueprint $table) {
                // Add composite index for registration lookup
                if (!Schema::hasColumn('registrations', 'idx_registrations_student_year')) {
                    $table->index(['student_id', 'academic_year'], 'idx_registrations_student_year');
                }
                if (!Schema::hasColumn('registrations', 'idx_registrations_year')) {
                    $table->index('academic_year', 'idx_registrations_year');
                }
            });
        }

        if (Schema::hasTable('centers')) {
            Schema::table('centers', function (Blueprint $table) {
                // Add index for center name
                if (!Schema::hasColumn('centers', 'idx_centers_name')) {
                    $table->index('center_name', 'idx_centers_name');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_name');
            $table->dropIndex('idx_users_username');
            $table->dropIndex('idx_users_email');
            $table->dropIndex('idx_users_user_type');
            $table->dropIndex('idx_users_type_name');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex('idx_students_number');
            $table->dropIndex('idx_students_number2');
            $table->dropIndex('idx_students_center');
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropIndex('idx_registrations_student_year');
            $table->dropIndex('idx_registrations_year');
        });

        Schema::table('centers', function (Blueprint $table) {
            $table->dropIndex('idx_centers_name');
        });
    }
}
