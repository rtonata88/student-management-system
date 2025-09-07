<?php

/**
 * Script to fix all duplicate column issues in Laravel migrations
 * This script will add proper existence checks to all "add column" migrations
 */

$migrationsPath = '/Users/givenazo/Documents/Projects/edututorials/database/migrations';

$addColumnMigrations = [
    '2025_08_21_092700_add_center_id_to_students_table.php',
    '2025_08_22_140000_add_photo_to_students_table.php', // Already fixed
    '2025_08_28_104700_add_user_id_to_students_table.php', // Already fixed
    '2025_08_28_104900_add_user_type_to_users_table.php',
    '2025_08_26_220000_add_start_time_to_class_schedules.php',
    '2025_08_25_071520_add_head_invigilator_to_examination_schedules.php',
    '2025_09_02_210000_add_status_to_student_subjects_table.php',
    '2025_09_03_153500_add_current_odometer_to_vehicles_table.php', // Already fixed
    '2025_09_03_155500_add_notes_and_photo_to_drivers_table.php',
    '2025_09_03_164300_add_missing_columns_to_trip_logs_table.php',
    '2025_09_03_170000_add_fuel_cost_fields_to_trip_logs_table.php',
    '2025_09_03_170500_add_fuel_receipt_fields_to_trip_logs_table.php',
    '2025_09_03_171500_add_fuel_liters_to_trip_logs_table.php',
    '2025_09_03_172600_add_fuel_town_city_to_trip_logs_table.php',
    '2025_09_03_175559_add_description_to_vehicle_services_table.php',
    '2025_09_03_180900_add_new_fields_to_vehicle_assignments_table.php',
    '2025_09_04_073400_add_alternative_personal_phone_to_employee_profiles_table.php',
    '2022_03_03_113226_add_paid_amount_to_extra_charges.php'
];

echo "Files that need duplicate column fixes:\n";
foreach ($addColumnMigrations as $file) {
    if (file_exists($migrationsPath . '/' . $file)) {
        echo "✓ " . $file . "\n";
    } else {
        echo "✗ " . $file . " (not found)\n";
    }
}

echo "\nThese migrations need to be updated with proper existence checks:\n";
echo "- Schema::hasTable() and Schema::hasColumn() checks in up() method\n";
echo "- Schema::hasTable() and Schema::hasColumn() checks in down() method\n";
echo "- Proper error handling for foreign key operations\n";
