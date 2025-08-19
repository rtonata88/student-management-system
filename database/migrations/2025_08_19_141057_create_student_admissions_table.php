<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('student_admissions')) {
            Schema::create('student_admissions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('student_id')->unique(); // Ensure only one record per student
                $table->enum('admission_status', ['rejected', 'provisionally_admitted', 'full_admission']);
                $table->text('remarks')->nullable();
                $table->timestamp('status_date')->useCurrent();
                $table->timestamps();
                
                $table->index('student_id');
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
        Schema::dropIfExists('student_admissions');
    }
}
