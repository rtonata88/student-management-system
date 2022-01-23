<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('student_number');
            $table->string('surname');
            $table->string('student_names');
            $table->string('initials');
            $table->string('gender');
            $table->string('contact_number');
            $table->string('contact_email')->nullable();
            $table->date('date_of_birth');
            $table->string('birth_certificate');
            $table->bigInteger('id_number');
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
        Schema::dropIfExists('students');
    }
}
