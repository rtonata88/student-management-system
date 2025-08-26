<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('attendance')) {
            Schema::create('attendance', function (Blueprint $table) {
                $table->id();
                $table->integer('student_id')->unsigned();
                $table->integer('subject_allocation_id')->unsigned();
                $table->date('attendance_date');
                $table->time('class_time')->nullable(); // For multiple classes per day
                $table->enum('status', ['present', 'absent', 'late', 'excused'])->default('present');
                $table->text('notes')->nullable();
                $table->integer('recorded_by')->unsigned(); // Teacher who recorded attendance
                $table->timestamps();

                // Indexes for better performance
                $table->index(['student_id', 'attendance_date']);
                $table->index(['subject_allocation_id', 'attendance_date']);
                $table->index('attendance_date');

                // Unique constraint to prevent duplicate attendance records for same student, subject, date, and time
                $table->unique(['student_id', 'subject_allocation_id', 'attendance_date', 'class_time'], 'unique_attendance_record');
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
        Schema::dropIfExists('attendance');
    }
}
