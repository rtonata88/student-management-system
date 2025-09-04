<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlternativePersonalPhoneToEmployeeProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('employee_profiles') && !Schema::hasColumn('employee_profiles', 'alternative_personal_phone')) {
            Schema::table('employee_profiles', function (Blueprint $table) {
                $table->string('alternative_personal_phone')->nullable()->after('personal_phone');
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
        if (Schema::hasTable('employee_profiles') && Schema::hasColumn('employee_profiles', 'alternative_personal_phone')) {
            Schema::table('employee_profiles', function (Blueprint $table) {
                $table->dropColumn('alternative_personal_phone');
            });
        }
    }
}
