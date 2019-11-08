<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartmentToProfileOrganizations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organization_profiles', function (Blueprint $table) {
            $table->string('department')->after('position')->nullable();
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->string('platform')->after('website')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organization_profiles', function (Blueprint $table) {
            //
        });
    }
}
