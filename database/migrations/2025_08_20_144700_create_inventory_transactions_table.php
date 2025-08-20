<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('inventory_transactions')) {
            Schema::create('inventory_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('item_id')->constrained('inventory_items')->onDelete('cascade');
                $table->string('transaction_type'); // in, out, adjustment, transfer
                $table->integer('quantity');
                $table->decimal('unit_cost', 10, 2)->nullable();
                $table->decimal('total_cost', 10, 2)->nullable();
                $table->string('reference_number')->nullable();
                $table->text('notes')->nullable();
                $table->string('performed_by')->nullable(); // User who performed the transaction
                $table->timestamp('transaction_date');
                $table->string('supplier')->nullable(); // For incoming stock
                $table->string('recipient')->nullable(); // For outgoing stock
                $table->string('location_from')->nullable(); // For transfers
                $table->string('location_to')->nullable(); // For transfers
                $table->timestamps();
                
                $table->index(['item_id', 'transaction_type']);
                $table->index('transaction_date');
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
        Schema::dropIfExists('inventory_transactions');
    }
}
