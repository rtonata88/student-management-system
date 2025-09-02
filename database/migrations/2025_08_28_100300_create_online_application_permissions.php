<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineApplicationPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            'view-online-applications',
            'review-online-applications',
            'approve-online-applications',
            'reject-online-applications',
            'download-application-documents',
            'verify-application-documents',
            'access-student-portal',
            'manage-student-portal'
        ];

        foreach ($permissions as $permission) {
            if (!\App\Permission::where('name', $permission)->exists()) {
                \App\Permission::create(['name' => $permission]);
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
            'view-online-applications',
            'review-online-applications',
            'approve-online-applications',
            'reject-online-applications',
            'download-application-documents',
            'verify-application-documents',
            'access-student-portal',
            'manage-student-portal'
        ];

        \App\Permission::whereIn('name', $permissions)->delete();
    }
}
