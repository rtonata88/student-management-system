<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // This migration is now handled by 2025_09_07_142000_fix_student_promotions_foreign_keys.php
        // to properly handle data type mismatches in foreign key constraints
        if (!Schema::hasTable('student_promotions')) {
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
                
                $table->index(['student_id', 'academic_year_id']);
                $table->index('promotional_status_id');
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
        Schema::dropIfExists('student_promotions');
    }
}
