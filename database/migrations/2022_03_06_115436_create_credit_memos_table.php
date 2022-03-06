<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditMemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_memos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->date('transaction_date');
            $table->decimal('amount', 15, 2);
            $table->string('reason');
            $table->integer('captured_by');
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
        Schema::dropIfExists('credit_memos');
    }
}
