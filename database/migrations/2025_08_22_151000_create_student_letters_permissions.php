<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateStudentLettersPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create student letters permissions
        $permissions = [
            'view-student-letters',
            'create-student-letters', 
            'edit-student-letters',
            'delete-student-letters',
            'generate-student-letters',
            'print-student-letters',
            'download-student-letters'
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
            'view-student-letters',
            'create-student-letters', 
            'edit-student-letters',
            'delete-student-letters',
            'generate-student-letters',
            'print-student-letters',
            'download-student-letters'
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->delete();
        }
    }
}
