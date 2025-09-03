<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class UpdateNoticeBoardPermissionsDisplayNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            'view-notice-board' => [
                'display_name' => 'View Notice Board',
                'description' => 'Allows users to view notice board entries and announcements'
            ],
            'create-notice' => [
                'display_name' => 'Create Notice',
                'description' => 'Allows users to create new notice board entries'
            ],
            'edit-notice' => [
                'display_name' => 'Edit Notice',
                'description' => 'Allows users to edit and update existing notice board entries'
            ],
            'delete-notice' => [
                'display_name' => 'Delete Notice',
                'description' => 'Allows users to delete notice board entries'
            ],
            'publish-notice' => [
                'display_name' => 'Publish Notice',
                'description' => 'Allows users to publish or unpublish notice board entries'
            ],
            'manage-notice-attachments' => [
                'display_name' => 'Manage Notice Attachments',
                'description' => 'Allows users to manage file attachments for notice board entries'
            ]
        ];

        foreach ($permissions as $name => $details) {
            $permission = Permission::where('name', $name)->first();
            if ($permission) {
                $permission->update([
                    'display_name' => $details['display_name'],
                    'description' => $details['description']
                ]);
            }
        }

        // Also update permissions by ID range 501-506 in case they have different names
        for ($id = 501; $id <= 506; $id++) {
            $permission = Permission::find($id);
            if ($permission && (empty($permission->description) || is_null($permission->description))) {
                // Generate description based on permission name if not already set above
                if (!in_array($permission->name, array_keys($permissions))) {
                    $displayName = $permission->display_name ?: ucwords(str_replace(['-', '_'], ' ', $permission->name));
                    $description = 'Allows users to ' . strtolower(str_replace(['-', '_'], ' ', $permission->name));
                    
                    $permission->update([
                        'display_name' => $displayName,
                        'description' => $description
                    ]);
                }
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
        $permissionNames = [
            'view-notice-board',
            'create-notice',
            'edit-notice',
            'delete-notice',
            'publish-notice',
            'manage-notice-attachments'
        ];

        foreach ($permissionNames as $name) {
            $permission = Permission::where('name', $name)->first();
            if ($permission) {
                $permission->update([
                    'display_name' => null,
                    'description' => null
                ]);
            }
        }

        // Also clear descriptions for ID range 501-506
        for ($id = 501; $id <= 506; $id++) {
            $permission = Permission::find($id);
            if ($permission) {
                $permission->update([
                    'description' => null
                ]);
            }
        }
    }
}
