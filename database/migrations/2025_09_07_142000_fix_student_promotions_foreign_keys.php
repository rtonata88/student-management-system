<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixStudentPromotionsForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Fix the data type mismatch for academic_year_id
        if (Schema::hasTable('student_promotions')) {
            // Drop the table if it exists to recreate with correct data types
            Schema::dropIfExists('student_promotions');
        }

        // Recreate the table with correct data types matching the referenced tables
        Schema::create('student_promotions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_id'); // matches students.id (unsigned int)
            $table->unsignedInteger('academic_year_id'); // matches academic_years.id (unsigned int)
            $table->unsignedBigInteger('promotional_status_id');
            $table->string('year_level');
            $table->text('remarks')->nullable();
            $table->unsignedInteger('promoted_by'); // matches users.id (unsigned int)
            $table->timestamp('promoted_at');
            $table->timestamps();

            // Add foreign key constraints with correct data types
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
            $table->foreign('promotional_status_id')->references('id')->on('promotional_statuses')->onDelete('cascade');
            $table->foreign('promoted_by')->references('id')->on('users')->onDelete('cascade');
            
            $table->index(['student_id', 'academic_year_id']);
            $table->index('promotional_status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_promotions');
    }
}
