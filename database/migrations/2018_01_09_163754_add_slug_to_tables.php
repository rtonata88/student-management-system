<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->string('slug')->after('name');
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->string('slug')->after('name');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->string('slug')->after('name');
        });

        Schema::table('duties', function (Blueprint $table) {
            $table->string('slug')->after('name');
        });

        Schema::table('event_types', function (Blueprint $table) {
            $table->string('slug')->after('type');
        });

        Schema::table('fruit_levels', function (Blueprint $table) {
            $table->string('slug')->after('level');
        });

        Schema::table('fruit_roles', function (Blueprint $table) {
            $table->string('slug')->after('role');
        });


        Schema::table('fruit_stages', function (Blueprint $table) {
            $table->string('slug')->after('stage');
        });

        Schema::table('maintainers', function (Blueprint $table) {
            $table->string('slug')->after('name');
        });

        Schema::table('meeting_types', function (Blueprint $table) {
            $table->string('slug')->after('type');
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->string('slug')->after('name');
        });

        Schema::table('profiles', function (Blueprint $table) {
            $table->string('slug')->after('lastname');
        });

        Schema::table('sector_relationships', function (Blueprint $table) {
            $table->string('relationship')->after('language_id');
            $table->string('slug')->after('language_id');
        });

        Schema::table('sectors', function (Blueprint $table) {
            $table->string('slug')->after('name');
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->string('slug')->after('name');
        });

        Schema::table('titles', function (Blueprint $table) {
            $table->string('slug')->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cities', function (Blueprint $table) {
            //
        });
    }
}
