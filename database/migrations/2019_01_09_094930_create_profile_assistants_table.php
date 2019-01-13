<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileAssistantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_assistants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id');
            $table->string('assistant_name');
            $table->string('assistant_email1');
            $table->string('assistant_number1');
            $table->string('assistant_email2');
            $table->string('assistant_number2');
            $table->string('assistant_email3');
            $table->string('assistant_number3');
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
        Schema::dropIfExists('profile_assistants');
    }
}
