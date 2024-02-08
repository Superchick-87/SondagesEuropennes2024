<?php
function affiche($x)
{
	$y = '';
	if ($x == 'Not Available') {
		$y = 'style="display : none;"';
		return $y;
	} else {
		$y =  'style="display : block;"';
		return $y;
	}
};

function suppStr($x)
{
	// Trouver la première occurrence de "%"
	$result = strstr($x, '%', true);
	$resultt = strstr($x, '[', true);
	// Vérifier si le symbole "%" est présent
	if ($result !== false) {
		// Afficher la partie de la chaîne avant le symbole "%"
		return $result;
	}
	if ($resultt !== false) {
		// Afficher la partie de la chaîne avant le symbole "%"
		return $resultt;
	} else {
		// Le symbole "%" n'est pas trouvé
		return $x;
	}
};
function cleanData($tring)
{
	$tring = str_replace("[4]", "", $tring);
	$tring = str_replace("*", "", $tring);
	$tring = str_replace("–", "nc", $tring);
	$tring = str_replace("", "nc", $tring);
	$tring = str_replace(",", ".", $tring);
	return $tring;
};
