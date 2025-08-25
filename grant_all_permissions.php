<?php

/**
 * Script to run all permission migrations and ensure all permissions exist in database
 * This script is safe to run multiple times as all migrations have existence checks
 */

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=================================================================\n";
echo "RUNNING ALL PERMISSION MIGRATIONS\n";
echo "=================================================================\n\n";

// List of all permission migration files in chronological order
$permissionMigrations = [
    '2025_08_20_150200_create_inventory_permissions',
    '2025_08_20_155547_create_fixed_assets_permissions', 
    '2025_08_20_212500_create_manual_admission_permissions',
    '2025_08_20_213500_create_hr_employee_permissions',
    '2025_08_20_220000_create_fleet_management_permissions',
    '2025_08_20_220600_create_hostel_management_permissions',
    '2025_08_20_225300_create_additional_report_permissions',
    '2025_08_21_134200_create_examination_permissions',
    '2025_08_21_140200_create_result_codes_permissions',
    '2025_08_21_141900_create_grading_scales_permissions',
    '2025_08_21_152100_create_promotional_statuses_permissions',
    '2025_08_21_160800_create_module_allocation_permissions',
    '2025_08_21_162800_create_my_modules_permissions',
    '2025_08_21_192500_create_class_routine_permissions',
    '2025_08_21_212000_create_comprehensive_report_permissions',
    '2025_08_22_120000_create_student_card_permissions',
    '2025_08_22_144000_create_venue_and_time_slot_permissions',
    '2025_08_22_151000_create_student_letters_permissions',
    '2024_01_16_100000_create_examination_schedule_permissions'
];

$successCount = 0;
$errorCount = 0;

foreach ($permissionMigrations as $migration) {
    echo "Running migration: {$migration}\n";
    
    try {
        // Run the specific migration
        $exitCode = Artisan::call('migrate', [
            '--path' => "database/migrations/{$migration}.php",
            '--force' => true
        ]);
        
        if ($exitCode === 0) {
            echo "✅ SUCCESS: {$migration}\n";
            $successCount++;
        } else {
            echo "❌ FAILED: {$migration} (Exit code: {$exitCode})\n";
            $errorCount++;
        }
    } catch (Exception $e) {
        echo "❌ ERROR: {$migration} - " . $e->getMessage() . "\n";
        $errorCount++;
    }
    
    echo "\n";
}

echo "=================================================================\n";
echo "MIGRATION SUMMARY\n";
echo "=================================================================\n";
echo "✅ Successful: {$successCount}\n";
echo "❌ Failed: {$errorCount}\n";
echo "📊 Total: " . count($permissionMigrations) . "\n\n";

// Add the missing student-cards permission if it doesn't exist
echo "Checking for missing base permissions...\n";

try {
    $permission = \App\Permission::where('name', 'student-cards')->first();
    if (!$permission) {
        \App\Permission::create([
            'name' => 'student-cards',
            'display_name' => 'Student Cards',
            'description' => 'Permission to access student cards module'
        ]);
        echo "✅ Added missing 'student-cards' permission\n";
    } else {
        echo "✅ 'student-cards' permission already exists\n";
    }
} catch (Exception $e) {
    echo "❌ Error checking student-cards permission: " . $e->getMessage() . "\n";
}

echo "\n=================================================================\n";
echo "PERMISSION COUNT CHECK\n";
echo "=================================================================\n";

try {
    $totalPermissions = \App\Permission::count();
    echo "📊 Total permissions in database: {$totalPermissions}\n";
    
    if ($totalPermissions >= 328) {
        echo "✅ Permission count looks good!\n";
    } else {
        echo "⚠️  Expected at least 328 permissions, found {$totalPermissions}\n";
    }
} catch (Exception $e) {
    echo "❌ Error counting permissions: " . $e->getMessage() . "\n";
}

echo "\n=================================================================\n";
echo "SCRIPT COMPLETED\n";
echo "=================================================================\n";

if ($errorCount === 0) {
    echo "🎉 All permission migrations completed successfully!\n";
    echo "Users can now be assigned permissions through Users/Edit interface.\n";
} else {
    echo "⚠️  Some migrations failed. Check the errors above.\n";
    echo "You may need to run failed migrations manually.\n";
}

echo "\nTo run this script: php grant_all_permissions.php\n";
