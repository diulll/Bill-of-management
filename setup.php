<?php
// Setup storage directories and permissions for Laravel on InfinityFree
$dirs = [
    __DIR__ . '/storage/framework/cache/data',
    __DIR__ . '/storage/framework/sessions',
    __DIR__ . '/storage/framework/views',
    __DIR__ . '/storage/logs',
    __DIR__ . '/bootstrap/cache',
];

echo "<h2>Setting up storage directories...</h2>";
foreach ($dirs as $dir) {
    if (!file_exists($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "<p>Created: $dir</p>";
        } else {
            echo "<p style='color:red'>Failed to create: $dir</p>";
        }
    } else {
        echo "<p>Exists: $dir</p>";
    }
    @chmod($dir, 0755);
}

// Verify .env exists
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    echo "<h3>.env file: OK</h3>";
    // Show APP_URL for verification
    $content = file_get_contents($envFile);
    preg_match('/APP_URL=(.*)/', $content, $matches);
    echo "<p>APP_URL: " . ($matches[1] ?? 'not found') . "</p>";
} else {
    echo "<h3 style='color:red'>.env file: MISSING!</h3>";
}

// Verify .htaccess exists
if (file_exists(__DIR__ . '/.htaccess')) {
    echo "<h3>.htaccess: OK</h3>";
} else {
    echo "<h3 style='color:red'>.htaccess: MISSING!</h3>";
}

echo "<h2 style='color:green'>Setup complete! Try accessing your site now.</h2>";
echo "<p><a href='/'>Go to homepage</a></p>";

@unlink(__FILE__);
echo "<p><em>Setup script removed.</em></p>";
?>
