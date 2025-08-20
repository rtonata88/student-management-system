<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('fixed_assets')) {
            Schema::create('fixed_assets', function (Blueprint $table) {
                $table->id();
                $table->string('asset_tag')->unique();
                $table->string('name');
                $table->text('description')->nullable();
                $table->foreignId('category_id')->constrained('fixed_asset_categories')->onDelete('restrict');
                $table->string('brand')->nullable();
                $table->string('model')->nullable();
                $table->string('serial_number')->nullable();
                $table->decimal('purchase_cost', 12, 2);
                $table->date('purchase_date');
                $table->string('supplier')->nullable();
                $table->string('warranty_period')->nullable();
                $table->date('warranty_expiry')->nullable();
                $table->string('location');
                $table->string('department')->nullable();
                $table->string('assigned_to')->nullable();
                $table->enum('condition', ['excellent', 'good', 'fair', 'poor', 'damaged'])->default('good');
                $table->enum('status', ['active', 'inactive', 'disposed', 'lost', 'stolen', 'maintenance'])->default('active');
                $table->decimal('current_value', 12, 2)->nullable();
                $table->decimal('accumulated_depreciation', 12, 2)->default(0.00);
                $table->date('last_maintenance')->nullable();
                $table->date('next_maintenance')->nullable();
                $table->json('specifications')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
                
                $table->index(['status', 'category_id']);
                $table->index(['location', 'department']);
                $table->index(['assigned_to']);
                $table->index(['warranty_expiry']);
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
        Schema::dropIfExists('fixed_assets');
    }
}
