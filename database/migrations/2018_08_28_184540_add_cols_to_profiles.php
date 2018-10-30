<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->integer('language_id')->after('id');
            $table->string('work_number2')->after('work_number')->nullable();
            $table->string('work_number_other')->after('work_number2')->nullable();
            $table->string('email2')->after('email')->nullable();
            $table->string('mobile_no2')->after('mobile_no')->nullable();
            $table->string('mobile_no_other')->after('mobile_no2')->nullable();
            $table->string('assistant_email')->after('assistant_number')->nullable();
            $table->string('team_id')->after('sector_id');
            
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
