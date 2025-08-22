<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentWeightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('assessment_weights')) {
            Schema::create('assessment_weights', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('module_id');
                $table->unsignedInteger('academic_year_id');
                $table->unsignedBigInteger('assessment_type_id');
                $table->string('description')->nullable();
                $table->decimal('weight', 5, 2);
                $table->timestamps();

                $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
                $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
                $table->foreign('assessment_type_id')->references('id')->on('assessment_types')->onDelete('cascade');
                
                $table->unique(['module_id', 'academic_year_id', 'assessment_type_id'], 'assessment_weights_unique');
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
        Schema::dropIfExists('assessment_weights');
    }
}
