<?php

/**
 * Comprehensive script to fix all Laravel migrations with proper table existence checks
 */

$migrationsPath = __DIR__ . '/database/migrations/';
$files = glob($migrationsPath . '*.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    $originalContent = $content;
    
    // Skip files that already have proper Schema::hasTable checks and no syntax errors
    if (strpos($content, 'if (!Schema::hasTable') !== false && 
        strpos($content, 'Schema::create') !== false) {
        
        // Check if the file has proper closing braces
        $lines = explode("\n", $content);
        $inUpFunction = false;
        $braceCount = 0;
        $needsFix = false;
        
        foreach ($lines as $lineNum => $line) {
            if (strpos($line, 'public function up()') !== false) {
                $inUpFunction = true;
                continue;
            }
            
            if ($inUpFunction) {
                if (strpos($line, 'public function down()') !== false) {
                    if ($braceCount > 0) {
                        $needsFix = true;
                    }
                    break;
                }
                
                $braceCount += substr_count($line, '{') - substr_count($line, '}');
            }
        }
        
        if (!$needsFix) {
            echo "Skipping " . basename($file) . " - already properly formatted\n";
            continue;
        }
    }
    
    // Reset content for complete rewrite
    $lines = explode("\n", $content);
    $newLines = [];
    $inUpFunction = false;
    $inSchemaCreate = false;
    $schemaIndent = '';
    $tableName = '';
    
    foreach ($lines as $lineNum => $line) {
        if (strpos($line, 'public function up()') !== false) {
            $newLines[] = $line;
            $newLines[] = '    {';
            $inUpFunction = true;
            continue;
        }
        
        if ($inUpFunction && strpos($line, 'public function down()') !== false) {
            // Close any open braces before down function
            if ($inSchemaCreate) {
                $newLines[] = $schemaIndent . '    });';
                $newLines[] = '        }';
                $inSchemaCreate = false;
            }
            $newLines[] = '    }';
            $newLines[] = '';
            $newLines[] = '    /**';
            $newLines[] = '     * Reverse the migrations.';
            $newLines[] = '     *';
            $newLines[] = '     * @return void';
            $newLines[] = '     */';
            $inUpFunction = false;
        }
        
        if ($inUpFunction && preg_match('/Schema::create\([\'"]([^\'"]+)[\'"]/', $line, $matches)) {
            $tableName = $matches[1];
            $schemaIndent = str_repeat(' ', strlen($line) - strlen(ltrim($line)));
            
            $newLines[] = $schemaIndent . "if (!Schema::hasTable('{$tableName}')) {";
            $newLines[] = $schemaIndent . '    ' . trim($line);
            $inSchemaCreate = true;
            continue;
        }
        
        if (!$inUpFunction || strpos($line, 'public function') === false) {
            $newLines[] = $line;
        }
    }
    
    $newContent = implode("\n", $newLines);
    
    if ($newContent !== $originalContent) {
        file_put_contents($file, $newContent);
        echo "Fixed " . basename($file) . "\n";
    }
}

echo "All migrations fixed!\n";
