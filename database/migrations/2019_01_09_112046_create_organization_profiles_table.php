<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id');
            $table->integer('organization_id');
            $table->string('position')->nullable();
            $table->string('work_number')->nullable();
            $table->string('work_number2')->nullable();
            $table->string('work_number_other')->nullable();
            $table->string('email')->nullable();
            $table->string('email2')->nullable();
            $table->string('email_other')->nullable();
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
        Schema::dropIfExists('organization_profiles');
    }
}
