<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class UpdateOnlineApplicationPermissionsDisplayNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            'view-online-applications' => [
                'display_name' => 'View Online Applications',
                'description' => 'Allows users to view online application records and listings'
            ],
            'create-online-applications' => [
                'display_name' => 'Create Online Applications',
                'description' => 'Allows users to create new online application entries'
            ],
            'edit-online-applications' => [
                'display_name' => 'Edit Online Applications',
                'description' => 'Allows users to edit and update existing online application records'
            ],
            'delete-online-applications' => [
                'display_name' => 'Delete Online Applications',
                'description' => 'Allows users to delete online application records'
            ],
            'approve-online-applications' => [
                'display_name' => 'Approve Online Applications',
                'description' => 'Allows users to approve submitted online applications'
            ],
            'reject-online-applications' => [
                'display_name' => 'Reject Online Applications',
                'description' => 'Allows users to reject submitted online applications'
            ],
            'verify-application-documents' => [
                'display_name' => 'Verify Application Documents',
                'description' => 'Allows users to verify and validate application documents'
            ],
            'download-application-documents' => [
                'display_name' => 'Download Application Documents',
                'description' => 'Allows users to download application documents'
            ],
            'manage-online-submissions' => [
                'display_name' => 'Manage Online Submissions',
                'description' => 'Full management access to online application submissions'
            ],
            'access-student-portal' => [
                'display_name' => 'Access Student Portal',
                'description' => 'Allows users to access the student portal dashboard'
            ],
            'view-student-profile' => [
                'display_name' => 'View Student Profile',
                'description' => 'Allows users to view student profile information'
            ],
            'view-student-academics' => [
                'display_name' => 'View Student Academics',
                'description' => 'Allows users to view academic records and performance'
            ],
            'view-student-finance' => [
                'display_name' => 'View Student Finance',
                'description' => 'Allows users to view financial records and statements'
            ],
            'view-student-subjects' => [
                'display_name' => 'View Student Subjects',
                'description' => 'Allows users to view enrolled subjects and modules'
            ],
            'access-online-learning' => [
                'display_name' => 'Access Online Learning',
                'description' => 'Allows users to access online learning materials and resources'
            ],
            'view-library-management' => [
                'display_name' => 'View Library Management',
                'description' => 'Allows users to access library management features'
            ],
            'view-hostel-management' => [
                'display_name' => 'View Hostel Management',
                'description' => 'Allows users to view hostel management information'
            ],
            'access-marketplace' => [
                'display_name' => 'Access Marketplace',
                'description' => 'Allows users to access the student marketplace'
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
            'view-online-applications',
            'create-online-applications',
            'edit-online-applications',
            'delete-online-applications',
            'approve-online-applications',
            'reject-online-applications',
            'verify-application-documents',
            'download-application-documents',
            'manage-online-submissions',
            'access-student-portal',
            'view-student-profile',
            'view-student-academics',
            'view-student-finance',
            'view-student-subjects',
            'access-online-learning',
            'view-library-management',
            'view-hostel-management',
            'access-marketplace'
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
