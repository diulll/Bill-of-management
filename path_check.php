<?php
echo "<h2>Server Path Info</h2>";
echo "<p><b>__DIR__:</b> " . __DIR__ . "</p>";
echo "<p><b>DOCUMENT_ROOT:</b> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><b>getcwd():</b> " . getcwd() . "</p>";

// Try to find the htdocs directory
$current = __DIR__;
$parent = dirname($current);
$grandparent = dirname($parent);

echo "<h3>Directory Structure</h3>";
echo "<p>Current: $current</p>";
echo "<p>Parent: $parent</p>";
echo "<p>Grandparent: $grandparent</p>";

// List grandparent contents
echo "<h3>Contents of parent ($parent):</h3><ul>";
if ($dh = @opendir($parent)) {
    while (($f = readdir($dh)) !== false) {
        echo "<li>$f " . (is_dir("$parent/$f") ? "[DIR]" : "[FILE]") . "</li>";
    }
    closedir($dh);
} else {
    echo "<li>Cannot open</li>";
}
echo "</ul>";

echo "<h3>Contents of grandparent ($grandparent):</h3><ul>";
if ($dh = @opendir($grandparent)) {
    while (($f = readdir($dh)) !== false) {
        echo "<li>$f " . (is_dir("$grandparent/$f") ? "[DIR]" : "[FILE]") . "</li>";
    }
    closedir($dh);
} else {
    echo "<li>Cannot open</li>";
}
echo "</ul>";

// Try the known path
$testPath = '/home/vol19_2/infinityfree.com/if0_41597355';
echo "<h3>Test path ($testPath):</h3><ul>";
if ($dh = @opendir($testPath)) {
    while (($f = readdir($dh)) !== false) {
        echo "<li>$f " . (is_dir("$testPath/$f") ? "[DIR]" : "[FILE]") . "</li>";
    }
    closedir($dh);
} else {
    echo "<li>Cannot open - trying realpath...</li>";
    echo "<li>realpath of __DIR__: " . realpath(__DIR__) . "</li>";
}
echo "</ul>";

@unlink(__FILE__);
echo "<p><em>Script cleaned up.</em></p>";
?>
