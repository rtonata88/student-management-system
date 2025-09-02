<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('application_subjects')) {
            Schema::create('application_subjects', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('application_id');
                $table->unsignedBigInteger('subject_id');
                $table->timestamps();

                $table->foreign('application_id')->references('id')->on('online_applications')->onDelete('cascade');
                $table->foreign('subject_id')->references('id')->on('modules')->onDelete('cascade');
                $table->unique(['application_id', 'subject_id']);
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
        Schema::dropIfExists('application_subjects');
    }
}
