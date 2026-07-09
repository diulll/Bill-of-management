$excludeDirs = @('node_modules', '.git')
$source = 'd:\BOM'
$zipPath = 'd:\BOM\project_upload.zip'

# Remove old zip if exists
if (Test-Path $zipPath) { Remove-Item $zipPath -Force }

# Get all files excluding node_modules and .git
$files = Get-ChildItem -Path $source -Recurse -Force | Where-Object {
    $dominated = $false
    foreach ($ex in $excludeDirs) {
        if ($_.FullName -like "*\$ex\*" -or $_.FullName -like "*\$ex") {
            $dominated = $true
            break
        }
    }
    -not $dominated
}

$fileCount = ($files | Where-Object { -not $_.PSIsContainer }).Count
Write-Host "Files to zip: $fileCount"

# Create zip
Write-Host "Creating zip..."
Compress-Archive -Path (Get-ChildItem -Path $source -Force | Where-Object { $_.Name -notin @('node_modules', '.git', 'project_upload.zip') }).FullName -DestinationPath $zipPath -Force
$zipSize = [math]::Round((Get-Item $zipPath).Length / 1MB, 2)
Write-Host "Zip created: $zipSize MB"
