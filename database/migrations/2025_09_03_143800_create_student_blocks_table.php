<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('student_blocks')) {
            Schema::create('student_blocks', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('student_id');
                $table->string('student_number');
                $table->text('reason');
                $table->decimal('block_amount', 10, 2)->default(0.00);
                $table->string('batch_number')->nullable();
                $table->boolean('is_exception')->default(false);
                $table->boolean('is_active')->default(true);
                $table->unsignedInteger('blocked_by');
                $table->timestamp('blocked_at');
                $table->unsignedInteger('unblocked_by')->nullable();
                $table->timestamp('unblocked_at')->nullable();
                $table->timestamps();

                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
                $table->foreign('blocked_by')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('unblocked_by')->references('id')->on('users')->onDelete('cascade');
                
                $table->index(['student_id', 'is_active']);
                $table->index('student_number');
                $table->index('batch_number');
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
        Schema::dropIfExists('student_blocks');
    }
}
