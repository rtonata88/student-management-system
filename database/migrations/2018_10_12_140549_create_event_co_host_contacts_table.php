<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventCoHostContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_co_host_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_co_host_id');
            $table->string('contact_person');
            $table->string('contact_number');
            $table->string('contact_email');
            $table->timestamps();
        });

        Schema::table('event_co_hosts', function($table) {
             $table->dropColumn('contact_person');
             $table->dropColumn('contact_number');
             $table->dropColumn('contact_email');
          });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_co_host_contacts');
        
    }
}
