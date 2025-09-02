<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('online_applications')) {
            Schema::create('online_applications', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('user_id');
                $table->string('application_number')->unique();
                $table->string('status')->default('pending'); // pending, under_review, approved, rejected
                $table->text('admin_notes')->nullable();
                $table->timestamp('submitted_at')->nullable();
                $table->timestamp('reviewed_at')->nullable();
                $table->unsignedInteger('reviewed_by')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
                $table->index(['status', 'submitted_at']);
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
        Schema::dropIfExists('online_applications');
    }
}
