<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToVehicleAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('vehicle_assignments')) {
            Schema::table('vehicle_assignments', function (Blueprint $table) {
                if (!Schema::hasColumn('vehicle_assignments', 'assignment_type')) {
                    $table->enum('assignment_type', ['primary', 'secondary', 'temporary'])->default('primary')->after('driver_id');
                }
                if (!Schema::hasColumn('vehicle_assignments', 'start_date')) {
                    $table->date('start_date')->nullable()->after('assignment_type');
                }
                if (!Schema::hasColumn('vehicle_assignments', 'end_date')) {
                    $table->date('end_date')->nullable()->after('start_date');
                }
                if (!Schema::hasColumn('vehicle_assignments', 'status')) {
                    $table->enum('status', ['active', 'inactive'])->default('active')->after('end_date');
                }
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
        if (Schema::hasTable('vehicle_assignments')) {
            Schema::table('vehicle_assignments', function (Blueprint $table) {
                if (Schema::hasColumn('vehicle_assignments', 'assignment_type')) {
                    $table->dropColumn('assignment_type');
                }
                if (Schema::hasColumn('vehicle_assignments', 'start_date')) {
                    $table->dropColumn('start_date');
                }
                if (Schema::hasColumn('vehicle_assignments', 'end_date')) {
                    $table->dropColumn('end_date');
                }
                if (Schema::hasColumn('vehicle_assignments', 'status')) {
                    $table->dropColumn('status');
                }
            });
        }
    }
}
