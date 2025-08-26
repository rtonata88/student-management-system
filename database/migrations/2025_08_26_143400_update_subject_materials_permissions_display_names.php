<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class UpdateSubjectMaterialsPermissionsDisplayNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            'view-subject-materials' => 'View Subject Materials',
            'create-subject-materials' => 'Create Subject Materials',
            'edit-subject-materials' => 'Edit Subject Materials',
            'delete-subject-materials' => 'Delete Subject Materials',
            'upload-subject-materials' => 'Upload Subject Materials',
            'download-subject-materials' => 'Download Subject Materials',
            'publish-subject-materials' => 'Publish Subject Materials'
        ];

        foreach ($permissions as $name => $displayName) {
            Permission::where('name', $name)->update(['display_name' => $displayName]);
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

        foreach ($permissions as $name) {
            Permission::where('name', $name)->update(['display_name' => null]);
        }
    }
}
