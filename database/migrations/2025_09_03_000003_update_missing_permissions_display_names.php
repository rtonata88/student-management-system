<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class UpdateMissingPermissionsDisplayNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update permissions by ID since we know the specific IDs that need fixing
        $permissionUpdates = [
            533 => [
                'display_name' => 'Review Online Applications',
                'description' => 'Allows users to review and process online application submissions'
            ],
            539 => [
                'display_name' => 'Manage Student Portal',
                'description' => 'Full management access to student portal features and settings'
            ]
        ];

        foreach ($permissionUpdates as $id => $details) {
            $permission = Permission::find($id);
            if ($permission) {
                $permission->update([
                    'display_name' => $details['display_name'],
                    'description' => $details['description']
                ]);
            }
        }

        // Also update any other permissions that might be missing display names
        $permissions = Permission::whereNull('display_name')->orWhere('display_name', '')->get();
        
        foreach ($permissions as $permission) {
            $displayName = ucwords(str_replace(['-', '_'], ' ', $permission->name));
            $description = 'Allows users to ' . strtolower(str_replace(['-', '_'], ' ', $permission->name));
            
            $permission->update([
                'display_name' => $displayName,
                'description' => $description
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissionIds = [533, 539];

        foreach ($permissionIds as $id) {
            $permission = Permission::find($id);
            if ($permission) {
                $permission->update([
                    'display_name' => null,
                    'description' => null
                ]);
            }
        }
    }
}
