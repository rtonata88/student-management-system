<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->date('dob')->after('gender_id');
            $table->string('pre_poisoned')->after('history');
            $table->string('cult_awareness')->after('history');
            $table->string('warp_attendee')->after('history');
            $table->string('religion_id')->after('history');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            //
        });
    }
}
