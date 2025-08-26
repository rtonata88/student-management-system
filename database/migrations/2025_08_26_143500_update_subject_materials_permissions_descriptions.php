<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class UpdateSubjectMaterialsPermissionsDescriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            'view-subject-materials' => 'View subject materials for allocated modules',
            'create-subject-materials' => 'Create new subject materials',
            'edit-subject-materials' => 'Edit existing subject materials',
            'delete-subject-materials' => 'Delete subject materials',
            'upload-subject-materials' => 'Upload files and materials for subjects',
            'download-subject-materials' => 'Download subject materials and files',
            'publish-subject-materials' => 'Publish and unpublish subject materials'
        ];

        foreach ($permissions as $name => $description) {
            Permission::where('name', $name)->update(['description' => $description]);
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
            Permission::where('name', $name)->update(['description' => null]);
        }
    }
}
