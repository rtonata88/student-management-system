<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateNoticeBoardPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            'view-notice-board',
            'create-notice',
            'edit-notice',
            'delete-notice',
            'publish-notice',
            'manage-notice-attachments'
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
            'view-notice-board',
            'create-notice',
            'edit-notice',
            'delete-notice',
            'publish-notice',
            'manage-notice-attachments'
        ];

        Permission::whereIn('name', $permissions)->delete();
    }
}
