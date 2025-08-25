<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class UpdateExamPermitsPermissionsDisplayNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            'view-exam-permits' => [
                'display_name' => 'View Exam Permits',
                'description' => 'Access to exam permits menu and search interface'
            ],
            'search-exam-permits' => [
                'display_name' => 'Search Exam Permits',
                'description' => 'Search for students to generate exam permits'
            ],
            'generate-exam-permits' => [
                'display_name' => 'Generate Exam Permits',
                'description' => 'Generate and view exam permits for students'
            ],
            'download-exam-permits' => [
                'display_name' => 'Download Exam Permits',
                'description' => 'Download exam permits as PDF documents'
            ],
            'print-exam-permits' => [
                'display_name' => 'Print Exam Permits',
                'description' => 'Print exam permits in print-friendly format'
            ],
            'manage-exam-permits' => [
                'display_name' => 'Manage Exam Permits',
                'description' => 'Administrative management of exam permits system'
            ]
        ];

        foreach ($permissions as $name => $data) {
            Permission::where('name', $name)->update([
                'display_name' => $data['display_name'],
                'description' => $data['description']
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
        $permissions = [
            'view-exam-permits',
            'search-exam-permits',
            'generate-exam-permits',
            'download-exam-permits',
            'print-exam-permits',
            'manage-exam-permits'
        ];

        foreach ($permissions as $name) {
            Permission::where('name', $name)->update([
                'display_name' => null,
                'description' => null
            ]);
        }
    }
}
