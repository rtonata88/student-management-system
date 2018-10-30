<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventCheckInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_check_ins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id');
            $table->integer('checked_in_by');
            $table->integer('profile_id')->nullable();
            $table->string('fullname');
            $table->string('lastname');
            $table->string('email');
            $table->string('mobile_no')->nullable();
            $table->string('work_number')->nullabl();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_check_ins');
    }
}
