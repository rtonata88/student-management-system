<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoidedPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voided_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('original_payment_id');
            $table->string('payment_source'); // 'Cashier' or 'Manual'
            $table->integer('student_id');
            $table->string('receipt_number');
            $table->decimal('payment_amount', 10, 2);
            $table->string('payment_method');
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            $table->date('original_payment_date');
            $table->integer('original_received_by');
            $table->string('void_reason');
            $table->text('other_reason')->nullable();
            $table->integer('voided_by');
            $table->timestamp('voided_at');
            $table->timestamps();
            
            $table->index(['student_id', 'payment_source']);
            $table->index('original_payment_id');
            $table->index('voided_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voided_payments');
    }
}
