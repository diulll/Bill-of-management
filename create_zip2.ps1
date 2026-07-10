Add-Type -AssemblyName System.IO.Compression.FileSystem

$source = 'd:\BOM'
$zipPath = 'd:\BOM\project_upload2.zip'
$excludeDirs = @('node_modules', '.git')
$excludeFiles = @('project_upload.zip', 'project_upload2.zip', 'create_zip.ps1', 'copy_to_new_domain.php', 'path_check.php', 'extract.php', 'setup.php', 'cleanup.php', '.env.production.new', '.htaccess.root')

# Remove old zip
if (Test-Path $zipPath) { Remove-Item $zipPath -Force }

# Create zip with forward slashes
$zip = [System.IO.Compression.ZipFile]::Open($zipPath, 'Create')

$allFiles = Get-ChildItem -Path $source -Recurse -File -Force
$count = 0

foreach ($file in $allFiles) {
    $relativePath = $file.FullName.Substring($source.Length + 1)
    
    # Skip excluded directories
    $skip = $false
    foreach ($ex in $excludeDirs) {
        if ($relativePath -like "$ex\*" -or $relativePath -eq $ex) {
            $skip = $true
            break
        }
    }
    if ($skip) { continue }
    
    # Skip excluded files
    if ($file.Name -in $excludeFiles) { continue }
    
    # Convert backslashes to forward slashes for Linux compatibility
    $entryName = $relativePath.Replace('\', '/')
    
    [System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile($zip, $file.FullName, $entryName, [System.IO.Compression.CompressionLevel]::Optimal) | Out-Null
    $count++
}

$zip.Dispose()

$zipSize = [math]::Round((Get-Item $zipPath).Length / 1MB, 2)
Write-Host "Files zipped: $count"
Write-Host "Zip size: $zipSize MB"
Write-Host "Done!"
