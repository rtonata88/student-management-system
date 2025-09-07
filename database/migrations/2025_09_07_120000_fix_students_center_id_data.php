<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixStudentsCenterIdData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First, check if center_id column exists
        if (!Schema::hasColumn('students', 'center_id')) {
            // Add the column without foreign key constraint first
            Schema::table('students', function (Blueprint $table) {
                $table->unsignedInteger('center_id')->nullable()->after('student_names');
            });
        }

        // Get the first available center ID as default
        $defaultCenterId = DB::table('centers')->first()->id ?? 1;

        // Update all students without center_id to use the default center
        DB::table('students')
            ->whereNull('center_id')
            ->orWhere('center_id', 0)
            ->orWhere('center_id', '')
            ->update(['center_id' => $defaultCenterId]);

        // Now add the foreign key constraint
        Schema::table('students', function (Blueprint $table) {
            // Drop existing foreign key if it exists
            try {
                $table->dropForeign(['center_id']);
            } catch (Exception $e) {
                // Foreign key doesn't exist, continue
            }
            
            // Make column not nullable and add foreign key
            $table->unsignedInteger('center_id')->nullable(false)->change();
            $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['center_id']);
            $table->dropColumn('center_id');
        });
    }
}
