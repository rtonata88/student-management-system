<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarpSummitAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warp_summit_attendees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date_attended');
            $table->string('profile_id');
            $table->string('current_or_former');
            $table->string('financing');
            $table->string('user');
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
        Schema::dropIfExists('warp_summit_attendees');
    }
}
