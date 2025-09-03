<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateMarksSuppressionPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            'view-marks-suppression',
            'create-marks-suppression',
            'edit-marks-suppression',
            'delete-marks-suppression',
            'toggle-marks-suppression',
            'manage-marks-suppression'
        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
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
        $permissions = [
            'view-marks-suppression',
            'create-marks-suppression',
            'edit-marks-suppression',
            'delete-marks-suppression',
            'toggle-marks-suppression',
            'manage-marks-suppression'
        ];

        Permission::whereIn('name', $permissions)->delete();
    }
}
