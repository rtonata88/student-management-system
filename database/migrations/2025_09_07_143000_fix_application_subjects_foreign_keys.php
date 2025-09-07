<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixApplicationSubjectsForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Fix the data type mismatch for subject_id
        if (Schema::hasTable('application_subjects')) {
            // Drop the table if it exists to recreate with correct data types
            Schema::dropIfExists('application_subjects');
        }

        // Recreate the table with correct data types matching the referenced tables
        Schema::create('application_subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id'); // matches online_applications.id (unsigned bigint)
            $table->unsignedInteger('subject_id'); // matches modules.id (unsigned int)
            $table->timestamps();

            // Add foreign key constraints with correct data types
            $table->foreign('application_id')->references('id')->on('online_applications')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('modules')->onDelete('cascade');
            $table->unique(['application_id', 'subject_id']);
        });
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
