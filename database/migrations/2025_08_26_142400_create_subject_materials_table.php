<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('subject_materials')) {
            Schema::create('subject_materials', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('module_allocation_id');
                $table->string('document_name');
                $table->text('document_description')->nullable();
                $table->enum('category', [
                    'Syllabus',
                    'Class Notes', 
                    'General Info',
                    'Exam Papers',
                    'Others'
                ])->default('Class Notes');
                $table->string('file_path');
                $table->string('file_name');
                $table->string('file_type')->nullable();
                $table->integer('file_size')->nullable();
                $table->boolean('published')->default(true);
                $table->date('end_date')->nullable();
                $table->unsignedInteger('uploaded_by');
                $table->timestamps();

                $table->foreign('module_allocation_id')->references('id')->on('subject_allocations')->onDelete('cascade');
                $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
                
                $table->index(['module_allocation_id', 'category']);
                $table->index(['published', 'end_date']);
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
        Schema::dropIfExists('subject_materials');
    }
}
