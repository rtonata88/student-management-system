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
        // This migration is now handled by 2025_09_07_140000_fix_examination_schedules_foreign_keys.php
        // to properly handle existing data before adding foreign key constraints
        if (Schema::hasTable('examination_schedules') && !Schema::hasColumn('examination_schedules', 'head_invigilator_id')) {
            Schema::table('examination_schedules', function (Blueprint $table) {
                $table->unsignedBigInteger('head_invigilator_id')->nullable()->after('class_duration_id');
                
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
