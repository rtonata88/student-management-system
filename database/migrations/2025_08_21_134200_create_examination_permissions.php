<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Permission;

class CreateExaminationPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create examination permissions
        $permissions = [
            [
                'name' => 'examinations',
                'display_name' => 'View Examinations',
                'description' => 'View examinations list'
            ],
            [
                'name' => 'add-examinations',
                'display_name' => 'Add Examinations',
                'description' => 'Create new examination types'
            ],
            [
                'name' => 'edit-examinations',
                'display_name' => 'Edit Examinations',
                'description' => 'Edit existing examination types'
            ],
            [
                'name' => 'delete-examinations',
                'display_name' => 'Delete Examinations',
                'description' => 'Delete examination types'
            ]
        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission['name'])->exists()) {
                Permission::create($permission);
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
        $permissions = ['examinations', 'add-examinations', 'edit-examinations', 'delete-examinations'];
        
        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->delete();
        }
    }
}
