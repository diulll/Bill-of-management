<?php
set_time_limit(300);
echo "<h2>Cleaning up incorrectly extracted files...</h2>";

$dir = __DIR__;
$count = 0;
$kept = ['setup.php', '.env', '.htaccess'];

$files = scandir($dir);
foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    if (in_array($file, $kept)) continue;
    
    $path = $dir . '/' . $file;
    
    // Delete files with backslashes in name (incorrectly extracted)
    if (strpos($file, '\\') !== false) {
        @unlink($path);
        $count++;
    }
}

echo "<p>Deleted $count incorrectly extracted files.</p>";

// Also list remaining files
echo "<h3>Remaining files:</h3><ul>";
$remaining = scandir($dir);
foreach ($remaining as $f) {
    if ($f === '.' || $f === '..') continue;
    echo "<li>$f</li>";
}
echo "</ul>";

echo "<h2 style='color:green'>Cleanup done!</h2>";
@unlink(__FILE__);
?>
