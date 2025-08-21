<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExaminationSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('examination_schedules')) {
            Schema::create('examination_schedules', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('academic_year_id');
                $table->unsignedBigInteger('center_id');
                $table->unsignedBigInteger('examination_id'); // Assessment Type (Mock Exam, Final Exam, etc.)
                $table->unsignedBigInteger('subject_allocation_id');
                $table->unsignedBigInteger('venue_id');
                $table->unsignedBigInteger('class_duration_id');
                $table->date('exam_date');
                $table->text('notes')->nullable();
                $table->boolean('is_active')->default(true);
                $table->unsignedBigInteger('created_by');
                $table->timestamps();

                // Foreign key constraints
                $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
                $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
                $table->foreign('examination_id')->references('id')->on('assessment_types')->onDelete('cascade');
                $table->foreign('subject_allocation_id')->references('id')->on('subject_allocations')->onDelete('cascade');
                $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
                $table->foreign('class_duration_id')->references('id')->on('class_durations')->onDelete('cascade');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

                // Indexes for better performance
                $table->index(['academic_year_id', 'center_id']);
                $table->index(['exam_date', 'class_duration_id']);
                $table->index(['venue_id', 'exam_date']);
                $table->index(['subject_allocation_id', 'exam_date']);

                // Unique constraint to prevent double booking
                $table->unique(['venue_id', 'class_duration_id', 'exam_date'], 'unique_venue_time_date');
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
        if (Schema::hasTable('examination_schedules')) {
            Schema::dropIfExists('examination_schedules');
        }
    }
}
