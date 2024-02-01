<?php
include (dirname(__FILE__).'/includes/functions.php');
@$data1=$_POST['data1'];
echo $data1;
// chemin d'accès à votre fichier JSON
$file = 'https://raw.githubusercontent.com/nsppolls/nsppolls/master/presidentielle.json'; 
// mettre le contenu du fichier dans une variable
$data = file_get_contents($file); 
// décoder le flux JSON
// $obj = json_decode($data); 
// accéder à l'élément approprié
$obj = json_decode($data, true);
	$retour = usort($obj, function($a, $b) {
   		return $a["fin_enquete"] > $b["fin_enquete"] ? -1 : 1;
 	});


/**
 * Objectif : mettre dans l'ordre alphabétique la liste des clubs issue du xml
 * [1] on crée un tableau et on remplit en récupèrant la liste dans le désordre
 * [2] on crée un objet via "ArrayObject()" avec le tableau [1] en paramètre
 *  et on supprime les doublons du tableau avec array_unique
 */

	/*----------  [1]  ----------*/
	
	$menuDeroulant2 = array();
	$i=0;
	foreach ($obj as $value2) {
		foreach ($value2['tours'] as $toto) {
			if ($toto['tour'] == $data1){
				setlocale(LC_TIME, "fr_FR.UTF-8");
				date_default_timezone_set('Europe/Paris');
				$menuDeroulant2[] = strftime('%d %b %g',strtotime($value2['fin_enquete'])).' | '.$value2['commanditaire'].' | '.$value2['nom_institut'];
			}
		}
	}		
	/*----------  [2]  ----------*/

	$menuDeroulant2ArrayObject = new ArrayObject(array_unique($menuDeroulant2));
	print_r($menuDeroulant2ArrayObject);
	
	/*----------  [3]  ----------*/
	
	echo '<option value="x" id="">Sélectionnez un sondage</option>';
	foreach ($menuDeroulant2ArrayObject as $val2) {
		echo '<option value="'.$val2.'" id="sondage'.$i++.'">'.formatmenu($val2).'</option>';
		
	}	

?>