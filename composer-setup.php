<?php
// composer-setup.php

// Benutzer nach den Ersatzwerten für die Konfiguration fragen
$pleaseEnter                    = "Please enter your value for ";
$pleaseEnterModuleNameCamelCase = "Please enter your value for the module name in CamelCase to replace the default value ";
$pleaseEnterCompanyPrefix       = "Please enter your value for the creator prefix to replace the default ('NXD') value for namespace";

$replacements   = array();
$value          = readline($pleaseEnter . "[CREATOR-COMPANY]: ");
$replacements[] = new Replacement("[CREATOR-COMPANY]", $value);
$value          = trim(readline($pleaseEnterCompanyPrefix . ": "));
if (!strlen($value))
{
	$value = 'NXD';
}
$replacements[] = new Replacement("NXD", $value);
$value          = readline($pleaseEnter . "[CREATOR-FULLNAME]: ");
$replacements[] = new Replacement("[CREATOR-FULLNAME]", $value);
$value          = readline($pleaseEnter . "[CREATOR-URL]: ");
$replacements[] = new Replacement("[CREATOR-URL]", $value);
$value          = readline($pleaseEnter . "[CREATOR-EMAIL]: ");
$replacements[] = new Replacement("[CREATOR-EMAIL]", $value);
$value          = readline($pleaseEnter . "[EXTENSION-VERSION]: ");
$replacements[] = new Replacement("[EXTENSION-VERSION]", $value);
$value          = readline($pleaseEnter . "[CREATED-DATE]: ");
$replacements[] = new Replacement("[CREATED-DATE]", $value);
$value          = readline($pleaseEnter . "[CREATED-YEAR]: ");
$replacements[] = new Replacement("[CREATED-YEAR]", $value);
$value          = ucfirst(trim(readline($pleaseEnterModuleNameCamelCase . "'BluePrint': ")));
if (!strlen($value))
{
	$value = 'BluePrint';
}
$replacements['moduleNameCamelCase']   = new Replacement("BluePrint", $value);
$replacements['moduleNameCapitalized'] = new Replacement("Blueprint", ucfirst($value));
$replacements[]                        = new Replacement("blueprint", strtolower($value));
$replacements['moduleNameReplacement'] = new Replacement("mod_blueprint", 'mod_' . strtolower($value));
$replacements[]                        = new Replacement("BLUEPRINT", strtoupper($value));

// First, copy the root-module folder to the ‘customised’ folder
$sourceDir = __DIR__ . '/root-module';
$moduleDir = __DIR__ . '/customized/' . $replacements['moduleNameReplacement']->value;

if (!is_dir($sourceDir))
{
	echo "Error: root-module folder not found!\n";
	exit(1);
}

// Create the destination directory if it does not exist
if (!is_dir($moduleDir))
{
	mkdir($moduleDir, 0755, true);
}

// Recursive copying
copyDirectory($sourceDir, $moduleDir);

echo "Copied root-module to customized/" . $replacements['moduleNameReplacement']->value . " folder.\n";

// Walk recursively through the folders and replace the content of the files

// Directory in which the recursive traversal is to begin
$startDirectory = $moduleDir . '/';
$ignoredFolders = array('.', '..', 'vendor', 'node_modules', '.git', '.idea');

// Create a recursive iterator for the starting directory
$iterator = new RecursiveIteratorIterator(
	new RecursiveDirectoryIterator($startDirectory, RecursiveDirectoryIterator::SKIP_DOTS),
	RecursiveIteratorIterator::SELF_FIRST
);

// Check all files in the root directory
replaceContentOfFolderFiles($startDirectory, $replacements);

// Iterate through the iterator and call the callback function for each folder found
foreach ($iterator as $fileInfo)
{
	if (is_dir($fileInfo->getPathname())
		&& !in_array(basename($fileInfo->getPathname()), $ignoredFolders)
		&& !contains($fileInfo->getPathname(), $ignoredFolders)
	)
	{
		echo "Processing directory: " . $fileInfo->getPathname() . "\n";
		replaceContentOfFolderFiles($fileInfo->getPathname(), $replacements);
	}
}

echo "Replacement completed!\n";

// Rename relevant filenames where mod_blueprint is used
rename($moduleDir . '/mod_blueprint.xml', $moduleDir . "/" . $replacements['moduleNameReplacement']->value . '.xml');
rename($moduleDir . '/language/en-GB/mod_blueprint.ini', $moduleDir . '/language/en-GB/' . $replacements['moduleNameReplacement']->value . '.ini');
rename($moduleDir . '/language/en-GB/mod_blueprint.sys.ini', $moduleDir . '/language/en-GB/' . $replacements['moduleNameReplacement']->value . '.sys.ini');
rename($moduleDir . '/src/Helper/BlueprintHelper.php', $moduleDir . '/src/Helper/' . $replacements['moduleNameCamelCase']->value . 'Helper.php');
// Rename the media folder
rename($moduleDir . '/media/mod_blueprint', $moduleDir . '/media/' . $replacements['moduleNameReplacement']->value);

echo "Renaming completed!\n";
echo " Your customized module is ready in the 'customized/" . $replacements['moduleNameReplacement']->value . "' folder.\n";
echo " Please remember to remove the files 'composer-setup.php', 'composer.json', 'composer.lock' and the 'vendor' folder from your project before deployment.\n";

/**
 * Recursively copy a directory
 *
 * @param   string  $source  Source directory path
 * @param   string  $dest    Destination directory path
 *
 * @return void
 *
 * @since 1.0.0
 */
function copyDirectory($source, $dest)
{
	// Check for any symlinks in the source directory
	if (is_link($source))
	{
		return symlink(readlink($source), $dest);
	}

	// If the source is not a directory, return false
	if (!is_dir($source))
	{
		return false;
	}

	// Create the destination directory if it doesn't exist
	if (!is_dir($dest))
	{
		mkdir($dest, 0755, true);
	}

	// Loop through the files in the source directory
	$files = scandir($source);
	foreach ($files as $file)
	{
		if ($file === '.' || $file === '..')
		{
			continue;
		}

		$sourcePath = $source . '/' . $file;
		$destPath   = $dest . '/' . $file;

		if (is_dir($sourcePath))
		{
			copyDirectory($sourcePath, $destPath);
		}
		else
		{
			copy($sourcePath, $destPath);
		}
	}
}

/**
 * Check if the array of strings contains a string, case-insensitive search returns true if found
 *
 * @param   string  $str  The string to search in
 * @param   array   $arr  The array of strings to search for
 *
 * @return bool
 *
 * @since version
 */
function contains($str, array $arr): bool
{
	foreach ($arr as $a)
	{
		if (stripos($str, $a) !== false) return true;
	}

	return false;
}

/**
 * Replace the content of the files in the folder
 *
 * @param   string  $pathElement   The path string to process (full path string)
 * @param   array   $replacements  The array of Replacement objects
 *
 * @since 1.0.0
 */
function replaceContentOfFolderFiles(string $pathElement, array $replacements): void
{
	$ignoreFiles = array('composer-setup.php');
	$files       = glob($pathElement . '/*.*');
	foreach ($files as $file)
	{
		if (in_array(basename($file), $ignoreFiles))
		{
			continue;
		}
		echo 'Processing file: ' . $file . "\n";
		$content = file_get_contents($file);
		foreach ($replacements as $replacement)
		{
			$content = str_replace($replacement->key, $replacement->value, $content);
		}
		file_put_contents($file, $content);
	}
}

class Replacement
{
	public $key;
	public $value;

	public function __construct($key, $value)
	{
		$this->key   = $key;
		$this->value = $value;
	}
}