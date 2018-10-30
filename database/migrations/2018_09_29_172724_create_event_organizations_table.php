<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_other_attendees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id');
            $table->string('name');
            $table->string('email');
            $table->integer('send_email');
            $table->string('rsvp_status')->default('PENDING');
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
        Schema::dropIfExists('event_other_attendees');
    }
}
