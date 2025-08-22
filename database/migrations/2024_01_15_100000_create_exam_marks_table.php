<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('exam_marks')) {
            Schema::create('exam_marks', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('student_id');
                $table->unsignedInteger('module_id');
                $table->unsignedInteger('academic_year_id');
                $table->unsignedInteger('exam_type_id');
                $table->unsignedBigInteger('exam_paper_id');
                $table->decimal('marks_obtained', 5, 2);
                $table->decimal('total_marks', 5, 2);
                $table->unsignedInteger('captured_by')->nullable();
                $table->timestamps();

                // Foreign key constraints - only add for tables that exist at this point
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
                $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
                $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
                $table->foreign('captured_by')->references('id')->on('users')->onDelete('set null');
                // Note: exam_papers and assessment_types tables will be created later, foreign keys added in separate migration

                // Unique constraint to prevent duplicate marks for same student, module, exam paper
                $table->unique(['student_id', 'module_id', 'academic_year_id', 'exam_type_id', 'exam_paper_id'], 'unique_exam_mark');
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
        Schema::dropIfExists('exam_marks');
    }
}
