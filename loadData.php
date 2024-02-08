<?php
include 'includes/dataProcessing.php';

/**
 * * Process de mise en cache du csv
 */

// Définir l'URL du fichier CSV à télécharger
$url_fichier_csv = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQGfGaJSGOe3tGKwHgReahI2NbfPc6zAviwkhrdoN0ytIhPQL9F91NefKf9nmsi_wA833cXaLPo4jDo/pub?gid=0&single=true&output=csv';

// Durée de validité du cache (en secondes)
$duree_cache = 300; // 24 heures

// Définir le chemin du fichier de cache local
$chemin_fichier_cache = 'fichier_cache.csv';

// Vérifier si le fichier cache est à jour
if (file_exists($chemin_fichier_cache) && (time() - filemtime($chemin_fichier_cache) < $duree_cache)) {
	// Si le fichier cache est à jour, renvoyer le contenu du fichier cache
	// 	header('Content-Type: application/csv');
	// 	header('Content-Disposition: attachment; filename="' . $chemin_fichier_cache . '"');
	echo 'EN CACHE';
	echo '</br>' . $duree_cache . '</br>';
	echo time() - filemtime($chemin_fichier_cache) . '</br>';
} else {
	echo '</br>';
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
		for ($n = 0; $n < count($data); $n++) {
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
