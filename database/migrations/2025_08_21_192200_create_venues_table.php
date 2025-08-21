<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('venues')) {
            Schema::create('venues', function (Blueprint $table) {
                $table->id();
                $table->string('venue_name');
                $table->string('venue_code')->unique();
                $table->integer('capacity');
                $table->text('description')->nullable();
                $table->unsignedInteger('center_id');
                $table->enum('venue_type', ['classroom', 'laboratory', 'hall', 'library', 'other'])->default('classroom');
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
                $table->index(['center_id', 'is_active']);
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
        Schema::dropIfExists('venues');
    }
}
