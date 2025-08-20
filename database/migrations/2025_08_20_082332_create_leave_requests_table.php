<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('leave_requests')) {
            Schema::create('leave_requests', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('user_id');
                $table->unsignedBigInteger('leave_type_id');
                $table->date('start_date');
                $table->date('end_date');
                $table->integer('total_days');
                $table->text('reason');
                $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
                $table->text('admin_comments')->nullable();
                $table->unsignedInteger('approved_by')->nullable();
                $table->timestamp('approved_at')->nullable();
                $table->unsignedInteger('created_by'); // For admin-created leaves
                $table->boolean('is_half_day')->default(false);
                $table->enum('half_day_period', ['morning', 'afternoon'])->nullable();
                $table->string('attachment')->nullable(); // For supporting documents
                $table->timestamps();
                
                // Foreign keys
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade');
                $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
                
                // Indexes
                $table->index('user_id');
                $table->index('leave_type_id');
                $table->index('status');
                $table->index('start_date');
                $table->index('end_date');
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
        Schema::dropIfExists('leave_requests');
    }
}
