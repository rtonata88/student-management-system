<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('test_marks')) {
            Schema::create('test_marks', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('student_id');
                $table->unsignedInteger('module_id');
                $table->unsignedInteger('academic_year_id');
                $table->unsignedInteger('assessment_type_id');
                $table->decimal('marks_obtained', 5, 2)->nullable();
                $table->decimal('total_marks', 5, 2)->default(100.00);
                $table->text('remarks')->nullable();
                $table->timestamp('captured_at')->nullable();
                $table->unsignedInteger('captured_by')->nullable();
                $table->timestamps();

                // Indexes for better performance
                $table->index(['module_id', 'academic_year_id']);
                $table->index(['student_id', 'academic_year_id']);
                
                // Unique constraint to prevent duplicate marks for same student/module/assessment
                $table->unique(['student_id', 'module_id', 'academic_year_id', 'assessment_type_id'], 'unique_test_mark');
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
        Schema::dropIfExists('test_marks');
    }
}
