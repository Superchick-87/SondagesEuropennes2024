<?php
include 'includes/ddc.php';
function minData($x)
{
	if ($x < 1) {
		$x = 1;
		return $x * 0.5;
	}
	if ($x == 'nc') {
		$x = 0;
		return $x;
	} else {
		return $x;
	}
};

@$dataStart = $_POST['data1'];
@$dataStartDC = $_POST['data2'];

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
$AjoutParti = -1;
while (($ligne = fgetcsv($fichier)) !== FALSE) {

	if (($ligne[26+$AjoutParti] != '') && ($dataStart == $ligne[24+$AjoutParti] . ' | ' . $ligne[25+$AjoutParti])) {
		// Vérifier si la ligne contient 'toto'
		if ((in_array('OpinionWay', $ligne)) && (in_array('13-14 décembre 2023', $ligne))) {
			// Faire quelque chose lorsque 'toto' est trouvé dans la ligne
			echo '<option value="' . $ligne[26+$AjoutParti] . '" >' . $ligne[26+$AjoutParti] . '</option>';
			echo "Le mot '13-14 décembre 2023' a été trouvé dans la ligne : " . implode(', ', $ligne);
			break; // Sortir de la boucle une fois que 'toto' est trouvé
		} else {
			echo '<option value="' . $ligne[26+$AjoutParti] . '">' . $ligne[26+$AjoutParti] . '</option>';
			// Si 'toto' n'est pas trouvé, continuer à lire les lignes suivantes
		}
	}
}
fclose($fichier);
echo '</select></div>';
function vide(){

}
/**
 * * Appel et lecture du csv
 * * Affichage des datas
 */
$chemin_fichier_csv = 'fichier_cache.csv';
// Ouvrir le fichier en mode lecture
$fichier = fopen($chemin_fichier_csv, 'r');
// Vérifier si le fichier est ouvert avec succès
if ($fichier !== false) {
	// Lire la première ligne pour obtenir les noms des colonnes (facultatif)
	$nomsColonnes = fgetcsv($fichier);
	// Lire le reste du fichier CSV ligne par ligne

	while (($ligne = fgetcsv($fichier)) !== false) {
		if (($dataStart == $ligne[24+ $AjoutParti] . ' | ' . $ligne[25+ $AjoutParti]) && ($ligne[26+ $AjoutParti] == $dataStartDC)&& ($nomsColonnes != '$dataStartDC')) {

			echo '</br><div id="echantillon" class="bigdata3">' . number_format($ligne[2], 0, ',', ' ') . ' personnes interrogées</div>';
			echo '<div id="container" >';
			for ($i = 3; $i < (24 + $AjoutParti); $i++) {
				if ($i != 15) { // colonne à ne pas afficher : 'RES'
				echo '<div>';
				echo '<div class="spaceTop" style="text-align: left;">' . partis($nomsColonnes[$i]) . '</div>';
				// echo '<div class="indice2" "></div>';
				echo '<div class="indice" style="position:relative; left:' . minData($ligne[24+ $AjoutParti + $i]) * 2 . '%;  width:' . (minData(($ligne[44+ $AjoutParti + $i] - $ligne[24+ $AjoutParti + $i]))) * 2 . '%; "></div>';

				echo '<div class="barrGraph" style="display: flex;">';
				echo '<div class="code_' . $nomsColonnes[$i] . ' spaceR" style="width:' . ((minData((int)($ligne[$i]))) * 2) . '%;"></div>
					<div class="txtNoWrap bigdata2">' . $ligne[$i] . ' %</div>';
				echo '</div>';
				echo '</div>';
			}}
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
