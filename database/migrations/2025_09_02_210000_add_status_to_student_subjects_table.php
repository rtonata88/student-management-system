<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToStudentSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('student_subjects') && !Schema::hasColumn('student_subjects', 'status')) {
            Schema::table('student_subjects', function (Blueprint $table) {
            $table->enum('status', ['applied', 'admitted', 'registered'])->default('applied')->after('subject_id');
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
        Schema::table('student_subjects', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
