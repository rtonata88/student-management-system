<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Permission;

class CreateAcademicRecordPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Academic Record permissions
        $permissions = [
            [
                'name' => 'view-academic-records',
                'display_name' => 'View Academic Records',
                'description' => 'Allow user to view academic records'
            ],
            [
                'name' => 'search-academic-records',
                'display_name' => 'Search Academic Records',
                'description' => 'Allow user to search for student academic records'
            ],
            [
                'name' => 'generate-academic-records',
                'display_name' => 'Generate Academic Records',
                'description' => 'Allow user to generate academic record reports'
            ],
            [
                'name' => 'download-academic-records',
                'display_name' => 'Download Academic Records',
                'description' => 'Allow user to download academic records as PDF'
            ],
            [
                'name' => 'print-academic-records',
                'display_name' => 'Print Academic Records',
                'description' => 'Allow user to print academic records'
            ],
            [
                'name' => 'manage-academic-records',
                'display_name' => 'Manage Academic Records',
                'description' => 'Allow user to manage all academic record operations'
            ]
        ];

        foreach ($permissions as $permission) {
            // Check if permission already exists
            $existingPermission = Permission::where('name', $permission['name'])->first();
            
            if (!$existingPermission) {
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
        $permissions = [
            'view-academic-records',
            'search-academic-records', 
            'generate-academic-records',
            'download-academic-records',
            'print-academic-records',
            'manage-academic-records'
        ];

        foreach ($permissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            if ($permission) {
                $permission->delete();
            }
        }
    }
}
