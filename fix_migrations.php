<?php

/**
 * Script to fix all Laravel migrations to include proper table/column existence checks
 * This prevents "table already exists" errors when running migrations
 */

$migrationsPath = __DIR__ . '/database/migrations/';
$files = glob($migrationsPath . '*.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    $originalContent = $content;
    
    // Skip if already has Schema::hasTable check
    if (strpos($content, 'Schema::hasTable') !== false) {
        echo "Skipping " . basename($file) . " - already has table checks\n";
        continue;
    }
    
    // Fix Schema::create patterns
    $pattern = '/(\s+)(Schema::create\([\'"]([^\'"]+)[\'"],\s*function\s*\(Blueprint\s*\$table\)\s*\{)/';
    $replacement = '$1if (!Schema::hasTable(\'$3\')) {' . "\n" . '$1    $2';
    $content = preg_replace($pattern, $replacement, $content);
    
    // Fix closing braces for Schema::create
    $pattern = '/(\s+)(\});\s*\n(\s+)\}/';
    $replacement = '$1    $2;' . "\n" . '$1}' . "\n" . '$3}';
    $content = preg_replace($pattern, $replacement, $content);
    
    // Fix Schema::table patterns for adding columns
    $pattern = '/(\s+)(Schema::table\([\'"]([^\'"]+)[\'"],\s*function\s*\(Blueprint\s*\$table\)\s*\{)/';
    $content = preg_replace_callback($pattern, function($matches) {
        $tableName = $matches[3];
        return $matches[1] . 'if (Schema::hasTable(\'' . $tableName . '\')) {' . "\n" . 
               $matches[1] . '    ' . $matches[2];
    }, $content);
    
    // Add column existence checks for Schema::table operations
    $content = preg_replace('/(\$table->[a-zA-Z]+\([^)]*\)->([a-zA-Z()]+);)/', 
        'if (!Schema::hasColumn(\'' . '$tableName' . '\', \'column_name\')) { $1 }', $content);
    
    if ($content !== $originalContent) {
        file_put_contents($file, $content);
        echo "Fixed " . basename($file) . "\n";
    } else {
        echo "No changes needed for " . basename($file) . "\n";
    }
}

echo "Migration fixes completed!\n";
