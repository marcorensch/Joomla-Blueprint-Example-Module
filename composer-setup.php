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
$replacements[]                        = new Replacement("NXD", $value);
$value                                 = readline($pleaseEnter . "[CREATOR-FULLNAME]: ");
$replacements[]                        = new Replacement("[CREATOR-FULLNAME]", $value);
$value                                 = readline($pleaseEnter . "[CREATOR-URL]: ");
$replacements[]                        = new Replacement("[CREATOR-URL]", $value);
$value                                 = readline($pleaseEnter . "[CREATOR-EMAIL]: ");
$replacements[]                        = new Replacement("[CREATOR-EMAIL]", $value);
$value                                 = readline($pleaseEnter . "[EXTENSION-VERSION]: ");
$replacements[]                        = new Replacement("[EXTENSION-VERSION]", $value);
$value                                 = readline($pleaseEnter . "[CREATED-DATE]: ");
$replacements[]                        = new Replacement("[CREATED-DATE]", $value);
$value                                 = readline($pleaseEnter . "[CREATED-YEAR]: ");
$replacements[]                        = new Replacement("[CREATED-YEAR]", $value);
$value                                 = ucfirst(trim(readline($pleaseEnterModuleNameCamelCase . "'BluePrint': ")));
$replacements['moduleNameCamelCase']   = new Replacement("BluePrint", $value);
$replacements[]                        = new Replacement("blueprint", strtolower($value));
$replacements['moduleNameReplacement'] = new Replacement("mod_blueprint", 'mod_' . strtolower($value));
$replacements[]                        = new Replacement("BLUEPRINT", strtoupper($value));

// Walk recursively through the folders and replace the content of the files

// Verzeichnis, in dem die rekursive Durchquerung beginnen soll
$startDirectory = __DIR__ . '/';
$ignoredFolders = array('.', '..', 'vendor', 'node_modules', '.git', '.idea');

// Erstelle einen rekursiven Iterator für das Startverzeichnis
$iterator = new RecursiveIteratorIterator(
	new RecursiveDirectoryIterator($startDirectory, RecursiveDirectoryIterator::SKIP_DOTS),
	RecursiveIteratorIterator::SELF_FIRST
);

// Checke alle Dateien im Root-Verzeichnis
replaceContentOfFolderFiles($startDirectory, $replacements);

// Durchlaufe den Iterator und rufe die Callback-Funktion für jeden gefundenen Ordner auf
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
rename(__DIR__ . '/mod_blueprint.xml', __DIR__ . "/" . $replacements['moduleNameReplacement']->value . '.xml');
rename(__DIR__ . '/language/en-GB/mod_blueprint.ini', __DIR__ . '/language/en-GB/' . $replacements['moduleNameReplacement']->value . '.ini');
rename(__DIR__ . '/language/en-GB/mod_blueprint.sys.ini', __DIR__ . '/language/en-GB/' . $replacements['moduleNameReplacement']->value . '.sys.ini');
rename(__DIR__ . '/src/Helper/BluePrintHelper.php', __DIR__ . '/src/Helper/' . $replacements['moduleNameCamelCase']->value . 'Helper.php');

echo "Renaming completed!\n";
echo " Please remember to remove the files 'composer-setup.php', 'composer.json', 'composer.lock' and the 'vendor' folder from your project before deployment.\n";

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
