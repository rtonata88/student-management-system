<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateSubjectMaterialsPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            'view-subject-materials',
            'create-subject-materials',
            'edit-subject-materials',
            'delete-subject-materials',
            'upload-subject-materials',
            'download-subject-materials',
            'publish-subject-materials'
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
            'view-subject-materials',
            'create-subject-materials',
            'edit-subject-materials',
            'delete-subject-materials',
            'upload-subject-materials',
            'download-subject-materials',
            'publish-subject-materials'
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->delete();
        }
    }
}
