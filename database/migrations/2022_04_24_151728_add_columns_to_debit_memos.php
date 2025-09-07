<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToDebitMemos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    {
    {
    {
        if (Schema::hasTable('debit_memos') && !Schema::hasColumn('debit_memos', 'debit_type')) {
            Schema::table('debit_memos', function (Blueprint $table) {
            $table->string('debit_type')->after('transaction_date');
            $table->string('model')->after('debit_type');
            $table->integer('model_id')->after('model');
        });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('debit_memos', function (Blueprint $table) {
            //
        });
    }
}
