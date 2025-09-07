<?php

/**
 * Script to remove all problematic migration files
 * Run this after creating the comprehensive cleanup migration
 */

$migrationsToRemove = [
    // Problematic migrations that cause errors
    '2025_09_03_153500_add_current_odometer_to_vehicles_table.php',
    '2025_08_28_104700_add_user_id_to_students_table.php',
    '2025_09_03_155500_add_notes_and_photo_to_drivers_table.php',
    '2025_09_03_164300_add_missing_columns_to_trip_logs_table.php',
    '2025_09_03_171200_remove_unnecessary_columns_from_trip_logs_table.php',
    '2025_08_21_092700_add_center_id_to_students_table.php',
    
    // Old fix files
    '2025_09_07_160000_master_migration_cleanup.php',
    '2025_09_07_180000_fix_all_drop_column_migrations.php',
];

$migrationsPath = __DIR__ . '/database/migrations/';
$removedCount = 0;
$notFoundCount = 0;

echo "🗑️  Removing problematic migration files...\n\n";

foreach ($migrationsToRemove as $migration) {
    $filePath = $migrationsPath . $migration;
    
    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            echo "✅ Removed: {$migration}\n";
            $removedCount++;
        } else {
            echo "❌ Failed to remove: {$migration}\n";
        }
    } else {
        echo "⚠️  Not found: {$migration}\n";
        $notFoundCount++;
    }
}

// Also remove root-level fix files
$rootFixFiles = [
    'fix_all_migrations.php',
    'fix_all_duplicate_columns.php',
    'fix_all_drop_column_migrations.php',
];

echo "\n🗑️  Removing root-level fix files...\n\n";

foreach ($rootFixFiles as $file) {
    $filePath = __DIR__ . '/' . $file;
    
    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            echo "✅ Removed: {$file}\n";
            $removedCount++;
        } else {
            echo "❌ Failed to remove: {$file}\n";
        }
    } else {
        echo "⚠️  Not found: {$file}\n";
        $notFoundCount++;
    }
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "📊 Summary:\n";
echo "   ✅ Files removed: {$removedCount}\n";
echo "   ⚠️  Files not found: {$notFoundCount}\n";
echo "\n🎯 Keep only: 2025_09_07_200000_comprehensive_database_cleanup.php\n";
echo "\n🚀 Next steps:\n";
echo "   1. Run: php artisan migrate --path=database/migrations/2025_09_07_200000_comprehensive_database_cleanup.php\n";
echo "   2. Deploy to server\n";
echo "   3. Run same migration command on server\n";
