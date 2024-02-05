
<?php


include 'includes/ddc.php';

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

		function suppStr($x){
			// Trouver la première occurrence de "%"
			$result = strstr($x, '%', true);
			$resultt = strstr($x, '[', true);
			// Vérifier si le symbole "%" est présent
			if ($result !== false) {
				// Afficher la partie de la chaîne avant le symbole "%"
				return $result;
			}if ($resultt !== false) {
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
				return $tring;
				
			};
			function minData($x)
			{
				if ($x < 1) {
					$x = 1;
					return $x*0.5;
				} else {
					return $x;
				}
			};
			
			@$dataStart = cleanData(suppStr($_GET['data1']));
			echo $dataStart;

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
 * ! tempo -> sert à nétoyer et à ré-enregistrer le csv
 */

// Chemin vers le fichier CSV
$cheminFichierCSV = 'fichier_cache.csv';

// Ouvrir le fichier en lecture et écriture
$handle = fopen($cheminFichierCSV, 'r+');


// Vérifier si le fichier est ouvert avec succès
if ($handle !== false) {
    // Lire le contenu du fichier dans un tableau
    $contenu = [];
	while (($data = fgetcsv($handle)) !== false) {
		for ($n=0; $n < 19; $n++) { 
			// Effectuer les modifications nécessaires sur chaque ligne
			$data[$n] = cleanData(suppStr($data[$n]));
		}
		$contenu[] = $data;
	}
    // Remettre le pointeur du fichier au début
    fseek($handle, 0);

    // Tronquer le fichier pour effacer le contenu existant
    ftruncate($handle, 0);

    // Écrire le nouveau contenu dans le fichier
    foreach ($contenu as $ligne) {
        fputcsv($handle, $ligne);
    }

    // Fermer le fichier
    fclose($handle);

    echo 'Le fichier CSV a été modifié avec succès.';
} else {
    echo 'Erreur lors de l\'ouverture du fichier en lecture et écriture.';
}

/**
 * ! tempo
 */

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
				echo '<div ' . $ligne[$i] . '>';
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
