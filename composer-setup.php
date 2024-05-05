<?php
// composer-setup.php

// Benutzer nach den Ersatzwerten für [CREATOR], [DATE] und [COMPANY] fragen
$pleaseEnter = "Please enter your value for ";
$creatorReplacement = readline($pleaseEnter . "[CREATOR]: ");
$dateReplacement = readline($pleaseEnter . "[DATE]: ");
$cdateReplacement = readline($pleaseEnter . "[CREATEDDATE]: ");
$yearDateReplacement = readline($pleaseEnter . "[CREATEDYEAR]: ");
$companyReplacement = readline($pleaseEnter . "[CREATORCOMPANY]: ");
$urlReplacement = readline($pleaseEnter . "[CREATORURL]: ");
$cnameReplacement = readline($pleaseEnter . "[CREATORNAME]: ");
$emailReplacement = readline($pleaseEnter . "[CREATOREMAIL]: ");
$versionReplacement = readline($pleaseEnter . "[VERSION]: ");

// Dateien durchsuchen und ersetzen
$files = glob(__DIR__ . '/*.*');
foreach ($files as $file) {
	$content = file_get_contents($file);
	$content = str_replace('[CREATOR]', $creatorReplacement, $content);
	$content = str_replace('[DATE]', $dateReplacement, $content);
	$content = str_replace('[CREATEDDATE]', $cdateReplacement, $content);
	$content = str_replace('[CREATEDYEAR]', $yearDateReplacement, $content);
	$content = str_replace('[CREATORURL]', $urlReplacement, $content);
	$content = str_replace('[CREATORNAME]', $cnameReplacement, $content);
	$content = str_replace('[CREATOREMAIL]', $emailReplacement, $content);
	$content = str_replace('[VERSION]', $versionReplacement, $content);
	file_put_contents($file, $content);
}

echo "Replacement completed!\n";