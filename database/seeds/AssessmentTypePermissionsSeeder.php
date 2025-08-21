<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AssessmentTypePermissionsSeeder extends Seeder
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
                'name' => 'assessments',
                'display_name' => 'View Assessment Types',
                'description' => 'Can view assessment types list',
                'guard_name' => 'web'
            ],
            [
                'name' => 'add-assessment-types',
                'display_name' => 'Add Assessment Types',
                'description' => 'Can create new assessment types',
                'guard_name' => 'web'
            ],
            [
                'name' => 'edit-assessment-types',
                'display_name' => 'Edit Assessment Types',
                'description' => 'Can edit existing assessment types',
                'guard_name' => 'web'
            ],
            [
                'name' => 'delete-assessment-types',
                'display_name' => 'Delete Assessment Types',
                'description' => 'Can delete assessment types',
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
