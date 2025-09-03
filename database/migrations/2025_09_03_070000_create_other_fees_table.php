<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('other_fees')) {
            Schema::create('other_fees', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('student_id');
                $table->string('academic_year');
                $table->unsignedInteger('fee_id');
                $table->string('fee_description');
                $table->decimal('amount', 15, 2);
                $table->decimal('amount_paid', 15, 2)->default(0);
                $table->decimal('outstanding', 15, 2)->default(0);
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->timestamps();
                
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
                $table->foreign('fee_id')->references('id')->on('fees')->onDelete('cascade');
                
                $table->index(['student_id', 'academic_year']);
                $table->index('status');
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
        Schema::dropIfExists('other_fees');
    }
}
