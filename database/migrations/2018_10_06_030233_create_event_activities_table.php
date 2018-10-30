<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id');
            $table->integer('participant_id');
            $table->integer('activity_type_id');
            $table->string('direction')->nullable();
            $table->date('when');
            $table->text('why');
            $table->text('outcome');
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
        Schema::dropIfExists('event_activities');
    }
}
