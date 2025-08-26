<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateAttendancePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            'view-attendance' => 'View Attendance Records',
            'create-attendance' => 'Create Attendance Records',
            'edit-attendance' => 'Edit Attendance Records',
            'delete-attendance' => 'Delete Attendance Records',
            'mark-attendance' => 'Mark Student Attendance',
            'view-attendance-reports' => 'View Attendance Reports',
            'export-attendance' => 'Export Attendance Data',
        ];

        foreach ($permissions as $name => $display_name) {
            if (!Permission::where('name', $name)->exists()) {
                Permission::create([
                    'name' => $name,
                    'display_name' => $display_name,
                    'description' => $display_name,
                ]);
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
            'view-attendance',
            'create-attendance',
            'edit-attendance',
            'delete-attendance',
            'mark-attendance',
            'view-attendance-reports',
            'export-attendance',
        ];

        Permission::whereIn('name', $permissions)->delete();
    }
}
