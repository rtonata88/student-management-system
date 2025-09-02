<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserTypeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'user_type')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('user_type', ['staff', 'student', 'parent'])->default('staff')->after('email');
                $table->index('user_type');
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
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'user_type')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex(['user_type']);
                $table->dropColumn('user_type');
            });
        }
    }
}
