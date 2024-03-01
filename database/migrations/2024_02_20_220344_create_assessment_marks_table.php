<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_marks', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('assessment_id');
            $table->integer('academic_year_id');
            $table->integer('subject_id');
            $table->integer('mark');
            $table->integer('entered_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessment_marks');
    }
}
