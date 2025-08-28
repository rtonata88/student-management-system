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
        if (!Schema::hasTable('student_promotions')) {
            Schema::create('student_promotions', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('student_id');
                $table->unsignedBigInteger('academic_year_id');
                $table->unsignedBigInteger('promotional_status_id');
                $table->string('year_level');
                $table->text('remarks')->nullable();
                $table->unsignedBigInteger('promoted_by');
                $table->timestamp('promoted_at');
                $table->timestamps();

                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
                $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
                $table->foreign('promotional_status_id')->references('id')->on('promotional_statuses')->onDelete('cascade');
                $table->foreign('promoted_by')->references('id')->on('users')->onDelete('cascade');
                
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
