<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('notices')) {
            Schema::create('notices', function (Blueprint $table) {
                $table->id();
                $table->string('category');
                $table->string('title');
                $table->text('short_description');
                $table->longText('body');
                $table->boolean('publish')->default(false);
                $table->string('target_campus')->default('All Campuses');
                $table->json('attachments')->nullable();
                $table->unsignedInteger('created_by');
                $table->timestamps();
                
                $table->index(['category', 'publish', 'created_at']);
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
        Schema::dropIfExists('notices');
    }
}
