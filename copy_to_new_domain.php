<?php
// Script to copy files from htdocs to sistemhitung.gt.tc/htdocs
set_time_limit(300);
error_reporting(E_ALL);
ini_set('display_errors', 1);

$source = '/home/vol19_2/infinityfree.com/if0_41597355/htdocs';
$dest = '/home/vol19_2/infinityfree.com/if0_41597355/sistemhitung.gt.tc/htdocs';

$skipDirs = ['.', '..', 'node_modules', '.git'];
$count = 0;
$errors = [];

function recurseCopy($src, $dst, $skipDirs, &$count, &$errors) {
    $dir = @opendir($src);
    if (!$dir) {
        $errors[] = "Cannot open: $src";
        return;
    }
    if (!file_exists($dst)) {
        @mkdir($dst, 0755, true);
    }
    while (($file = readdir($dir)) !== false) {
        if (in_array($file, $skipDirs)) continue;
        
        $srcPath = $src . '/' . $file;
        $dstPath = $dst . '/' . $file;
        
        if (is_dir($srcPath)) {
            recurseCopy($srcPath, $dstPath, $skipDirs, $count, $errors);
        } else {
            if (@copy($srcPath, $dstPath)) {
                $count++;
            } else {
                $errors[] = "Failed to copy: $srcPath";
            }
        }
    }
    closedir($dir);
}

echo "<h2>Copying files...</h2>";
echo "<p>From: $source</p>";
echo "<p>To: $dest</p>";
flush();

recurseCopy($source, $dest, $skipDirs, $count, $errors);

echo "<h2>Done!</h2>";
echo "<p>Files copied: $count</p>";

if (!empty($errors)) {
    echo "<h3>Errors (" . count($errors) . "):</h3>";
    echo "<ul>";
    foreach (array_slice($errors, 0, 20) as $err) {
        echo "<li>$err</li>";
    }
    echo "</ul>";
}

// Now delete this script for security
echo "<p>Cleaning up copy script...</p>";
@unlink(__FILE__);
echo "<p><strong>Copy script removed. All done!</strong></p>";
?>
