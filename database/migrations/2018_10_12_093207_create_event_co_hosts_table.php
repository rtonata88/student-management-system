<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventCoHostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_co_hosts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id');
            $table->string('name');
            $table->string('address_line1');
            $table->string('address_line2');
            $table->string('address_line3');
            $table->string('address_line4');
            $table->string('contact_person');
            $table->string('contact_number');
            $table->string('contact_email');
            $table->string('logo');
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
        Schema::dropIfExists('event_co_hosts');
    }
}
