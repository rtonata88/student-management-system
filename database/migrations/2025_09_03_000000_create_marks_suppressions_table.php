<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarksSuppressionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marks_suppressions');
    }
}
