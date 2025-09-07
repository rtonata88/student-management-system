<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEmailPhoneDescriptionFromDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('departments') && !Schema::hasColumn('departments', 'email')) {
            Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn(['email', 'phone', 'description']);
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
        Schema::table('departments', function (Blueprint $table) {
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('description')->nullable();
        });
    }
}
