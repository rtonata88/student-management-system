<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCenterIdToStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // This migration is now handled by 2025_09_07_120000_fix_students_center_id_data.php
        // to properly handle existing data before adding foreign key constraints
        if (!Schema::hasColumn('students', 'center_id')) {
            Schema::table('students', function (Blueprint $table) {
                $table->unsignedInteger('center_id')->nullable()->after('student_names');
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
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['center_id']);
            $table->dropColumn('center_id');
        });
    }
}
