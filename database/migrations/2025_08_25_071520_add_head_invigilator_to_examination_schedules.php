<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeadInvigilatorToExaminationSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('examination_schedules') && !Schema::hasColumn('examination_schedules', 'head_invigilator_id')) {
            Schema::table('examination_schedules', function (Blueprint $table) {
                $table->unsignedBigInteger('head_invigilator_id')->nullable()->after('class_duration_id');
                
                // Add foreign key constraint
                $table->foreign('head_invigilator_id')->references('id')->on('users')->onDelete('set null');
                
                // Add index for better performance
                $table->index(['head_invigilator_id', 'exam_date', 'class_duration_id']);
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
        if (Schema::hasTable('examination_schedules') && Schema::hasColumn('examination_schedules', 'head_invigilator_id')) {
            Schema::table('examination_schedules', function (Blueprint $table) {
                $table->dropForeign(['head_invigilator_id']);
                $table->dropIndex(['head_invigilator_id', 'exam_date', 'class_duration_id']);
                $table->dropColumn('head_invigilator_id');
            });
        }
    }
}
