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
        // This migration is now handled by 2025_09_07_143000_fix_application_subjects_foreign_keys.php
        // to properly handle data type mismatches in foreign key constraints
        if (!Schema::hasTable('application_subjects')) {
            Schema::create('application_subjects', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('application_id'); // matches online_applications.id (unsigned bigint)
                $table->unsignedInteger('subject_id'); // matches modules.id (unsigned int)
                $table->timestamps();

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
