<?php
function ddc($tring)
{
	//$tring =" afrique-du-sud c'est àô&éè§çïÏîÎ pas écoute AFRIQUE DU SUD";
	$tring = htmlentities($tring, ENT_NOQUOTES, $encoding = 'utf-8');
	$tring = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $tring);
	$tring = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $tring);
	$tring = preg_replace('#&[^;]+;#', '', $tring);
	$tring = str_replace("-", " ", $tring);
	$tring = mb_strtolower($tring); //oblige la chaine de caractère d'être en bas de casse
	$tring = ucwords($tring); //oglige à mettre une capitale à chaque mot
	$tring = str_replace("'", "", $tring);
	$tring = str_replace(" ", "", $tring);
	$tring = str_replace("%", "", $tring);
	$tring = str_replace(",", ".", $tring);
	return $tring;
};

function partis($tring)
{
	$tring = str_replace("LO", "LO - Lutte ouvrière", $tring);
	$tring = str_replace("PCF", "PCF - Parti communiste", $tring);
	$tring = str_replace("LFI", "LFI - France insoumise", $tring);
	$tring = str_replace("PS", "PS - Parti socialiste", $tring);
	$tring = str_replace("EELV", "EELV - Les écologistes", $tring);
	$tring = str_replace("PRG", "PRG - Parti radical de gauche", $tring);
	$tring = str_replace("EAC", "EAC - Ecologie au centre", $tring);
	$tring = str_replace("ENS", "ENS - Ensemble", $tring);
	$tring = str_replace("AR", "AR - Alliance rurale", $tring);
	$tring = str_replace("NE", "NE - Notre Europe", $tring);
	$tring = str_replace("LR", "LR - Les Républicains", $tring);
	$tring = str_replace("DLF", "DLF - Debout la France", $tring);
	$tring = str_replace("RN", "RN - Rassemblement national", $tring);
	$tring = str_replace("REC", "REC - Reconquête", $tring);
	$tring = str_replace("PA", "PA - Parti animaliste", $tring);
	$tring = str_replace("Autres", "Autres", $tring);
	$tring = str_replace("UPR", "UPR - Union populaire républicaine", $tring);
	$tring = str_replace("RES", "RES - Résistons", $tring);
	$tring = str_replace("LP", "LP - Les Patriotes", $tring);
	return $tring;
};
