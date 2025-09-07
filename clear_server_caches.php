<?php

/**
 * Script to clear all Laravel caches on the server
 * Upload this to your server root and run it via web browser or command line
 */

echo "🧹 Clearing Laravel Caches...\n\n";

// Define the path to your Laravel installation
$laravelPath = '/home/educimso/elite.educims.org/student-management-system';
$phpPath = '/opt/cpanel/ea-php81/root/usr/bin/php';

// Commands to run
$commands = [
    'Clear Route Cache' => "$phpPath artisan route:clear",
    'Clear Config Cache' => "$phpPath artisan config:clear", 
    'Clear Application Cache' => "$phpPath artisan cache:clear",
    'Clear View Cache' => "$phpPath artisan view:clear",
    'Clear Compiled Views' => "$phpPath artisan view:clear",
    'Rebuild Route Cache' => "$phpPath artisan route:cache",
    'Rebuild Config Cache' => "$phpPath artisan config:cache",
];

// Change to Laravel directory
chdir($laravelPath);

foreach ($commands as $description => $command) {
    echo "🔄 $description...\n";
    
    $output = [];
    $returnVar = 0;
    
    exec($command . ' 2>&1', $output, $returnVar);
    
    if ($returnVar === 0) {
        echo "✅ Success: $description\n";
    } else {
        echo "❌ Failed: $description\n";
        echo "   Error: " . implode("\n   ", $output) . "\n";
    }
    
    echo "\n";
}

echo "🎉 Cache clearing completed!\n\n";
echo "📝 Next steps:\n";
echo "1. Test the route: /signup\n";
echo "2. Test user password change functionality\n";
echo "3. If routes still don't work, check routes/web.php file exists\n";

?>
