<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('event_type');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('objectives')->nullable();
            $table->date('start_date');
            $table->string('start_time')->nullable();
            $table->date('end_date')->nullable();
            $table->string('end_time');
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->integer('city_id');
            $table->integer('country_id');
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
        Schema::dropIfExists('events');
    }
}
