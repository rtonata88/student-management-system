<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname');
            $table->string('lastname');
            $table->integer('gender_id');
            $table->text('bio')->nullable();
            $table->string('position');
            $table->integer('organization_id');
            $table->string('photo')->nullable();
            $table->integer('sector_id');
            $table->integer('country_id');
            $table->integer('city_id');
            $table->string('platform');
            $table->string('mobile_no')->nullable();
            $table->string('work_number')->nullable();
            $table->string('email')->nullable();
            $table->string('assistant_name')->nullable();
            $table->string('assistant_number')->nullable();
            $table->date('date_networked')->nullable();
            $table->integer('fruit_level_id');
            $table->integer('fruit_stage_id');
            $table->integer('maintainer_id');
            $table->integer('fruit_role_id');
            $table->integer('sector_relationship_id');
            $table->text('history')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
