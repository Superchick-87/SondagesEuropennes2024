<?php
include 'includes/ddc.php';

function minData($x)
{
	if ($x < 1) {
		$x = 1;
		return $x * 0.5;
	} else {
		return $x;
	}
};

// @$dataStart = $_GET['data1'];
@$dataStart = $_POST['data1'];
@$dataStartDC = $_POST['data2'];
// echo $dataStart;
// echo $dataStart;
// echo $dataStartDC;



/**
 * * Appel et lecture du csv pour affichage des options dans le select
 */
$chemin_fichier_csv = 'fichier_cache.csv';
// Ouvrez le fichier en mode lecture
$fichier = fopen($chemin_fichier_csv, 'r');

// Lire le fichier ligne par ligne jusqu'à ce que 'toto' soit trouvé
echo '<div id="fondSel2" class="sel2">
<select style="display:block;" class="box" id="choix2" name="choix2" onchange="showCustomer2(this.value);">';
echo '<option>Comparer les hypothèses</option>';
while (($ligne = fgetcsv($fichier)) !== FALSE) {
	
	if (($ligne[22] != '') && ($dataStart== $ligne[20] . ' | ' . $ligne[21])) {
		# code...
		// Vérifier si la ligne contient 'toto'
		if ((in_array('OpinionWay', $ligne)) && (in_array('13-14 décembre 2023', $ligne))) {
			// Faire quelque chose lorsque 'toto' est trouvé dans la ligne
			echo '<option value="' .$ligne[22] . '" >' . $ligne[22]. '</option>';
			echo "Le mot '13-14 décembre 2023' a été trouvé dans la ligne : " . implode(', ', $ligne);
			break; // Sortir de la boucle une fois que 'toto' est trouvé
		}
		else {
			echo '<option value="' . $ligne[22] . '">' . $ligne[22] . '</option>';
			// Si 'toto' n'est pas trouvé, continuer à lire les lignes suivantes
		}
		
					
				}
			}
			// Fermer le fichier
			fclose($fichier);
			echo '</select></div>';
			


/**
 * * Appel et lecture du csv
 */
$chemin_fichier_csv = 'fichier_cache.csv';
// Ouvrir le fichier en mode lecture
$fichier = fopen($chemin_fichier_csv, 'r');
// echo $dataStartDC;
// echo '<img src="images/Logo_' . $nomsColonnes[$i] . '.png"/>';
// Vérifier si le fichier est ouvert avec succès
if ($fichier !== false) {
	// Lire la première ligne pour obtenir les noms des colonnes (facultatif)
	$nomsColonnes = fgetcsv($fichier);
	// echo implode(', ', $nomsColonnes) . "<br>";
	// Lire le reste du fichier CSV ligne par ligne
	while (($ligne = fgetcsv($fichier)) !== false) {
		
		// if ($ligne[2] == '1019') {
			
		if (($dataStart == $ligne[20] . ' | ' . $ligne[21]) && ($ligne[22] == $dataStartDC)) {
			// Faire quelque chose avec les valeurs de la ligne
			// $ligne est un tableau contenant les valeurs des colonnes de la ligne

			// Exemple : Afficher les valeurs de chaque colonne
			// echo implode(', ', $ligne) . "<br>";
			echo '<div id="container" >';
			echo '</br><div class="bigdata3">' . $ligne[2] . ' personnes interrogées</div>';
			for ($i = 3; $i < 20; $i++) {
					echo '<div>';
					echo '<div class="spaceTop" style="text-align: justify;">' . partis($nomsColonnes[$i]) . '</div>';
					// echo '<div>' . ($ligne[36 + $i] - $ligne[20 + $i]) . '</div>';
					// echo '<div>' . $ligne[20 + $i] . '|' . $ligne[36 + $i] . '</div>';
					
					echo '<div class="indice" style="position:relative; left:' . minData($ligne[20 + $i]) * 2 . '%;  width:' . (minData(($ligne[37 + $i] - $ligne[20 + $i]))) * 2 . '%; "></div>';
					
					echo '<div class="barrGraph" style="display: flex;">';
					echo '<div class="code_' . $nomsColonnes[$i] . ' spaceR" style="width:' . ((minData((int)($ligne[$i]))) * 2) . '%;"></div>
					<div class="txtNoWrap bigdata2">' . $ligne[$i] . ' %</div>';
					echo '</div>';
					echo '</div>';
				}
			}
			echo '</div>';
		
	}
	// Fermer le fichier
	fclose($fichier);
} else {
	echo "Impossible d'ouvrir le fichier CSV.";
}
/**
 * * Fin Appel et lecture du csv
 */
