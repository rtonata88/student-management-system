<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashierPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cashier_payments')) {
            Schema::create('cashier_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_id');
            $table->string('receipt_number')->unique();
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['Cash', 'Card', 'Bank Transfer', 'Mobile Money', 'Cheque']);
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedInteger('cashier_id'); // User who processed the payment
            $table->timestamp('payment_date');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('cashier_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->index(['student_id', 'payment_date']);
            $table->index('receipt_number');
        });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashier_payments');
    }
}
