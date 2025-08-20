<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateManualAdmissionPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    {
    {
    {
    {
        $permissions = [
            [
                'name' => 'manual-admissions-view',
                'display_name' => 'View Manual Admissions',
                'description' => 'View manual admission records and applications'
            ],
            [
                'name' => 'manual-admissions-create',
                'display_name' => 'Create Manual Admissions',
                'description' => 'Create new manual admission records'
            ],
            [
                'name' => 'manual-admissions-edit',
                'display_name' => 'Edit Manual Admissions',
                'description' => 'Modify existing manual admission records'
            ],
            [
                'name' => 'manual-admissions-delete',
                'display_name' => 'Delete Manual Admissions',
                'description' => 'Remove manual admission records'
            ],
            [
                'name' => 'manual-admissions-approve',
                'display_name' => 'Approve Manual Admissions',
                'description' => 'Approve or reject manual admission applications'
            ],
            [
                'name' => 'manual-admissions-reports',
                'display_name' => 'Manual Admissions Reports',
                'description' => 'Access manual admissions reports and statistics'
            ]
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $permission['name']],
                [
                    'name' => $permission['name'],
                    'display_name' => $permission['display_name'],
                    'description' => $permission['description'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissions = [
            'manual-admissions-view',
            'manual-admissions-create',
            'manual-admissions-edit',
            'manual-admissions-delete',
            'manual-admissions-approve',
            'manual-admissions-reports'
        ];

        DB::table('permissions')->whereIn('name', $permissions)->delete();
    }
}
