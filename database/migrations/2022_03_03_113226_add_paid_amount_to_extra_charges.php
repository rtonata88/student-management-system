<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaidAmountToExtraCharges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_extra_charges', function (Blueprint $table) {
            $table->decimal('amount_paid', 15, 2)->after('amount')->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_extra_charges', function (Blueprint $table) {
            $table->dropColumn('amount_paid');
        });
    }
}
