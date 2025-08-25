<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Permission;

class CreateProofOfRegistrationPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Proof of Registration permissions
        $permissions = [
            [
                'name' => 'view-proof-of-registration',
                'display_name' => 'View Proof of Registration',
                'description' => 'Allow user to view proof of registration'
            ],
            [
                'name' => 'search-proof-of-registration',
                'display_name' => 'Search Proof of Registration',
                'description' => 'Allow user to search for student proof of registration'
            ],
            [
                'name' => 'generate-proof-of-registration',
                'display_name' => 'Generate Proof of Registration',
                'description' => 'Allow user to generate proof of registration documents'
            ],
            [
                'name' => 'download-proof-of-registration',
                'display_name' => 'Download Proof of Registration',
                'description' => 'Allow user to download proof of registration as PDF'
            ],
            [
                'name' => 'print-proof-of-registration',
                'display_name' => 'Print Proof of Registration',
                'description' => 'Allow user to print proof of registration'
            ],
            [
                'name' => 'manage-proof-of-registration',
                'display_name' => 'Manage Proof of Registration',
                'description' => 'Allow user to manage all proof of registration operations'
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
            'view-proof-of-registration',
            'search-proof-of-registration', 
            'generate-proof-of-registration',
            'download-proof-of-registration',
            'print-proof-of-registration',
            'manage-proof-of-registration'
        ];

        foreach ($permissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            if ($permission) {
                $permission->delete();
            }
        }
    }
}
