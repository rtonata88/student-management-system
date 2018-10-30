<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaCoveragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_coverages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('media_house');
            $table->integer('profile_id');
            $table->date('when');
            $table->integer('event_id')->nullable();
            $table->integer('country_id');
            $table->integer('city_id');
            $table->string('title');
            $table->string('platform');
            $table->text('short_summary')->nullable();
            $table->string('url')->nullable();
            $table->string('location')->nullable();
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
        Schema::dropIfExists('media_coverages');
    }
}