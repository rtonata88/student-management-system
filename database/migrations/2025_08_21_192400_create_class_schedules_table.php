<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('class_schedules')) {
            Schema::create('class_schedules', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('academic_year_id');
                $table->unsignedInteger('center_id');
                $table->unsignedBigInteger('subject_allocation_id');
                $table->unsignedBigInteger('venue_id');
                $table->unsignedBigInteger('class_duration_id');
                $table->enum('day_of_week', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']);
                $table->date('effective_from');
                $table->date('effective_to')->nullable();
                $table->text('notes')->nullable();
                $table->boolean('is_active')->default(true);
                $table->unsignedInteger('created_by');
                $table->timestamps();

                $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
                $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
                $table->foreign('subject_allocation_id')->references('id')->on('subject_allocations')->onDelete('cascade');
                $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
                $table->foreign('class_duration_id')->references('id')->on('class_durations')->onDelete('cascade');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

                // Prevent double booking of venues
                $table->unique(['venue_id', 'class_duration_id', 'day_of_week', 'effective_from'], 'unique_venue_time_slot');
                
                // Prevent teacher conflicts
                $table->index(['subject_allocation_id', 'class_duration_id', 'day_of_week'], 'cs_teacher_conflict_idx');
                $table->index(['academic_year_id', 'center_id', 'is_active']);
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
        Schema::dropIfExists('class_schedules');
    }
}
