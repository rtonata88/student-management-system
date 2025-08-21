<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMissingColumnsToAssessmentTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assessment_types', function (Blueprint $table) {
            if (!Schema::hasColumn('assessment_types', 'code')) {
                $table->string('code')->unique()->after('name');
            }
            if (!Schema::hasColumn('assessment_types', 'mark_cap')) {
                $table->decimal('mark_cap', 5, 2)->default(100.00)->after('code');
            }
            if (!Schema::hasColumn('assessment_types', 'active')) {
                $table->boolean('active')->default(true)->after('mark_cap');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assessment_types', function (Blueprint $table) {
            $table->dropColumn(['code', 'mark_cap', 'active']);
        });
    }
}
