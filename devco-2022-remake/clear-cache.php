<?php

/**
 * Clear Laravel Cache via Browser
 * Upload this file to server root and access via browser
 * Then delete this file after use for security
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Clear all caches
$commands = [
    'route:clear',
    'config:clear',
    'cache:clear',
    'view:clear',
    'optimize:clear'
];

echo '<pre>';
echo "=== Laravel Cache Cleaner ===\n\n";

foreach ($commands as $command) {
    echo "Running: php artisan {$command}\n";
    $kernel->call($command);
    echo "✓ Done\n\n";
}

// Optionally rebuild cache for production
echo "=== Rebuilding Cache for Production ===\n\n";
$rebuildCommands = [
    'config:cache',
    'route:cache',
    'view:cache'
];

foreach ($rebuildCommands as $command) {
    echo "Running: php artisan {$command}\n";
    try {
        $kernel->call($command);
        echo "✓ Done\n\n";
    } catch (Exception $e) {
        echo "✗ Error: " . $e->getMessage() . "\n\n";
    }
}

echo "=== All Done! ===\n";
echo "⚠️ IMPORTANT: Delete this file (clear-cache.php) now for security!\n";
echo '</pre>';
