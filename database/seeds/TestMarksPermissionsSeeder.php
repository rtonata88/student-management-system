<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class TestMarksPermissionsSeeder extends Seeder
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
                'name' => 'test-marks',
                'display_name' => 'View Test Marks',
                'description' => 'Can view test marks module list',
                'guard_name' => 'web'
            ],
            [
                'name' => 'capture-test-marks',
                'display_name' => 'Capture Test Marks',
                'description' => 'Can capture and edit student test marks',
                'guard_name' => 'web'
            ],
            [
                'name' => 'view-all-test-marks',
                'display_name' => 'View All Test Marks',
                'description' => 'Can view comprehensive test marks with CA calculations',
                'guard_name' => 'web'
            ],
            [
                'name' => 'delete-test-marks',
                'display_name' => 'Delete Test Marks',
                'description' => 'Can delete individual test marks',
                'guard_name' => 'web'
            ]
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}
