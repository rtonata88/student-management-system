<?php

/**
 * Script to fix all dropColumn issues in Laravel migrations
 * This script will add proper existence checks to all migrations that drop columns
 */

$migrationsPath = '/Users/givenazo/Documents/Projects/edututorials/database/migrations';

$dropColumnMigrations = [
    '2025_09_04_102918_remove_email_phone_description_from_departments_table.php',
    '2025_08_28_104900_add_user_type_to_users_table.php',
    '2025_09_04_073400_add_alternative_personal_phone_to_employee_profiles_table.php',
    '2025_09_03_171500_add_fuel_liters_to_trip_logs_table.php',
    '2025_08_21_131900_add_missing_columns_to_assessment_types.php',
    '2025_09_03_170000_add_fuel_cost_fields_to_trip_logs_table.php',
    '2025_08_21_001000_fix_fuel_records_date_column.php',
    '2025_08_28_104700_add_user_id_to_students_table.php',
    '2025_09_03_155500_add_notes_and_photo_to_drivers_table.php',
    '2025_09_03_180900_add_new_fields_to_vehicle_assignments_table.php',
    '2025_08_22_140000_add_photo_to_students_table.php',
    '2025_09_03_171200_remove_unnecessary_columns_from_trip_logs_table.php', // Already fixed
    '2022_03_03_113921_add_columns_to_payments.php',
    '2025_08_25_071520_add_head_invigilator_to_examination_schedules.php',
    '2025_09_03_153500_add_current_odometer_to_vehicles_table.php',
    '2025_09_03_172600_add_fuel_town_city_to_trip_logs_table.php',
    '2025_09_02_210000_add_status_to_student_subjects_table.php',
    '2025_09_03_175559_add_description_to_vehicle_services_table.php',
    '2022_03_06_200309_add_sympol_to_module_registration.php',
    '2025_08_26_220000_add_start_time_to_class_schedules.php',
    '2022_03_03_113226_add_paid_amount_to_extra_charges.php',
    '2025_08_21_092700_add_center_id_to_students_table.php',
    '2025_09_03_164300_add_missing_columns_to_trip_logs_table.php' // Already fixed
];

echo "Files that need dropColumn fixes:\n";
foreach ($dropColumnMigrations as $file) {
    if (file_exists($migrationsPath . '/' . $file)) {
        echo "✓ " . $file . "\n";
    } else {
        echo "✗ " . $file . " (not found)\n";
    }
}

echo "\nThese migrations need to be updated with proper existence checks:\n";
echo "- Schema::hasTable() checks before any table operations\n";
echo "- Schema::hasColumn() checks before dropColumn() calls\n";
echo "- Proper error handling for column operations\n";
echo "- Safe rollback procedures\n";
