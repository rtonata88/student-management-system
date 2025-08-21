<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('result_codes')) {
            Schema::create('result_codes', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('code')->unique();
                $table->text('description')->nullable();
                $table->enum('pass_fail', ['Pass', 'Fail'])->default('Pass');
                $table->boolean('active')->default(true);
                $table->timestamps();
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
        Schema::dropIfExists('result_codes');
    }
}
