<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamPaperWeightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('exam_paper_weights')) {
            Schema::create('exam_paper_weights', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('module_id');
                $table->unsignedInteger('academic_year_id');
                $table->unsignedInteger('assessment_type_id'); // exam type
                $table->string('paper_name');
                $table->string('paper_code')->nullable();
                $table->decimal('weight', 5, 2);
                $table->text('description')->nullable();
                $table->timestamps();
                
                $table->unique(['module_id', 'academic_year_id', 'assessment_type_id', 'paper_code'], 'exam_paper_weights_unique');
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
        Schema::dropIfExists('exam_paper_weights');
    }
}
