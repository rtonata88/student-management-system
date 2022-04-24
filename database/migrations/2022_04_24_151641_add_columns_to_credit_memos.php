<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToCreditMemos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credit_memos', function (Blueprint $table) {
            $table->string('credit_type')->after('transaction_date');
            $table->string('model')->after('credit_type');
            $table->integer('model_id')->after('model');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credit_memos', function (Blueprint $table) {
            //
        });
    }
}
