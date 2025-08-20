<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\InventoryTransaction;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create inventory categories
        $categories = [
            [
                'name' => 'Office Supplies',
                'description' => 'General office supplies and stationery',
                'color' => '#007bff',
                'is_active' => true
            ],
            [
                'name' => 'Cleaning Supplies',
                'description' => 'Cleaning materials and equipment',
                'color' => '#28a745',
                'is_active' => true
            ],
            [
                'name' => 'Educational Materials',
                'description' => 'Books, teaching aids, and educational resources',
                'color' => '#ffc107',
                'is_active' => true
            ],
            [
                'name' => 'Technology Equipment',
                'description' => 'Computers, tablets, and electronic devices',
                'color' => '#6f42c1',
                'is_active' => true
            ],
            [
                'name' => 'Furniture',
                'description' => 'Desks, chairs, and classroom furniture',
                'color' => '#fd7e14',
                'is_active' => true
            ],
            [
                'name' => 'Sports Equipment',
                'description' => 'Physical education and sports materials',
                'color' => '#20c997',
                'is_active' => true
            ],
            [
                'name' => 'Medical Supplies',
                'description' => 'First aid and health-related supplies',
                'color' => '#dc3545',
                'is_active' => true
            ]
        ];

        foreach ($categories as $categoryData) {
            InventoryCategory::create($categoryData);
        }

        // Get created categories
        $officeSupplies = InventoryCategory::where('name', 'Office Supplies')->first();
        $cleaningSupplies = InventoryCategory::where('name', 'Cleaning Supplies')->first();
        $educationalMaterials = InventoryCategory::where('name', 'Educational Materials')->first();
        $technology = InventoryCategory::where('name', 'Technology Equipment')->first();
        $furniture = InventoryCategory::where('name', 'Furniture')->first();
        $sports = InventoryCategory::where('name', 'Sports Equipment')->first();
        $medical = InventoryCategory::where('name', 'Medical Supplies')->first();

        // Create inventory items
        $items = [
            // Office Supplies
            [
                'item_code' => 'OFF001',
                'name' => 'A4 Copy Paper',
                'description' => 'White A4 copy paper, 80gsm',
                'category_id' => $officeSupplies->id,
                'unit_of_measure' => 'reams',
                'unit_cost' => 4.50,
                'quantity_in_stock' => 150,
                'minimum_stock_level' => 20,
                'maximum_stock_level' => 200,
                'supplier' => 'Office Depot',
                'location' => 'Storage Room A',
                'specifications' => json_encode(['size' => 'A4', 'weight' => '80gsm', 'color' => 'white'])
            ],
            [
                'item_code' => 'OFF002',
                'name' => 'Blue Ballpoint Pens',
                'description' => 'Blue ink ballpoint pens, medium tip',
                'category_id' => $officeSupplies->id,
                'unit_of_measure' => 'boxes',
                'unit_cost' => 12.00,
                'quantity_in_stock' => 8,
                'minimum_stock_level' => 10,
                'maximum_stock_level' => 50,
                'supplier' => 'Staples',
                'location' => 'Storage Room A'
            ],
            [
                'item_code' => 'OFF003',
                'name' => 'Whiteboard Markers',
                'description' => 'Assorted color whiteboard markers',
                'category_id' => $officeSupplies->id,
                'unit_of_measure' => 'sets',
                'unit_cost' => 8.75,
                'quantity_in_stock' => 25,
                'minimum_stock_level' => 15,
                'maximum_stock_level' => 40,
                'supplier' => 'Office Depot',
                'location' => 'Storage Room A'
            ],

            // Cleaning Supplies
            [
                'item_code' => 'CLN001',
                'name' => 'All-Purpose Cleaner',
                'description' => 'Multi-surface cleaning spray',
                'category_id' => $cleaningSupplies->id,
                'unit_of_measure' => 'bottles',
                'unit_cost' => 3.25,
                'quantity_in_stock' => 45,
                'minimum_stock_level' => 20,
                'maximum_stock_level' => 60,
                'supplier' => 'Cleaning Solutions Inc',
                'location' => 'Janitor Closet',
                'expiry_date' => now()->addMonths(18)
            ],
            [
                'item_code' => 'CLN002',
                'name' => 'Paper Towels',
                'description' => 'Absorbent paper towels, 2-ply',
                'category_id' => $cleaningSupplies->id,
                'unit_of_measure' => 'rolls',
                'unit_cost' => 1.85,
                'quantity_in_stock' => 80,
                'minimum_stock_level' => 30,
                'maximum_stock_level' => 100,
                'supplier' => 'Cleaning Solutions Inc',
                'location' => 'Janitor Closet'
            ],

            // Educational Materials
            [
                'item_code' => 'EDU001',
                'name' => 'Mathematics Textbook Grade 5',
                'description' => 'Grade 5 mathematics curriculum textbook',
                'category_id' => $educationalMaterials->id,
                'unit_of_measure' => 'books',
                'unit_cost' => 28.50,
                'quantity_in_stock' => 120,
                'minimum_stock_level' => 100,
                'maximum_stock_level' => 150,
                'supplier' => 'Educational Publishers Ltd',
                'location' => 'Library Storage'
            ],
            [
                'item_code' => 'EDU002',
                'name' => 'Science Lab Kit',
                'description' => 'Basic science experiment kit for elementary',
                'category_id' => $educationalMaterials->id,
                'unit_of_measure' => 'kits',
                'unit_cost' => 45.00,
                'quantity_in_stock' => 15,
                'minimum_stock_level' => 10,
                'maximum_stock_level' => 25,
                'supplier' => 'Science Supply Co',
                'location' => 'Science Lab'
            ],

            // Technology Equipment
            [
                'item_code' => 'TECH001',
                'name' => 'Student Tablets',
                'description' => '10-inch Android tablets for student use',
                'category_id' => $technology->id,
                'unit_of_measure' => 'units',
                'unit_cost' => 185.00,
                'quantity_in_stock' => 45,
                'minimum_stock_level' => 40,
                'maximum_stock_level' => 60,
                'supplier' => 'Tech Solutions Ltd',
                'location' => 'IT Storage',
                'specifications' => json_encode(['screen_size' => '10 inch', 'os' => 'Android', 'storage' => '32GB'])
            ],
            [
                'item_code' => 'TECH002',
                'name' => 'Wireless Mouse',
                'description' => 'Optical wireless computer mouse',
                'category_id' => $technology->id,
                'unit_of_measure' => 'units',
                'unit_cost' => 15.75,
                'quantity_in_stock' => 3,
                'minimum_stock_level' => 10,
                'maximum_stock_level' => 30,
                'supplier' => 'Tech Solutions Ltd',
                'location' => 'IT Storage'
            ],

            // Furniture
            [
                'item_code' => 'FURN001',
                'name' => 'Student Desk',
                'description' => 'Adjustable height student desk',
                'category_id' => $furniture->id,
                'unit_of_measure' => 'units',
                'unit_cost' => 125.00,
                'quantity_in_stock' => 25,
                'minimum_stock_level' => 20,
                'maximum_stock_level' => 40,
                'supplier' => 'School Furniture Co',
                'location' => 'Warehouse B'
            ],

            // Sports Equipment
            [
                'item_code' => 'SPORT001',
                'name' => 'Soccer Balls',
                'description' => 'Official size soccer balls',
                'category_id' => $sports->id,
                'unit_of_measure' => 'units',
                'unit_cost' => 22.50,
                'quantity_in_stock' => 18,
                'minimum_stock_level' => 15,
                'maximum_stock_level' => 30,
                'supplier' => 'Sports Equipment Ltd',
                'location' => 'Gym Storage'
            ],

            // Medical Supplies
            [
                'item_code' => 'MED001',
                'name' => 'First Aid Bandages',
                'description' => 'Adhesive bandages, assorted sizes',
                'category_id' => $medical->id,
                'unit_of_measure' => 'boxes',
                'unit_cost' => 8.25,
                'quantity_in_stock' => 12,
                'minimum_stock_level' => 15,
                'maximum_stock_level' => 25,
                'supplier' => 'Medical Supply Co',
                'location' => 'Nurse Office',
                'expiry_date' => now()->addMonths(24)
            ],
            [
                'item_code' => 'MED002',
                'name' => 'Hand Sanitizer',
                'description' => '70% alcohol hand sanitizer gel',
                'category_id' => $medical->id,
                'unit_of_measure' => 'bottles',
                'unit_cost' => 4.50,
                'quantity_in_stock' => 0,
                'minimum_stock_level' => 20,
                'maximum_stock_level' => 50,
                'supplier' => 'Medical Supply Co',
                'location' => 'Nurse Office',
                'expiry_date' => now()->subDays(30) // Expired item
            ]
        ];

        foreach ($items as $itemData) {
            $item = InventoryItem::create($itemData);

            // Create initial stock transaction for items with stock
            if ($item->quantity_in_stock > 0) {
                InventoryTransaction::create([
                    'item_id' => $item->id,
                    'transaction_type' => 'in',
                    'quantity' => $item->quantity_in_stock,
                    'unit_cost' => $item->unit_cost,
                    'total_cost' => $item->quantity_in_stock * $item->unit_cost,
                    'reference_number' => 'INITIAL-' . $item->item_code,
                    'notes' => 'Initial stock entry - system setup',
                    'performed_by' => 'System Administrator',
                    'transaction_date' => now()->subDays(rand(1, 30)),
                    'supplier' => $item->supplier,
                ]);
            }

            // Add some random transactions for demonstration
            if (rand(1, 3) == 1) { // 33% chance of additional transactions
                $transactionCount = rand(1, 3);
                for ($i = 0; $i < $transactionCount; $i++) {
                    $transactionType = rand(1, 2) == 1 ? 'out' : 'in';
                    $quantity = rand(1, min(10, $item->quantity_in_stock));
                    
                    if ($transactionType == 'out' && $item->quantity_in_stock >= $quantity) {
                        InventoryTransaction::create([
                            'item_id' => $item->id,
                            'transaction_type' => 'out',
                            'quantity' => -$quantity,
                            'unit_cost' => $item->unit_cost,
                            'total_cost' => $quantity * $item->unit_cost,
                            'reference_number' => 'OUT-' . now()->format('Ymd') . '-' . rand(1000, 9999),
                            'notes' => 'Issued to department',
                            'performed_by' => 'Inventory Manager',
                            'transaction_date' => now()->subDays(rand(1, 15)),
                            'recipient' => 'Academic Department',
                        ]);
                        
                        // Update item stock
                        $item->decrement('quantity_in_stock', $quantity);
                    }
                }
            }
        }

        $this->command->info('Inventory seeder completed successfully!');
        $this->command->info('Created ' . InventoryCategory::count() . ' categories and ' . InventoryItem::count() . ' items.');
    }
}
