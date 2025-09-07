<?php

/**
 * Migration Fixer Script
 * Adds existence checks to ALL migration files to prevent "table already exists" errors
 */

$migrationsDir = __DIR__ . '/database/migrations';
$files = glob($migrationsDir . '/*.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    $modified = false;
    
    // Fix Schema::create calls
    if (preg_match('/Schema::create\s*\(\s*[\'"]([^\'"]+)[\'"]\s*,/', $content, $matches)) {
        $tableName = $matches[1];
        
        // Check if already has existence check
        if (!strpos($content, "Schema::hasTable('$tableName')") && !strpos($content, 'Schema::hasTable("' . $tableName . '")')) {
            $pattern = '/(Schema::create\s*\(\s*[\'"]' . preg_quote($tableName, '/') . '[\'"]\s*,)/';
            $replacement = "if (!Schema::hasTable('$tableName')) {\n            $1";
            $content = preg_replace($pattern, $replacement, $content);
            
            // Add closing brace
            $pattern = '/(\s+}\);)(\s+})/';
            $replacement = '$1' . "\n        }$2";
            $content = preg_replace($pattern, $replacement, $content);
            
            $modified = true;
        }
    }
    
    // Fix Schema::table calls for adding columns
    if (preg_match_all('/Schema::table\s*\(\s*[\'"]([^\'"]+)[\'"]\s*,\s*function\s*\([^)]*\)\s*{\s*([^}]+)/', $content, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            $tableName = $match[1];
            $tableContent = $match[2];
            
            // Extract column additions
            if (preg_match_all('/\$table->([a-zA-Z]+)\s*\(\s*[\'"]([^\'"]+)[\'"]/', $tableContent, $columnMatches, PREG_SET_ORDER)) {
                foreach ($columnMatches as $columnMatch) {
                    $columnName = $columnMatch[2];
                    
                    // Check if already has column existence check
                    if (!strpos($content, "Schema::hasColumn('$tableName', '$columnName')")) {
                        $pattern = '/(Schema::table\s*\(\s*[\'"]\s*' . preg_quote($tableName, '/') . '\s*[\'"]\s*,\s*function\s*\([^)]*\)\s*{)/';
                        $replacement = "if (Schema::hasTable('$tableName') && !Schema::hasColumn('$tableName', '$columnName')) {\n            $1";
                        $content = preg_replace($pattern, $replacement, $content, 1);
                        
                        // Add closing brace
                        $pattern = '/(\s+}\);)/';
                        $replacement = '$1' . "\n        }";
                        $content = preg_replace($pattern, $replacement, $content, 1);
                        
                        $modified = true;
                        break; // Only fix first occurrence per table
                    }
                }
            }
        }
    }
    
    if ($modified) {
        file_put_contents($file, $content);
        echo "Fixed: " . basename($file) . "\n";
    }
}

echo "Migration fixing complete!\n";
