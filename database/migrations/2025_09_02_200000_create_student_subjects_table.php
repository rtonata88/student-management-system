<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // This migration is now handled by 2025_09_07_145000_fix_student_subjects_foreign_keys.php
        // to properly handle data type mismatches in foreign key constraints
        if (!Schema::hasTable('student_subjects')) {
            Schema::create('student_subjects', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('student_id'); // matches students.id (unsigned int)
                $table->unsignedInteger('subject_id'); // matches modules.id (unsigned int)
                $table->timestamps();

                $table->unique(['student_id', 'subject_id']);
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
        Schema::dropIfExists('student_subjects');
    }
}
