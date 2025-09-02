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
        if (!Schema::hasTable('student_subjects')) {
            Schema::create('student_subjects', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('student_id');
                $table->unsignedBigInteger('subject_id');
                $table->timestamps();

                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
                $table->foreign('subject_id')->references('id')->on('modules')->onDelete('cascade');
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
