<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('students') && !Schema::hasColumn('students', 'user_id')) {
            Schema::table('students', function (Blueprint $table) {
                $table->unsignedInteger('user_id')->nullable()->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                $table->index('user_id');
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
        if (Schema::hasTable('students') && Schema::hasColumn('students', 'user_id')) {
            Schema::table('students', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropIndex(['user_id']);
                $table->dropColumn('user_id');
            });
        }
    }
}
