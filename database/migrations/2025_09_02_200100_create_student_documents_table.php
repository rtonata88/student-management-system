<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('student_documents')) {
            Schema::create('student_documents', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('student_id');
                $table->string('document_type');
                $table->string('document_name');
                $table->text('document_description')->nullable();
                $table->string('file_name');
                $table->string('file_path');
                $table->string('file_type');
                $table->bigInteger('file_size')->nullable();
                $table->boolean('is_verified')->default(false);
                $table->timestamp('verified_at')->nullable();
                $table->unsignedInteger('verified_by')->nullable();
                $table->timestamps();

                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
                $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
                $table->index(['student_id', 'document_type']);
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
        Schema::dropIfExists('student_documents');
    }
}
