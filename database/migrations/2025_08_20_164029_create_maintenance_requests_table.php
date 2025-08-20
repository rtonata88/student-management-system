<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('maintenance_requests')) {
            Schema::create('maintenance_requests', function (Blueprint $table) {
                $table->id();
                $table->string('request_number')->unique(); // Auto-generated request number
                $table->unsignedBigInteger('category_id');
                $table->unsignedInteger('requested_by'); // User ID
                $table->string('title');
                $table->text('description');
                $table->string('location'); // Building, room, area
                $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
                $table->enum('status', ['pending', 'approved', 'in_progress', 'completed', 'cancelled'])->default('pending');
                $table->date('requested_date');
                $table->date('required_completion_date')->nullable();
                $table->date('actual_completion_date')->nullable();
                $table->decimal('estimated_cost', 10, 2)->nullable();
                $table->decimal('actual_cost', 10, 2)->nullable();
                $table->unsignedInteger('approved_by')->nullable(); // User ID
                $table->timestamp('approved_at')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->foreign('category_id')->references('id')->on('maintenance_categories')->onDelete('cascade');
                $table->foreign('requested_by')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');

                $table->index(['status']);
                $table->index(['priority']);
                $table->index(['requested_date']);
                $table->index(['required_completion_date']);
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
        Schema::dropIfExists('maintenance_requests');
    }
}