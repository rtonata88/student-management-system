<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateExamPermitsPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create exam permits permissions
        $permissions = [
            'view-exam-permits',
            'search-exam-permits', 
            'generate-exam-permits',
            'download-exam-permits',
            'print-exam-permits',
            'manage-exam-permits'
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
            'view-exam-permits',
            'search-exam-permits',
            'generate-exam-permits', 
            'download-exam-permits',
            'print-exam-permits',
            'manage-exam-permits'
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->delete();
        }
    }
}
