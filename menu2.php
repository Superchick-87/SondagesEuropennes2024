<?php
// setlocale(LC_TIME, 'fr_FR');
setlocale(LC_TIME, "fr_FR.UTF-8");
date_default_timezone_set('Europe/Paris');
$dataA=$_POST['data1'];
$data2=$_POST['data2'];
echo $data2;
// chemin d'accès à votre fichier JSON
$file = 'https://raw.githubusercontent.com/nsppolls/nsppolls/master/presidentielle.json'; 
// mettre le contenu du fichier dans une variable
$data = file_get_contents($file); 
// décoder le flux JSON
// $obj = json_decode($data); 
$obj = json_decode($data, true);
// accéder à l'élément approprié
$retour = usort($obj, function($a, $b) {
		return $a["fin_enquete"] > $b["fin_enquete"] ? -1 : 1;
		});
// l'élément trié

/**
 * Objectif : mettre dans l'ordre alphabétique la liste des clubs issue du xml
 * [1] on crée un tableau et on remplit en récupèrant la liste dans le désordre
 * [2] on crée un objet via "ArrayObject()" avec le tableau [1] en paramètre
 *  et on supprime les doublons du tableau avec array_unique
 */
	
	/*----------  [1]  ----------*/
	
	$menuDeroulant3 = array();
	$i=0;

	foreach ($obj as $value) {
		foreach ($value['tours'] as $toto) {
			if (($toto['tour'] == $dataA) && (strftime('%d %b %g',strtotime($value['fin_enquete'])).' | '.$value['commanditaire'].' | '.$value['nom_institut'] == $data2)) {
				foreach ($toto['hypotheses'] as $hyp) {
					$menuDeroulant3[] = $hyp['hypothese'];
				}
			}
		}
	}
	
	/*----------  [2]  ----------*/
	
	$menuDeroulant3ArrayObject = new ArrayObject(array_unique($menuDeroulant3));
	
	/*----------  [2]  ----------*/
	
	echo '<option style="display:block;" value="x" id="x">Sélectionnez une hypothèse</option>';
	
	foreach ($menuDeroulant3ArrayObject as $val3) {
		if ($val3 == '') {
			echo '<option value="'.$val3.'" id="tour'.$i++.'">Tous les résultats</option>';
		}
		else{
			echo '<option value="'.$val3.'" id="tour'.$i++.'">'.$val3.'</option>';	
		}
	}

?>