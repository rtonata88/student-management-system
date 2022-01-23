<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentExtraChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_extra_charges', function (Blueprint $table) {
            $table->increments('id');
            $table->date('transaction_date');
            $table->bigInteger('student_id');
            $table->integer('fee_id');
            $table->string('fee_description');
            $table->decimal('amount', 15, 2);
            $table->string('status');
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
        Schema::dropIfExists('student_extra_charges');
    }
}
