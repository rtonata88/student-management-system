<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('application_documents')) {
            Schema::create('application_documents', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('application_id');
                $table->string('document_type'); // id_certificate, birth_certificate, school_certificate, proof_of_payment, other
                $table->string('document_name');
                $table->string('file_path');
                $table->string('file_name');
                $table->string('file_type');
                $table->integer('file_size');
                $table->boolean('verified')->default(false);
                $table->text('verification_notes')->nullable();
                $table->unsignedInteger('verified_by')->nullable();
                $table->timestamp('verified_at')->nullable();
                $table->timestamps();

                $table->foreign('application_id')->references('id')->on('online_applications')->onDelete('cascade');
                $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
                $table->index(['application_id', 'document_type']);
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
        Schema::dropIfExists('application_documents');
    }
}
