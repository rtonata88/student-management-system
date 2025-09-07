<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSympolToModuleRegistration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    {
    {
    {
        if (Schema::hasTable('module_registrations') && !Schema::hasColumn('module_registrations', 'subject_symbol')) {
            if (Schema::hasTable('module_registrations') && !Schema::hasColumn('module_registrations', 'system')) {
            Schema::table('module_registrations', function (Blueprint $table) {
            $table->string('subject_symbol')->nullable()->after('cancellation_date');
            $table->string('system')->nullable()->after('subject_symbol');
        });
        }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('module_registrations', function (Blueprint $table) {
            $table->dropColumn('subject_symbol');
            $table->dropColumn('system');
        });
    }
}
