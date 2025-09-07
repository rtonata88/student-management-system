# Laravel Migration Deployment Instructions

## CRITICAL: Pre-Deployment Steps

### 1. Backup Your Database
```bash
mysqldump -u your_username -p your_database_name > backup_$(date +%Y%m%d_%H%M%S).sql
```

### 2. Remove Problematic Migration Files
Before running migrations, **DELETE** these duplicate/conflicting migration files from your server:

```bash
# Navigate to migrations directory
cd /path/to/your/project/database/migrations/

# Remove these specific files (they cause class name conflicts):
rm -f 2025_09_07_120000_fix_students_center_id_data.php
rm -f 2025_09_07_140000_fix_examination_schedules_foreign_keys.php
rm -f 2025_09_07_142000_fix_student_promotions_foreign_keys.php
rm -f 2025_09_07_143000_fix_application_subjects_foreign_keys.php
rm -f 2025_09_07_144000_fix_duplicate_usernames.php
rm -f 2025_09_07_145000_fix_student_subjects_foreign_keys.php
rm -f 2025_09_07_151000_fix_all_duplicate_class_names.php

# Remove the separate duplicate column fix migration (now integrated into master):
rm -f 2025_09_07_170000_fix_all_duplicate_column_migrations.php
```

### 3. Upload Master Migration File
Upload **ONLY** this file to your server:
- `2025_09_07_160000_master_migration_cleanup.php`

This single file contains ALL the fixes and is designed to be safe and idempotent.

## Deployment Commands

### 1. Run the Master Migration
```bash
# Navigate to your project root
cd /path/to/your/project/

# Run migrations with the specific PHP version
/opt/cpanel/ea-php81/root/usr/bin/php artisan migrate

# Or if using standard PHP:
php artisan migrate
```

### 2. Verify Migration Success
```bash
# Check migration status
/opt/cpanel/ea-php81/root/usr/bin/php artisan migrate:status

# Check for any remaining issues
/opt/cpanel/ea-php81/root/usr/bin/php artisan migrate --pretend
```

## What the Master Migration Does

### ✅ Data Fixes
- Fixes students without valid `center_id`
- Cleans up invalid `head_invigilator_id` references
- Resolves duplicate usernames by appending counters
- Removes orphaned records that violate foreign key constraints

### ✅ Schema Fixes
- Recreates `student_promotions` table with correct data types
- Recreates `application_subjects` table with proper foreign keys
- Recreates `student_subjects` table with correct constraints
- Creates `marks_suppressions` table if missing
- Adds missing foreign key constraints safely
- Fixes all duplicate column issues across 18+ tables
- Handles all drop column operations safely

### ✅ Safety Features
- Checks if tables/columns exist before creating
- Checks if foreign keys exist before adding
- Idempotent - safe to run multiple times
- Comprehensive data cleanup before adding constraints
- No Doctrine DBAL package requirements
- Exception handling for foreign key constraints

## Post-Deployment Verification

### 1. Test Key Functionality
- Try accessing student records
- Test examination schedule creation
- Verify user login functionality
- Check subject allocation features

### 2. Monitor Error Logs
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Check web server error logs
tail -f /var/log/apache2/error.log  # or nginx equivalent
```

## Future Migration Best Practices

Use the provided `MigrationTemplate.php.example` for all future migrations. It includes:
- Proper existence checks
- Data cleanup before constraints
- Correct data type matching
- Idempotent design
- Error handling

## Rollback Plan (Emergency Only)

If something goes wrong:

1. **Restore from backup:**
```bash
mysql -u your_username -p your_database_name < backup_YYYYMMDD_HHMMSS.sql
```

2. **Reset migration table:**
```bash
/opt/cpanel/ea-php81/root/usr/bin/php artisan migrate:reset
/opt/cpanel/ea-php81/root/usr/bin/php artisan migrate
```

## Support

If you encounter issues:
1. Check the Laravel log file: `storage/logs/laravel.log`
2. Verify database connection settings in `.env`
3. Ensure all required tables exist in your database
4. Contact your development team with specific error messages

---

**⚠️ IMPORTANT:** This master migration is designed to permanently resolve all recurring migration issues. After successful deployment, you should not need to run individual fix migrations again.
