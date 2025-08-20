<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('inventory_items')) {
            Schema::create('inventory_items', function (Blueprint $table) {
                $table->id();
                $table->string('item_code')->unique();
                $table->string('name');
                $table->text('description')->nullable();
                $table->foreignId('category_id')->constrained('inventory_categories')->onDelete('cascade');
                $table->string('unit_of_measure'); // e.g., pieces, boxes, liters, etc.
                $table->decimal('unit_cost', 10, 2)->default(0);
                $table->integer('quantity_in_stock')->default(0);
                $table->integer('minimum_stock_level')->default(0);
                $table->integer('maximum_stock_level')->nullable();
                $table->string('supplier')->nullable();
                $table->string('location')->nullable(); // Storage location
                $table->date('expiry_date')->nullable();
                $table->string('barcode')->nullable();
                $table->json('specifications')->nullable(); // Additional specs as JSON
                $table->string('status')->default('active'); // active, inactive, discontinued
                $table->timestamps();
                
                $table->index(['category_id', 'status']);
                $table->index('item_code');
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
        Schema::dropIfExists('inventory_items');
    }
}
