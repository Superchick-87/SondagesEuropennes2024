<html>

<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.2.8/d3.min.js" type="text/JavaScript"></script>
	<script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="css/aos.css" rel="stylesheet">

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<?php
include 'includes/ddc.php';
setlocale(LC_TIME, "fr_FR.UTF-8");
date_default_timezone_set('Europe/Paris');
// $date = date("d-m-Y");
// $heure = date("H:i");
// Print("Nous sommes le $date et il est $heure");
// date_default_timezone_set('UTC');
// setlocale(LC_TIME, "fr_FR.UTF-8");

// $file = 'https://raw.githubusercontent.com/nsppolls/nsppolls/master/presidentielle.json'; 
// $data = file_get_contents($file); 
// $obj = json_decode($data);

// /--------------------------------/	
// $data = file_get_contents($file); 
// $obj = json_decode($data, true);
// $retour = usort($obj, function($a, $b) {
// 	return $a["fin_enquete"] > $b["fin_enquete"] ? -1 : 1;
// });
// print_r($obj);
// /--------------------------------/

// URL du fichier CSV
// $cheminFichierCSV = 'https://storage.googleapis.com/asapop-website-20220812/_csv/fr.csv';



$cheminFichierCSV = 'https://storage.googleapis.com/asapop-website-20220812/_csv/fr.csv';

// Ouvrir le fichier en mode lecture
$handle = fopen($cheminFichierCSV, 'r');

// Vérifier si le fichier est ouvert avec succès
if ($handle !== false) {
	// Lire la première ligne pour obtenir les noms des colonnes (facultatif)
	$nomsColonnes = fgetcsv($handle);
	// echo implode(', ', $nomsColonnes) . "<br>";
	// Lire le reste du fichier CSV ligne par ligne
	while (($ligne = fgetcsv($handle)) !== false) {
		if ($ligne[5] == '1217') {
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
			}
			// Exemple : Afficher les valeurs de chaque colonne
			// echo implode(', ', $ligne) . "<br>";
			echo '<div style="margin : 0px auto; width: max-content;">';
			for ($i = 9; $i < 29; $i++) {
				echo '<div ' . affiche($ligne[$i]) . '>';
				echo '<div style="text-align: justify;">' . $nomsColonnes[$i] . '</div>';
				echo '<div style="display: flex;">
					<div style="width:' . (((int)(ddc($ligne[$i]))) * 10) . 'px; height:20px; background-color: blue;"></div>
					<div>' . $ligne[$i] . '</div>
					</div></br>';
				echo '</div>';
			}
			echo '</div>';
		}
	}
	// Fermer le fichier
	fclose($handle);
} else {
	echo "Impossible d'ouvrir le fichier CSV.";
}

// $cheminFichierCSV = 'chemin/vers/votre/fichier.csv';

// Indices des colonnes à utiliser pour le tri (commençant à 0)
// $colonnesATrier = [9, 11, 12]; // Par exemple, trier en fonction de la 3e, puis 1re, puis 2e colonne

// // Fonction de comparaison personnalisée pour trier les lignes en fonction des colonnes spécifiées
// function comparerLignes($ligne1, $ligne2) {
//     global $colonnesATrier;

//     // Comparaison des valeurs des colonnes pour le tri
//     foreach ($colonnesATrier as $indiceColonne) {
//         $resultatComparaison = strcmp($ligne1[$indiceColonne], $ligne2[$indiceColonne]);

//         // Si les valeurs sont différentes, retourner le résultat de la comparaison
//         if ($resultatComparaison !== 0) {
//             return $resultatComparaison;
//         }
//     }

//     // Si toutes les valeurs sont égales, retourner 0
//     return 0;
// }

// // Ouvrir le fichier en mode lecture
// $handle = fopen($cheminFichierCSV, 'r');

// // Vérifier si le fichier est ouvert avec succès
// if ($handle !== false) {
//     // Lire la première ligne pour obtenir les noms des colonnes
//     $nomsColonnes = fgetcsv($handle);

//     // Lire le reste du fichier CSV dans un tableau
//     $donnees = array();
//     while (($ligne = fgetcsv($handle)) !== false) {
//         $donnees[] = $ligne;
//     }

//     // Fermer le fichier
//     fclose($handle);

//     // Trier les lignes en utilisant la fonction de comparaison personnalisée
//     usort($donnees, 'comparerLignes');

//     // Afficher les lignes triées
//     foreach ($donnees as $ligne) {
//         echo implode(', ', $ligne) . "<br>";
//     }
// } else {
//     echo "Impossible d'ouvrir le fichier CSV.";
// }



?>