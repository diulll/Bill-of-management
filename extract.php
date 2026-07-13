<?php
set_time_limit(600);
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Extracting project files...</h2>";
flush();

$zipFile = __DIR__ . '/project_upload.zip';
$extractTo = __DIR__;

if (!file_exists($zipFile)) {
    die("<p style='color:red'>Error: project_upload.zip not found!</p>");
}

$zipSize = round(filesize($zipFile) / 1024 / 1024, 2);
echo "<p>Zip file size: {$zipSize} MB</p>";

$zip = new ZipArchive;
$res = $zip->open($zipFile);

if ($res === TRUE) {
    $totalFiles = $zip->numFiles;
    echo "<p>Total files in zip: $totalFiles</p>";
    echo "<p>Extracting...</p>";
    flush();
    
    $zip->extractTo($extractTo);
    $zip->close();
    
    echo "<h2 style='color:green'>Extraction complete!</h2>";
    
    // Delete the zip file to save space
    @unlink($zipFile);
    echo "<p>Zip file deleted to save space.</p>";
    
    // Delete this script
    @unlink(__FILE__);
    echo "<p>Extract script removed.</p>";
    
    echo "<h3>Next steps:</h3>";
    echo "<ul>";
    echo "<li>Upload the .env file with correct domain settings</li>";
    echo "<li>Upload the root .htaccess file</li>";
    echo "</ul>";
} else {
    echo "<p style='color:red'>Failed to open zip file! Error code: $res</p>";
}
?>
