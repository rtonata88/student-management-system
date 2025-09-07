<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixStudentSubjectsForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Fix the data type mismatch for subject_id
        if (Schema::hasTable('student_subjects')) {
            // Drop the table if it exists to recreate with correct data types
            Schema::dropIfExists('student_subjects');
        }

        // Recreate the table with correct data types matching the referenced tables
        Schema::create('student_subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('student_id'); // matches students.id (unsigned int)
            $table->unsignedInteger('subject_id'); // matches modules.id (unsigned int)
            $table->timestamps();

            // Add foreign key constraints with correct data types
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('modules')->onDelete('cascade');
            $table->unique(['student_id', 'subject_id']);
        });
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
