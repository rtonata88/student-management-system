<?php

use Illuminate\Database\Seeder;
use App\VehicleCategory;

class VehicleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Buses',
                'description' => 'Large passenger vehicles for student transportation',
                'active' => true
            ],
            [
                'name' => 'Minibuses',
                'description' => 'Medium-sized passenger vehicles for smaller groups',
                'active' => true
            ],
            [
                'name' => 'Vans',
                'description' => 'Small passenger or cargo vehicles',
                'active' => true
            ],
            [
                'name' => 'Cars',
                'description' => 'Personal vehicles for staff and administrative use',
                'active' => true
            ],
            [
                'name' => 'Trucks',
                'description' => 'Heavy vehicles for cargo and equipment transport',
                'active' => true
            ],
            [
                'name' => 'Motorcycles',
                'description' => 'Two-wheeled vehicles for quick transportation',
                'active' => true
            ],
            [
                'name' => 'Emergency Vehicles',
                'description' => 'Ambulances and emergency response vehicles',
                'active' => true
            ]
        ];

        foreach ($categories as $category) {
            VehicleCategory::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
