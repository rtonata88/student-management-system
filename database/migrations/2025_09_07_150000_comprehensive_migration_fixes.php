<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ComprehensiveMigrationFixes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // This migration handles all remaining foreign key constraint issues
        // and ensures proper data type alignment across all tables

        // 1. Fix student_documents table if it has foreign key issues
        if (Schema::hasTable('student_documents')) {
            // Check if there are invalid student_id references
            DB::table('student_documents')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('students')
                          ->whereRaw('students.id = student_documents.student_id');
                })
                ->delete();
        }

        // 2. Fix any remaining examination_schedules issues
        if (Schema::hasTable('examination_schedules')) {
            // Clean up invalid venue_id references
            DB::table('examination_schedules')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('venues')
                          ->whereRaw('venues.id = examination_schedules.venue_id');
                })
                ->delete();

            // Clean up invalid subject_allocation_id references
            DB::table('examination_schedules')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('subject_allocations')
                          ->whereRaw('subject_allocations.id = examination_schedules.subject_allocation_id');
                })
                ->delete();

            // Clean up invalid examination_id references
            DB::table('examination_schedules')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('assessment_types')
                          ->whereRaw('assessment_types.id = examination_schedules.examination_id');
                })
                ->delete();

            // Clean up invalid class_duration_id references
            DB::table('examination_schedules')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('class_durations')
                          ->whereRaw('class_durations.id = examination_schedules.class_duration_id');
                })
                ->delete();
        }

        // 3. Fix any remaining module_registrations issues
        if (Schema::hasTable('module_registrations')) {
            // Clean up invalid student_id references
            DB::table('module_registrations')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('students')
                          ->whereRaw('students.id = module_registrations.student_id');
                })
                ->delete();

            // Clean up invalid module_id references
            DB::table('module_registrations')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('modules')
                          ->whereRaw('modules.id = module_registrations.module_id');
                })
                ->delete();
        }

        // 4. Fix any remaining ca_marks issues
        if (Schema::hasTable('ca_marks')) {
            // Clean up invalid student_id references
            DB::table('ca_marks')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('students')
                          ->whereRaw('students.id = ca_marks.student_id');
                })
                ->delete();

            // Clean up invalid module_id references
            DB::table('ca_marks')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('modules')
                          ->whereRaw('modules.id = ca_marks.module_id');
                })
                ->delete();
        }

        // 5. Fix any remaining exam_marks issues
        if (Schema::hasTable('exam_marks')) {
            // Clean up invalid student_id references
            DB::table('exam_marks')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('students')
                          ->whereRaw('students.id = exam_marks.student_id');
                })
                ->delete();

            // Clean up invalid module_id references
            DB::table('exam_marks')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('modules')
                          ->whereRaw('modules.id = exam_marks.module_id');
                })
                ->delete();
        }

        // 6. Fix any remaining payments issues
        if (Schema::hasTable('payments')) {
            // Clean up invalid student_id references
            DB::table('payments')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('students')
                          ->whereRaw('students.id = payments.student_id');
                })
                ->delete();
        }

        // 7. Fix any remaining cashier_payments issues
        if (Schema::hasTable('cashier_payments')) {
            // Clean up invalid student_id references
            DB::table('cashier_payments')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('students')
                          ->whereRaw('students.id = cashier_payments.student_id');
                })
                ->delete();

            // Clean up invalid cashier_id references
            DB::table('cashier_payments')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('users')
                          ->whereRaw('users.id = cashier_payments.cashier_id');
                })
                ->delete();
        }

        // 8. Ensure all students have valid center_id
        if (Schema::hasTable('students') && Schema::hasColumn('students', 'center_id')) {
            $defaultCenterId = DB::table('centers')->first()->id ?? 1;
            DB::table('students')
                ->whereNull('center_id')
                ->orWhere('center_id', 0)
                ->orWhere('center_id', '')
                ->orWhereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('centers')
                          ->whereRaw('centers.id = students.center_id');
                })
                ->update(['center_id' => $defaultCenterId]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // This migration cleanup is not easily reversible
    }
}
