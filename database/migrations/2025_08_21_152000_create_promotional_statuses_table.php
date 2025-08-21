<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionalStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('promotional_statuses')) {
            Schema::create('promotional_statuses', function (Blueprint $table) {
                $table->increments('id');
                $table->enum('promoted', ['Yes', 'No']);
                $table->string('description', 255);
                $table->boolean('active')->default(true);
                $table->timestamps();
                
                // Add unique constraint to prevent duplicate descriptions
                $table->unique('description');
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
        Schema::dropIfExists('promotional_statuses');
    }
}
