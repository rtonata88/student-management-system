<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class UpdateMarksSuppressionPermissionsDisplayNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            'view-marks-suppression' => [
                'display_name' => 'View Marks Suppression',
                'description' => 'Allows users to view marks suppression records and listings'
            ],
            'create-marks-suppression' => [
                'display_name' => 'Create Marks Suppression',
                'description' => 'Allows users to create new marks suppression entries'
            ],
            'edit-marks-suppression' => [
                'display_name' => 'Edit Marks Suppression',
                'description' => 'Allows users to edit and update existing marks suppression records'
            ],
            'delete-marks-suppression' => [
                'display_name' => 'Delete Marks Suppression',
                'description' => 'Allows users to delete marks suppression records'
            ],
            'toggle-marks-suppression' => [
                'display_name' => 'Toggle Marks Suppression',
                'description' => 'Allows users to activate or deactivate marks suppression status'
            ],
            'manage-marks-suppression' => [
                'display_name' => 'Manage Marks Suppression',
                'description' => 'Full management access to marks suppression system including all operations'
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissionNames = [
            'view-marks-suppression',
            'create-marks-suppression',
            'edit-marks-suppression',
            'delete-marks-suppression',
            'toggle-marks-suppression',
            'manage-marks-suppression'
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
    }
}
