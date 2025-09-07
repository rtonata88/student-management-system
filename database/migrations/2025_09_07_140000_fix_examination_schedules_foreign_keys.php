<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixExaminationSchedulesForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if examination_schedules table exists
        if (!Schema::hasTable('examination_schedules')) {
            return;
        }

        // First, handle any existing examination schedules with invalid head_invigilator_id
        if (Schema::hasColumn('examination_schedules', 'head_invigilator_id')) {
            // Set invalid head_invigilator_id values to null
            DB::table('examination_schedules')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('users')
                          ->whereRaw('users.id = examination_schedules.head_invigilator_id');
                })
                ->update(['head_invigilator_id' => null]);
        }

        // Drop and recreate the foreign key constraint for head_invigilator_id if it exists
        Schema::table('examination_schedules', function (Blueprint $table) {
            // Try to drop existing foreign key constraint
            try {
                $table->dropForeign(['head_invigilator_id']);
            } catch (Exception $e) {
                // Foreign key doesn't exist, continue
            }
        });

        // Re-add the foreign key constraint properly
        if (Schema::hasColumn('examination_schedules', 'head_invigilator_id')) {
            Schema::table('examination_schedules', function (Blueprint $table) {
                $table->foreign('head_invigilator_id')
                      ->references('id')
                      ->on('users')
                      ->onDelete('set null');
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
        // No need to reverse this fix
    }
}
