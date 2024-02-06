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

@$dataStart = $_GET['data1'];
// echo $dataStart;

/**
 * * Appel et lecture du csv
 */
$chemin_fichier_csv = 'fichier_cache.csv';
// Ouvrir le fichier en mode lecture
$fichier = fopen($chemin_fichier_csv, 'r');

// Vérifier si le fichier est ouvert avec succès
if ($fichier !== false) {
	// Lire la première ligne pour obtenir les noms des colonnes (facultatif)
	$nomsColonnes = fgetcsv($fichier);
	// echo implode(', ', $nomsColonnes) . "<br>";
	// Lire le reste du fichier CSV ligne par ligne
	while (($ligne = fgetcsv($fichier)) !== false) {
		// if ($ligne[2] == '1019') {
		if ($dataStart == $ligne[0] . ' | ' . $ligne[1]) {
			// Faire quelque chose avec les valeurs de la ligne
			// $ligne est un tableau contenant les valeurs des colonnes de la ligne

			// Exemple : Afficher les valeurs de chaque colonne
			// echo implode(', ', $ligne) . "<br>";
			echo '<div id="container" >';
			for ($i = 3; $i < 19; $i++) {
				echo '<div >';
				// echo '<img src="images/Logo_' . $nomsColonnes[$i] . '.png"/>';
				echo '<div class="spaceTop" style="text-align: justify;">' . $nomsColonnes[$i] . '</div>';
				echo '<div class="barrGraph" style="display: flex;">
					<div class="code_' . $nomsColonnes[$i] . ' spaceR" style="width:' . ((minData((int)(ddc($ligne[$i])))) * 2) . '%;"></div>
					<div class="txtNoWrap bigdata2">' . $ligne[$i] . ' %</div>
					</div>';
				echo '</div>';
			}
			echo '</div>';
		}
	}
	// Fermer le fichier
	fclose($fichier);
} else {
	echo "Impossible d'ouvrir le fichier CSV.";
}
/**
 * * Fin Appel et lecture du csv
 */
