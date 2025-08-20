<?php

use Illuminate\Database\Seeder;
use App\Models\FixedAssetCategory;
use App\Models\FixedAsset;
use App\Models\FixedAssetMaintenance;

class FixedAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Fixed Asset Categories
        $categories = [
            [
                'name' => 'Computer Equipment',
                'description' => 'Desktop computers, laptops, tablets, and related hardware',
                'color' => '#007bff',
                'depreciation_rate' => 20.00,
                'useful_life_years' => 5,
                'active' => true
            ],
            [
                'name' => 'Furniture',
                'description' => 'Desks, chairs, cabinets, and classroom furniture',
                'color' => '#28a745',
                'depreciation_rate' => 10.00,
                'useful_life_years' => 10,
                'active' => true
            ],
            [
                'name' => 'Audio Visual Equipment',
                'description' => 'Projectors, screens, speakers, and presentation equipment',
                'color' => '#ffc107',
                'depreciation_rate' => 15.00,
                'useful_life_years' => 7,
                'active' => true
            ],
            [
                'name' => 'Laboratory Equipment',
                'description' => 'Scientific instruments, microscopes, and lab apparatus',
                'color' => '#dc3545',
                'depreciation_rate' => 12.00,
                'useful_life_years' => 8,
                'active' => true
            ],
            [
                'name' => 'Vehicles',
                'description' => 'School buses, maintenance vehicles, and transportation',
                'color' => '#6f42c1',
                'depreciation_rate' => 18.00,
                'useful_life_years' => 6,
                'active' => true
            ]
        ];

        foreach ($categories as $categoryData) {
            $category = FixedAssetCategory::create($categoryData);

            // Create sample assets for each category
            $this->createSampleAssets($category);
        }
    }

    private function createSampleAssets($category)
    {
        $assetsByCategory = [
            'Computer Equipment' => [
                [
                    'asset_tag' => 'COMP-001',
                    'name' => 'Dell OptiPlex 7090',
                    'description' => 'Desktop computer for administrative office',
                    'brand' => 'Dell',
                    'model' => 'OptiPlex 7090',
                    'serial_number' => 'DL7090001',
                    'purchase_cost' => 1200.00,
                    'purchase_date' => '2023-01-15',
                    'current_value' => 960.00,
                    'supplier' => 'Dell Technologies',
                    'warranty_start_date' => '2023-01-15',
                    'warranty_end_date' => '2026-01-15',
                    'warranty_details' => '3-year comprehensive warranty with on-site support',
                    'location' => 'Main Office',
                    'department' => 'Administration',
                    'assigned_to' => 'John Smith',
                    'condition' => 'excellent',
                    'status' => 'active'
                ],
                [
                    'asset_tag' => 'COMP-002',
                    'name' => 'MacBook Pro 13"',
                    'description' => 'Laptop for teaching staff',
                    'brand' => 'Apple',
                    'model' => 'MacBook Pro 13" M2',
                    'serial_number' => 'MBP13001',
                    'purchase_cost' => 1800.00,
                    'purchase_date' => '2023-03-10',
                    'current_value' => 1440.00,
                    'supplier' => 'Apple Store',
                    'warranty_start_date' => '2023-03-10',
                    'warranty_end_date' => '2024-03-10',
                    'warranty_details' => '1-year limited warranty',
                    'location' => 'Faculty Room',
                    'department' => 'Teaching',
                    'assigned_to' => 'Sarah Johnson',
                    'condition' => 'good',
                    'status' => 'active'
                ]
            ],
            'Furniture' => [
                [
                    'asset_tag' => 'FURN-001',
                    'name' => 'Executive Office Desk',
                    'description' => 'Large wooden desk for principal office',
                    'brand' => 'Steelcase',
                    'model' => 'Series 7',
                    'purchase_cost' => 800.00,
                    'purchase_date' => '2022-08-20',
                    'current_value' => 720.00,
                    'supplier' => 'Office Furniture Plus',
                    'location' => 'Principal Office',
                    'department' => 'Administration',
                    'condition' => 'good',
                    'status' => 'active'
                ]
            ],
            'Audio Visual Equipment' => [
                [
                    'asset_tag' => 'AV-001',
                    'name' => 'Epson PowerLite Projector',
                    'description' => 'Classroom projector for presentations',
                    'brand' => 'Epson',
                    'model' => 'PowerLite 2247U',
                    'serial_number' => 'EP2247001',
                    'purchase_cost' => 1500.00,
                    'purchase_date' => '2023-06-01',
                    'current_value' => 1275.00,
                    'supplier' => 'AV Solutions Inc',
                    'warranty_start_date' => '2023-06-01',
                    'warranty_end_date' => '2025-06-01',
                    'warranty_details' => '2-year manufacturer warranty',
                    'location' => 'Classroom A-101',
                    'department' => 'Teaching',
                    'condition' => 'excellent',
                    'status' => 'active',
                    'last_maintenance_date' => '2024-01-15',
                    'next_maintenance_date' => '2024-07-15'
                ]
            ],
            'Laboratory Equipment' => [
                [
                    'asset_tag' => 'LAB-001',
                    'name' => 'Digital Microscope',
                    'description' => 'High-resolution microscope for biology lab',
                    'brand' => 'Olympus',
                    'model' => 'CX23',
                    'serial_number' => 'OLY-CX23-001',
                    'purchase_cost' => 2500.00,
                    'purchase_date' => '2022-09-15',
                    'current_value' => 2200.00,
                    'supplier' => 'Scientific Equipment Co',
                    'warranty_start_date' => '2022-09-15',
                    'warranty_end_date' => '2023-09-15',
                    'warranty_details' => '1-year warranty on parts and labor',
                    'location' => 'Biology Lab',
                    'department' => 'Science',
                    'condition' => 'good',
                    'status' => 'active',
                    'last_maintenance_date' => '2023-12-10',
                    'next_maintenance_date' => '2024-06-10'
                ]
            ],
            'Vehicles' => [
                [
                    'asset_tag' => 'VEH-001',
                    'name' => 'School Bus #1',
                    'description' => '72-passenger school bus',
                    'brand' => 'Blue Bird',
                    'model' => 'Vision',
                    'serial_number' => 'BB-VIS-001',
                    'purchase_cost' => 85000.00,
                    'purchase_date' => '2021-07-01',
                    'current_value' => 69700.00,
                    'supplier' => 'Blue Bird Corporation',
                    'warranty_start_date' => '2021-07-01',
                    'warranty_end_date' => '2022-07-01',
                    'warranty_details' => '1-year comprehensive warranty',
                    'location' => 'Transportation Depot',
                    'department' => 'Transportation',
                    'assigned_to' => 'Mike Wilson',
                    'condition' => 'good',
                    'status' => 'active',
                    'last_maintenance_date' => '2024-01-20',
                    'next_maintenance_date' => '2024-04-20'
                ]
            ]
        ];

        if (isset($assetsByCategory[$category->name])) {
            foreach ($assetsByCategory[$category->name] as $assetData) {
                $assetData['category_id'] = $category->id;
                $asset = FixedAsset::create($assetData);

                // Create sample maintenance records for some assets
                if (in_array($category->name, ['Audio Visual Equipment', 'Laboratory Equipment', 'Vehicles'])) {
                    $this->createSampleMaintenance($asset);
                }
            }
        }
    }

    private function createSampleMaintenance($asset)
    {
        $maintenanceRecords = [
            [
                'asset_id' => $asset->id,
                'type' => 'preventive',
                'date' => $asset->last_maintenance_date ?: '2024-01-15',
                'performed_by' => 'Maintenance Team',
                'service_provider' => 'Internal',
                'description' => 'Regular preventive maintenance and inspection',
                'cost' => 150.00,
                'status' => 'completed',
                'next_due_date' => $asset->next_maintenance_date ?: '2024-07-15',
                'notes' => 'All systems functioning normally. No issues found.',
                'parts_replaced' => json_encode(['filters' => 'air filter'])
            ]
        ];

        foreach ($maintenanceRecords as $maintenanceData) {
            FixedAssetMaintenance::create($maintenanceData);
        }
    }
}
