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
                $table->unsignedInteger('academic_year_id');
                $table->unsignedInteger('center_id');
                $table->unsignedBigInteger('examination_id'); // Assessment Type (Mock Exam, Final Exam, etc.)
                $table->unsignedBigInteger('subject_allocation_id');
                $table->unsignedBigInteger('venue_id');
                $table->unsignedBigInteger('class_duration_id');
                $table->date('exam_date');
                $table->text('notes')->nullable();
                $table->boolean('is_active')->default(true);
                $table->unsignedInteger('created_by');
                $table->timestamps();

                // Foreign key constraints
                $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
                $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
                // Note: assessment_types table will be created later, so we'll add this foreign key constraint in a separate migration
                // Note: subject_allocations table will be created later, so we'll add this foreign key constraint in a separate migration
                // Note: venues and class_durations tables will be created later, so we'll add these foreign key constraints in a separate migration
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
