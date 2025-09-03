<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentNumberReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('student_number_reservations')) {
            Schema::create('student_number_reservations', function (Blueprint $table) {
                $table->id();
                $table->string('student_number');
                $table->string('session_id');
                $table->timestamp('reserved_at');
                $table->timestamp('expires_at');
                $table->timestamps();
                $table->index(['expires_at']);
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
        Schema::dropIfExists('student_number_reservations');
    }
}
