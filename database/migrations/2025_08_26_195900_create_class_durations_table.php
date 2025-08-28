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
                $table->string('period_name');
                $table->integer('duration_minutes');
                $table->time('start_time')->nullable();
                $table->time('end_time')->nullable();
                $table->string('description')->nullable();
                $table->boolean('active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
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
