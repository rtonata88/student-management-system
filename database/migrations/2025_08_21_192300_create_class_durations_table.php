<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassDurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('class_durations')) {
            Schema::create('class_durations', function (Blueprint $table) {
                $table->id();
                $table->string('period_name'); // e.g., "Period 1", "Morning Session"
                $table->time('start_time');
                $table->time('end_time');
                $table->integer('duration_minutes');
                $table->enum('day_type', ['weekday', 'weekend', 'both'])->default('weekday');
                $table->boolean('is_break')->default(false);
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->index(['is_active', 'sort_order']);
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
        Schema::dropIfExists('class_durations');
    }
}
