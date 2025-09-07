<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixHostelAllocationsForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('hostel_allocations')) {
            if (Schema::hasTable('hostel_allocations') && !Schema::hasColumn('hostel_allocations', 'student_id')) {
            Schema::table('hostel_allocations', function (Blueprint $table) {
                // Drop existing foreign key constraints if they exist
                try {
                    $table->dropForeign(['student_id']);
                } catch (Exception $e) {
                    // Foreign key might not exist, continue
                }
                
                try {
                    $table->dropForeign(['allocated_by']);
                } catch (Exception $e) {
                    // Foreign key might not exist, continue
                }
                
                // Add new foreign key constraints pointing to students table
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
                $table->foreign('allocated_by')->references('id')->on('users');
            });
        }
        }
        }
        }
        
        // Also fix hostel_payments table if it exists
        if (Schema::hasTable('hostel_payments')) {
            if (Schema::hasTable('hostel_payments') && !Schema::hasColumn('hostel_payments', 'student_id')) {
            Schema::table('hostel_payments', function (Blueprint $table) {
                try {
                    $table->dropForeign(['student_id']);
                } catch (Exception $e) {
                    // Foreign key might not exist, continue
                }
                
                // Add new foreign key constraint pointing to students table
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            });
        }
        
        // Also fix hostel_visitors table if it exists
        if (Schema::hasTable('hostel_visitors')) {
            if (Schema::hasTable('hostel_visitors') && !Schema::hasColumn('hostel_visitors', 'student_id')) {
            Schema::table('hostel_visitors', function (Blueprint $table) {
                try {
                    $table->dropForeign(['student_id']);
                } catch (Exception $e) {
                    // Foreign key might not exist, continue
                }
                
                // Add new foreign key constraint pointing to students table
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
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
        if (Schema::hasTable('hostel_allocations')) {
            Schema::table('hostel_allocations', function (Blueprint $table) {
                $table->dropForeign(['student_id']);
                $table->dropForeign(['allocated_by']);
                
                // Restore original foreign keys
                $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('allocated_by')->references('id')->on('users');
            });
        }
        
        if (Schema::hasTable('hostel_payments')) {
            Schema::table('hostel_payments', function (Blueprint $table) {
                $table->dropForeign(['student_id']);
                $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
        
        if (Schema::hasTable('hostel_visitors')) {
            Schema::table('hostel_visitors', function (Blueprint $table) {
                $table->dropForeign(['student_id']);
                $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }
}
