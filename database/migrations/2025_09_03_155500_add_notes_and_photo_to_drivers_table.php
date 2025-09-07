<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotesAndPhotoToDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('drivers')) {
            // Add emergency_contact_phone if it doesn't exist
            if (!Schema::hasColumn('drivers', 'emergency_contact_phone')) {
                Schema::table('drivers', function (Blueprint $table) {
                    $table->string('emergency_contact_phone')->nullable()->after('phone');
                });
            }
            
            // Add notes if it doesn't exist
            if (!Schema::hasColumn('drivers', 'notes')) {
                Schema::table('drivers', function (Blueprint $table) {
                    $table->text('notes')->nullable()->after('emergency_contact_phone');
                });
            }
            
            // Add photo if it doesn't exist
            if (!Schema::hasColumn('drivers', 'photo')) {
                Schema::table('drivers', function (Blueprint $table) {
                    $table->string('photo')->nullable()->after('notes');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('drivers')) {
            Schema::table('drivers', function (Blueprint $table) {
                $columnsToRemove = [];
                
                if (Schema::hasColumn('drivers', 'photo')) {
                    $columnsToRemove[] = 'photo';
                }
                
                if (Schema::hasColumn('drivers', 'notes')) {
                    $columnsToRemove[] = 'notes';
                }
                
                if (Schema::hasColumn('drivers', 'emergency_contact_phone')) {
                    $columnsToRemove[] = 'emergency_contact_phone';
                }
                
                if (!empty($columnsToRemove)) {
                    $table->dropColumn($columnsToRemove);
                }
            });
        }
    }
}
