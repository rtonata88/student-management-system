<?php

use Illuminate\Database\Seeder;
use App\Models\MaintenanceCategory;
use App\Models\MaintenanceRequest;
use App\User;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create maintenance categories
        $categories = [
            [
                'name' => 'Electrical',
                'description' => 'Electrical repairs and maintenance',
                'color' => '#ffc107',
                'priority_level' => 'high',
                'expected_completion_hours' => 4,
                'requires_approval' => true,
                'active' => true
            ],
            [
                'name' => 'Plumbing',
                'description' => 'Water and plumbing related issues',
                'color' => '#007bff',
                'priority_level' => 'medium',
                'expected_completion_hours' => 3,
                'requires_approval' => true,
                'active' => true
            ],
            [
                'name' => 'HVAC',
                'description' => 'Heating, ventilation, and air conditioning',
                'color' => '#28a745',
                'priority_level' => 'medium',
                'expected_completion_hours' => 6,
                'requires_approval' => true,
                'active' => true
            ],
            [
                'name' => 'Carpentry',
                'description' => 'Wood work and furniture repairs',
                'color' => '#dc3545',
                'priority_level' => 'low',
                'expected_completion_hours' => 2,
                'requires_approval' => false,
                'active' => true
            ],
            [
                'name' => 'Painting',
                'description' => 'Interior and exterior painting',
                'color' => '#6f42c1',
                'priority_level' => 'low',
                'expected_completion_hours' => 8,
                'requires_approval' => false,
                'active' => true
            ],
            [
                'name' => 'Cleaning',
                'description' => 'Deep cleaning and sanitation',
                'color' => '#17a2b8',
                'priority_level' => 'low',
                'expected_completion_hours' => 2,
                'requires_approval' => false,
                'active' => true
            ],
            [
                'name' => 'Security',
                'description' => 'Security systems and access control',
                'color' => '#fd7e14',
                'priority_level' => 'critical',
                'expected_completion_hours' => 4,
                'requires_approval' => true,
                'active' => true
            ]
        ];

        foreach ($categories as $category) {
            MaintenanceCategory::create($category);
        }

        // Get the first user to assign requests to
        $user = User::first();
        
        if ($user) {
            // Create sample maintenance requests
            $requests = [
                [
                    'category_id' => 1, // Electrical
                    'requested_by' => $user->id,
                    'title' => 'Classroom 101 Light Fixture Repair',
                    'description' => 'The fluorescent light fixture in classroom 101 is flickering and needs replacement.',
                    'location' => 'Main Building - Classroom 101',
                    'priority' => 'medium',
                    'status' => 'pending',
                    'requested_date' => now()->subDays(2)->toDateString(),
                    'required_completion_date' => now()->addDays(3)->toDateString(),
                    'estimated_cost' => 150.00,
                    'notes' => 'Students have reported difficulty seeing the board due to flickering lights.'
                ],
                [
                    'category_id' => 2, // Plumbing
                    'requested_by' => $user->id,
                    'title' => 'Library Restroom Sink Leak',
                    'description' => 'The sink in the library restroom has a persistent leak that needs immediate attention.',
                    'location' => 'Library Building - Ground Floor Restroom',
                    'priority' => 'high',
                    'status' => 'approved',
                    'requested_date' => now()->subDays(1)->toDateString(),
                    'required_completion_date' => now()->addDays(1)->toDateString(),
                    'estimated_cost' => 75.00,
                    'approved_by' => $user->id,
                    'approved_at' => now()->subHours(6),
                    'notes' => 'Water damage to floor tiles if not fixed soon.'
                ],
                [
                    'category_id' => 3, // HVAC
                    'requested_by' => $user->id,
                    'title' => 'Computer Lab Air Conditioning',
                    'description' => 'The air conditioning unit in the computer lab is not cooling properly.',
                    'location' => 'Technology Building - Computer Lab 2',
                    'priority' => 'high',
                    'status' => 'in_progress',
                    'requested_date' => now()->subDays(3)->toDateString(),
                    'required_completion_date' => now()->addDays(2)->toDateString(),
                    'estimated_cost' => 300.00,
                    'approved_by' => $user->id,
                    'approved_at' => now()->subDays(1),
                    'notes' => 'Equipment overheating concerns in summer weather.'
                ],
                [
                    'category_id' => 4, // Carpentry
                    'requested_by' => $user->id,
                    'title' => 'Cafeteria Table Repair',
                    'description' => 'Several cafeteria tables have loose legs and need reinforcement.',
                    'location' => 'Student Center - Cafeteria',
                    'priority' => 'low',
                    'status' => 'completed',
                    'requested_date' => now()->subDays(7)->toDateString(),
                    'required_completion_date' => now()->subDays(2)->toDateString(),
                    'estimated_cost' => 120.00,
                    'approved_by' => $user->id,
                    'approved_at' => now()->subDays(5),
                    'notes' => 'Safety concern for students during meal times.'
                ],
                [
                    'category_id' => 5, // Painting
                    'requested_by' => $user->id,
                    'title' => 'Hallway Wall Touch-up',
                    'description' => 'The hallway walls on the second floor need touch-up painting due to scuff marks.',
                    'location' => 'Main Building - Second Floor Hallway',
                    'priority' => 'low',
                    'status' => 'pending',
                    'requested_date' => now()->subDays(1)->toDateString(),
                    'required_completion_date' => now()->addWeeks(2)->toDateString(),
                    'estimated_cost' => 200.00,
                    'notes' => 'Aesthetic improvement for upcoming parent-teacher conferences.'
                ]
            ];

            foreach ($requests as $request) {
                MaintenanceRequest::create($request);
            }
        }
    }
}
