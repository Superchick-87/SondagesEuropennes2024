
<?php

@$dataStart = $_GET['data1'];
echo $dataStart;
include 'includes/ddc.php';

/**
 * * Process de mise en cache du csv
 */

// Définir l'URL du fichier CSV à télécharger
$url_fichier_csv = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQGfGaJSGOe3tGKwHgReahI2NbfPc6zAviwkhrdoN0ytIhPQL9F91NefKf9nmsi_wA833cXaLPo4jDo/pub?gid=0&single=true&output=csv';

// Durée de validité du cache (en secondes)
// $duree_cache = 86400; // 24 heures
$duree_cache = 300; // 24 heures

// Définir le chemin du fichier de cache local
$chemin_fichier_cache = 'fichier_cache.csv';

// Vérifier si le fichier cache est à jour
if (file_exists($chemin_fichier_cache) && (time() - filemtime($chemin_fichier_cache) < $duree_cache)) {
	// Si le fichier cache est à jour, renvoyer le contenu du fichier cache
	header('Content-Type: application/csv');
	header('Content-Disposition: attachment; filename="fichier_cache.csv"');
	// readfile($chemin_fichier_cache);
	echo '</br>' . $duree_cache . '</br>';
	echo time() - filemtime($chemin_fichier_cache) . '</br>';
	echo 'EN CACHE';
} else {
	echo 'PAS EN CACHE';
	// Si le fichier cache n'est pas à jour, télécharger le fichier CSV depuis l'URL
	$contenu_csv = file_get_contents($url_fichier_csv);

	// Sauvegarder le contenu dans le fichier cache local
	file_put_contents($chemin_fichier_cache, $contenu_csv);

	// Renvoyer le contenu du fichier CSV téléchargé
	// header('Content-Type: application/csv');
	// header('Content-Disposition: attachment; filename="fichier_cache.csv"');
	// echo $contenu_csv;
}
/**
 * * fin Process de mise en cache du csv
 */



/**
 * * Appel et lecture du csv
 */
// $chemin_fichier_csv = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQGfGaJSGOe3tGKwHgReahI2NbfPc6zAviwkhrdoN0ytIhPQL9F91NefKf9nmsi_wA833cXaLPo4jDo/pub?gid=0&single=true&output=csv';
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
			function cleanData($tring)
			{
				$tring = str_replace("[4]", "", $tring);
				$tring = str_replace("*", "", $tring);
				$tring = str_replace("Aubry", "", $tring);
				$tring = str_replace("Toussaint", "", $tring);
				$tring = str_replace("Breton", "", $tring);
				$tring = str_replace("Séjourné", "", $tring);
				$tring = str_replace("Le Maire", "", $tring);
				$tring = str_replace("–", "nc", $tring);
				return $tring;
			};
			function minData($x)
			{
				if ($x < 1) {
					$x = 1;
					return $x;
				} else {
					return $x;
				}
			};
			// Exemple : Afficher les valeurs de chaque colonne
			// echo implode(', ', $ligne) . "<br>";
			echo '<div id="container" >';
			for ($i = 3; $i < 19; $i++) {
				echo '<div ' . affiche($ligne[$i]) . '>';
				echo '<div style="text-align: justify;">' . cleanData($nomsColonnes[$i]) . '</div>';
				echo '<div class="barrGraph" style="display: flex;">
					<div class="code_' . cleanData($nomsColonnes[$i]) . ' spaceR" style="width:' . ((minData((int)(cleanData(ddc($ligne[$i]))))) * 10) . 'px;"></div>
					<div class="txtNoWrap bigdata2">' . cleanData($ligne[$i]) . '</div>
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
