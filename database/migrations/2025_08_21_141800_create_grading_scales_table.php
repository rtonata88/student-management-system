<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradingScalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('grading_scales')) {
            Schema::create('grading_scales', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('module_id')->unsigned();
                $table->integer('academic_year_id')->unsigned();
                $table->integer('examination_id')->unsigned();
                $table->decimal('min_mark', 5, 2);
                $table->decimal('max_mark', 5, 2);
                $table->string('grade', 255);
                $table->integer('result_code_id')->unsigned();
                $table->enum('pass_fail', ['Pass', 'Fail']);
                $table->boolean('active')->default(true);
                $table->timestamps();

                // Foreign key constraints
                $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
                $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
                $table->foreign('examination_id')->references('id')->on('examinations')->onDelete('cascade');
                $table->foreign('result_code_id')->references('id')->on('result_codes')->onDelete('cascade');

                // Index for better performance
                $table->index(['module_id', 'academic_year_id', 'examination_id']);
                $table->index(['min_mark', 'max_mark']);
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
        Schema::dropIfExists('grading_scales');
    }
}
