-- Comprehensive Fix for MySQL Definer Issues
-- Run these commands in your MySQL database

-- Step 1: Find ALL views with the problematic definer
SELECT 
    TABLE_SCHEMA as database_name,
    TABLE_NAME as view_name,
    DEFINER,
    VIEW_DEFINITION
FROM information_schema.VIEWS 
WHERE DEFINER LIKE '%edutcimso%';

-- Step 2: Grant SUPER privilege to current user (needed to change definers)
-- Replace 'your_current_user' with your actual MySQL username
-- GRANT SUPER ON *.* TO 'your_current_user'@'localhost';

-- Step 3: Alternative approach - Set sql_mode to ignore definer issues temporarily
SET SESSION sql_mode = '';
SET GLOBAL sql_mode = '';

-- Step 4: If you want to fix individual views, use this pattern:
-- For each view found in Step 1, run:
-- DROP VIEW IF EXISTS view_name;
-- CREATE VIEW view_name AS (paste the VIEW_DEFINITION from Step 1);

-- Step 5: Quick fix - Create missing user with all privileges
CREATE USER IF NOT EXISTS 'edutcimso'@'localhost' IDENTIFIED BY 'password123';
GRANT ALL PRIVILEGES ON *.* TO 'edutcimso'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;

-- Step 6: Alternative - Update MySQL to ignore definer checks (use with caution)
-- SET GLOBAL log_bin_trust_function_creators = 1;
