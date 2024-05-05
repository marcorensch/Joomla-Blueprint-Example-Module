<?php
// composer-setup.php

// Benutzer nach den Ersatzwerten für die Konfiguration fragen
$pleaseEnter = "Please enter your value for ";
$pleaseEnterModuleNameCamelCase = "Please enter your value for the module name in CamelCase to replace the default value ";
$pleaseEnterCompanyPrefix = "Please enter your value for the creator prefix to replace the default ('NXD') value for namespace";

$replacements = array();
$value = readline($pleaseEnter . "[CREATOR-COMPANY]: ");
$replacements[] = new Replacement("[CREATOR-COMPANY]", $value);
$value = trim(readline($pleaseEnterCompanyPrefix . ": "));
if(strlen($value) > 0 ) { $value = 'NXD'; }
$replacements[] = new Replacement("NXD", $value);
$value = readline($pleaseEnter . "[CREATOR-FULLNAME]: ");
$replacements[] = new Replacement("[CREATOR-FULLNAME]", $value);
$value = readline($pleaseEnter . "[CREATOR-URL]: ");
$replacements[] = new Replacement("[CREATOR-URL]", $value);
$value = readline($pleaseEnter . "[CREATOR-EMAIL]: ");
$replacements[] = new Replacement("[CREATOR-EMAIL]", $value);
$value = readline($pleaseEnter . "[EXTENSION-VERSION]: ");
$replacements[] = new Replacement("[EXTENSION-VERSION]", $value);
$value = readline($pleaseEnter . "[CREATED-DATE]: ");
$replacements[] = new Replacement("[CREATED-DATE]", $value);
$value = readline($pleaseEnter . "[CREATED-YEAR]: ");
$replacements[] = new Replacement("[CREATED-YEAR]", $value);
$value = ucfirst(trim(readline($pleaseEnterModuleNameCamelCase . "'BluePrint': ")));
$replacements[] = new Replacement("BluePrint", $value);
$replacements[] = new Replacement("blueprint", strtolower($value));
$replacements['moduleNameReplacement'] = new Replacement("mod_blueprint", 'mod_' . strtolower($value));
$replacements[] = new Replacement("BLUEPRINT", strtoupper($value));

// Walk recursively through the folders and replace the content of the files
// Callback-Funktion, die für jeden gefundenen Ordner ausgeführt wird
// Callback-Funktion, die für jeden gefundenen Ordner ausgeführt wird
function processDirectory($fileInfo, $replacements): void
{
	if ($fileInfo->isDir()) {
		echo "Processing directory: " . $fileInfo->getPathname() . "\n";
	}else{
		echo "Processing file: " . $fileInfo->getPathname() . "\n";
		replaceContentOfFolderFiles($fileInfo->getPathname(), $replacements);
	}
}

// Verzeichnis, in dem die rekursive Durchquerung beginnen soll
$startDirectory = __DIR__ . '/';

// Erstelle einen rekursiven Iterator für das Startverzeichnis
$iterator = new RecursiveIteratorIterator(
	new RecursiveDirectoryIterator($startDirectory, RecursiveDirectoryIterator::SKIP_DOTS),
	RecursiveIteratorIterator::SELF_FIRST
);

$ignoredFolders = array('.', '..', 'vendor', 'node_modules', '.git', '.idea');

// Durchlaufe den Iterator und rufe die Callback-Funktion für jeden gefundenen Ordner auf
foreach ($iterator as $fileInfo) {
	if(!in_array($fileInfo->getFilename(), $ignoredFolders))
	{
		processDirectory($fileInfo, $replacements);
	}
}

echo "Replacement completed!\n";

// Rename relevant filenames where mod_blueprint is used
rename(__DIR__ . '/mod_blueprint.xml', __DIR__ . "/" . $replacements['moduleNameReplacement']->value . '.xml');
rename(__DIR__ . '/language/en-GB/mod_blueprint.ini', __DIR__ . '/language/en-GB/' . $replacements['moduleNameReplacement']->value  . '.ini');
rename(__DIR__ . '/language/en-GB/mod_blueprint.sys.ini', __DIR__ . '/language/en-GB/' . $replacements['moduleNameReplacement']->value  . '.sys.ini');

echo "Renaming completed!\n";
echo " Please remember to remove the files 'composer-setup.php', 'composer.json', 'composer.lock' and the 'vendor' folder from your project before deployment.\n";

function replaceContentOfFolderFiles($folder, $replacements): void
{
	$ignoreFolders = array('.', '..', 'vendor', 'node_modules', '.git', '.idea');
	$ignoreFiles = array('composer-setup.php');
	if (in_array(basename($folder), $ignoreFolders) || str_starts_with(basename($folder), '.')) {
		return;
	}
	$files = glob($folder . '/*.*');
	foreach ($files as $file) {
		if(in_array(basename($file), $ignoreFiles)) {
			continue;
		}
		echo 'Processing file: ' . $file . "\n";
		$content = file_get_contents($file);
		foreach($replacements as $replacement) {
			$content = str_ireplace($replacement->key, $replacement->value, $content);
		}
		file_put_contents($file, $content);
	}
}
class Replacement {
	public $key;
	public $value;

	public function __construct($key, $value) {
		$this->key = $key;
		$this->value = $value;
	}
}
