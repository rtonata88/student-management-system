<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMissingTripLogsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('trip_logs')) {
            Schema::table('trip_logs', function (Blueprint $table) {
                if (!Schema::hasColumn('trip_logs', 'route_taken')) {
                    $table->text('route_taken')->nullable()->after('destination');
                }
                if (!Schema::hasColumn('trip_logs', 'estimated_distance')) {
                    $table->decimal('estimated_distance', 8, 2)->nullable()->after('route_taken');
                }
                if (!Schema::hasColumn('trip_logs', 'passengers_count')) {
                    $table->integer('passengers_count')->nullable()->after('estimated_distance');
                }
                if (!Schema::hasColumn('trip_logs', 'notes')) {
                    $table->text('notes')->nullable()->after('passengers_count');
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
        if (Schema::hasTable('trip_logs')) {
            Schema::table('trip_logs', function (Blueprint $table) {
                if (Schema::hasColumn('trip_logs', 'route_taken')) {
                    $table->dropColumn('route_taken');
                }
                if (Schema::hasColumn('trip_logs', 'estimated_distance')) {
                    $table->dropColumn('estimated_distance');
                }
                if (Schema::hasColumn('trip_logs', 'passengers_count')) {
                    $table->dropColumn('passengers_count');
                }
                if (Schema::hasColumn('trip_logs', 'notes')) {
                    $table->dropColumn('notes');
                }
            });
        }
    }
}
