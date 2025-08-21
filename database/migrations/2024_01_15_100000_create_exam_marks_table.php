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
                $table->integer('student_id')->unsigned();
                $table->integer('module_id')->unsigned();
                $table->integer('academic_year_id')->unsigned();
                $table->integer('exam_type_id')->unsigned();
                $table->integer('exam_paper_id')->unsigned();
                $table->decimal('marks_obtained', 5, 2);
                $table->decimal('total_marks', 5, 2);
                $table->integer('captured_by')->unsigned();
                $table->timestamps();

                // Foreign key constraints
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
                $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
                $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
                $table->foreign('exam_type_id')->references('id')->on('assessment_types')->onDelete('cascade');
                $table->foreign('exam_paper_id')->references('id')->on('exam_papers')->onDelete('cascade');
                $table->foreign('captured_by')->references('id')->on('users')->onDelete('cascade');

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
