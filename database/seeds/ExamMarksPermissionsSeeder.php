<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ExamMarksPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'exam-marks',
                'description' => 'View exam marks module list',
                'guard_name' => 'web'
            ],
            [
                'name' => 'capture-exam-marks',
                'description' => 'Capture and edit exam marks',
                'guard_name' => 'web'
            ],
            [
                'name' => 'view-all-exam-marks',
                'description' => 'View all exam marks and calculations',
                'guard_name' => 'web'
            ],
            [
                'name' => 'delete-exam-marks',
                'description' => 'Delete exam marks',
                'guard_name' => 'web'
            ]
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name'], 'guard_name' => $permission['guard_name']],
                $permission
            );
        }
    }
}
