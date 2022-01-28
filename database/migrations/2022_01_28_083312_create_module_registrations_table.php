<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('student_id');
            $table->integer('academic_year');
            $table->date('registration_date');
            $table->string('registration_status');
            $table->integer('module_id');
            $table->decimal('amount', 15, 2);
            $table->string('cancellation_reason')->nullable();
            $table->date('cancellation_date')->nullable();
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
        Schema::dropIfExists('module_registrations');
    }
}
