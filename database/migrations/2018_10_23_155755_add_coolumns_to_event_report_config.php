<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoolumnsToEventReportConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_report_configurations', function (Blueprint $table) {
            $table->text('summary')->nullable()->after('feedback_type');
            $table->text('strengths')->nullable()->after('summary');
            $table->text('weaknesses')->nullable()->after('strengths');
            $table->text('opportunities')->nullable()->after('weaknesses');
            $table->text('threats')->nullable()->after('opportunities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_report_configurations', function (Blueprint $table) {
            //
        });
    }
}
