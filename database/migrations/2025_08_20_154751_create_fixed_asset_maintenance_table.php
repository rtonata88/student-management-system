<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedAssetMaintenanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('fixed_asset_maintenance')) {
            Schema::create('fixed_asset_maintenance', function (Blueprint $table) {
                $table->id();
                $table->foreignId('asset_id')->constrained('fixed_assets')->onDelete('cascade');
                $table->enum('type', ['preventive', 'corrective', 'emergency', 'inspection'])->default('preventive');
                $table->date('maintenance_date');
                $table->string('performed_by');
                $table->string('service_provider')->nullable();
                $table->text('description');
                $table->decimal('cost', 10, 2)->default(0.00);
                $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->default('scheduled');
                $table->date('next_due_date')->nullable();
                $table->text('notes')->nullable();
                $table->json('parts_replaced')->nullable();
                $table->timestamps();
                
                $table->index(['asset_id', 'maintenance_date']);
                $table->index(['status', 'next_due_date']);
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
        Schema::dropIfExists('fixed_asset_maintenance');
    }
}
