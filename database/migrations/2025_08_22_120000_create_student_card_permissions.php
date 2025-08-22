<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Permission;

class CreateStudentCardPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Student Card permissions following granular pattern
        $permissions = [
            'view-student-cards',
            'create-student-cards',
            'edit-student-cards',
            'delete-student-cards',
            'generate-student-cards',
            'print-student-cards',
            'upload-student-photo'
        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create([
                    'name' => $permission,
                    'display_name' => ucwords(str_replace('-', ' ', $permission)),
                    'description' => 'Permission to ' . str_replace('-', ' ', $permission)
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
            'view-student-cards',
            'create-student-cards',
            'edit-student-cards',
            'delete-student-cards',
            'generate-student-cards',
            'print-student-cards',
            'upload-student-photo'
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->delete();
        }
    }
}
