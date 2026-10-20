
<?php
// deploy.php

// Read the module name from command-line arguments
$moduleName = isset($argv[1]) ? trim($argv[1]) : '';

if (empty($moduleName))
{
    echo "Error: Please provide a module name!\n";
    echo "Usage: composer deploy [module-name]\n";
    echo "Example: composer deploy mod_meinmodul\n";
    exit(1);
}

// Defining paths
$baseDir       = __DIR__;
$sourceDir     = $baseDir . '/customized/' . $moduleName;
$distDir       = $baseDir . '/dist';
$zipFilePath   = $distDir . '/' . $moduleName . '.zip';

// Check the list of sources
if (!is_dir($sourceDir))
{
    echo "Error: Module folder not found: customized/" . $moduleName . "\n";
    echo "Please run 'composer setup' first and use the correct module name.\n";
    exit(1);
}

// Create a 'dist' folder if it does not exist
if (!is_dir($distDir))
{
    mkdir($distDir, 0755, true);
    echo "Created dist folder.\n";
}

// Delete any existing ZIP file, if there is one
if (file_exists($zipFilePath))
{
    unlink($zipFilePath);
    echo "Removed existing ZIP file.\n";
}

// Create a ZIP archive
$zip = new ZipArchive();
if ($zip->open($zipFilePath, ZipArchive::CREATE) !== true)
{
    echo "Error: Could not create ZIP file!\n";
    exit(1);
}

// Add files to the ZIP file recursively
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($sourceDir),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $file)
{
    if (!$file->isDir())
    {
        $filePath     = $file->getRealPath();
        $relativePath = substr($filePath, strlen($sourceDir) + 1);

        // Unerwünschte Dateien ausschließen
        $excludeFiles = ['composer-setup.php', 'composer.json', 'composer.lock', '.gitignore'];
        $excludeFolders = ['vendor', 'node_modules', '.git', '.idea', '.vscode'];

        $skip = false;

        // Check whether the file should be excluded
        if (in_array(basename($file), $excludeFiles))
        {
            $skip = true;
        }

        // Check whether the path contains any excluded folders
        foreach ($excludeFolders as $folder)
        {
            if (strpos($relativePath, $folder . '/') === 0 || strpos($relativePath, '/' . $folder . '/') !== false)
            {
                $skip = true;
                break;
            }
        }

        if (!$skip)
        {
            $zip->addFile($filePath, $relativePath);
            echo "Added: " . $relativePath . "\n";
        }
    }
}

$zip->close();

echo "\n========================================\n";
echo "Deployment completed successfully!\n";
echo "========================================\n";
echo "ZIP file created: dist/" . $moduleName . ".zip\n";
echo "File size: " . round(filesize($zipFilePath) / 1024, 2) . " KB\n";
echo "========================================\n";