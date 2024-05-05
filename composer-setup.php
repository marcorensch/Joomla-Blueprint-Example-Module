<?php
// composer-setup.php

// Benutzer nach den Ersatzwerten für die Konfiguration fragen
$pleaseEnter = "Please enter your value for ";
$pleaseEnterModuleName = "Please enter your value for the module name prefixed with 'mod_' in lowercase to replace the default value ";
$pleaseEnterModuleNameCamelCase = "Please enter your value for the module name in CamelCase to replace the default value ";
$pleaseEnterCompanyPrefix = "Please enter your value for the creator prefix to replace the default ('NXD') value for namespace";

$companyReplacement = readline($pleaseEnter . "[CREATOR-COMPANY]: ");
$companyPrefixReplacement = trim(readline($pleaseEnterCompanyPrefix . ": "));
$cnameReplacement = readline($pleaseEnter . "[CREATOR-FULLNAME]: ");
$urlReplacement = readline($pleaseEnter . "[CREATOR-URL]: ");
$emailReplacement = readline($pleaseEnter . "[CREATOR-EMAIL]: ");
$versionReplacement = readline($pleaseEnter . "[EXTENSION-VERSION]: ");
$cdateReplacement = readline($pleaseEnter . "[CREATED-DATE]: ");
$yearDateReplacement = readline($pleaseEnter . "[CREATED-YEAR]: ");
$moduleModNameCcReplacement = ucfirst(trim(readline($pleaseEnterModuleNameCamelCase . "'BluePrint': ")));
$moduleNameLowercase = strtolower($moduleModNameCcReplacement);
$moduleModNameReplacement = 'mod_' . $moduleNameLowercase;
$moduleNameUppercase = strtoupper($moduleModNameCcReplacement);

// Dateien durchsuchen und ersetzen
$files = glob(__DIR__ . '/*.*');
foreach ($files as $file) {
	$content = file_get_contents($file);
	$content = str_replace('[CREATED-DATE]', $cdateReplacement, $content);
	$content = str_replace('[CREATED-YEAR]', $yearDateReplacement, $content);
	$content = str_replace('[CREATOR-COMPANY]', $companyReplacement, $content);
	$content = str_replace('[CREATOR-URL]', $urlReplacement, $content);
	$content = str_replace('[CREATOR-FULLNAME]', $cnameReplacement, $content);
	$content = str_replace('[CREATOR-EMAIL]', $emailReplacement, $content);
	$content = str_replace('[EXTENSION-VERSION]', $versionReplacement, $content);
	$content = str_replace('mod_blueprint', $moduleModNameReplacement, $content);
	$content = str_replace('BluePrint', $moduleModNameCcReplacement, $content);
	$content = str_replace('blueprint', $moduleNameLowercase, $content);
	$content = str_replace('BLUEPRINT', $moduleNameUppercase, $content);
	if(strlen($companyPrefixReplacement) > 0 ) { $content = str_replace('NXD', $companyPrefixReplacement, $content); }
	file_put_contents($file, $content);
}

echo "Replacement completed!\n";