<html>
<meta charset="utf-8">

<head>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.2.8/d3.min.js" type="text/JavaScript"></script>
	<script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>


	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!-- <link href="css/aos.css" rel="stylesheet"> -->

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<?php
setlocale(LC_TIME, "fr_FR.UTF-8");
date_default_timezone_set('Europe/Paris');
// $date = date("d-m-Y");
// $heure = date("H:i");
// Print("Nous sommes le $date et il est $heure");
// date_default_timezone_set('UTC');
// setlocale(LC_TIME, "fr_FR.UTF-8");

?>

<body>

	<h1>Présidentielle 2022, tous les sondages</h1>
	<br>
	<form action="">
		<select class="box" id="choix1" name="choix1" onchange="showCustomer(this.value);">
			<?php
			/**
			 * * Appel et lecture du csv pour affichage des options dans le select
			 */
			$chemin_fichier_csv = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQGfGaJSGOe3tGKwHgReahI2NbfPc6zAviwkhrdoN0ytIhPQL9F91NefKf9nmsi_wA833cXaLPo4jDo/pub?gid=0&single=true&output=csv';
			// Ouvrez le fichier en mode lecture
			$fichier = fopen($chemin_fichier_csv, 'r');

			// Vérifiez si le fichier a pu être ouvert avec succès
			if ($fichier) {
				// Parcourez chaque ligne du fichier CSV
				while (($ligne = fgetcsv($fichier)) !== false) {
					// Assurez-vous que la ligne a au moins deux colonnes
					if (count($ligne) >= 2) {
						// Ajoutez une option au menu déroulant avec les deux premières colonnes
						echo '<option value="' . htmlspecialchars($ligne[0]) . ' | ' . htmlspecialchars($ligne[1]) . '">' . $ligne[0] . ' | ' . $ligne[1] . '</option>';
					}
				}
				// Fermez le fichier
				// fclose($fichier);
				// Affichez le menu déroulant
				// echo $selectHTML;
			}
			// else {
			// 	// Gestion des erreurs si le fichier ne peut pas être ouvert
			// 	echo "Erreur lors de l'ouverture du fichier CSV.";
			// }

			?>
		</select>
	</form>
	<div class="accordion">Comment lire les résultats des sondages</div>
	<div class="panel">
		<div class="sources">
			<div>
				<div class="blocparagraphe spaceH2">
					<p class="grey">Les sondages sont une méthode statistique qui comprend une part d’erreur liée à la taille de l'échantillon interrogé et à la représentativité de la population (méthode des quotas). Cette marge d'erreur, également nommée "intervalle de confiance", est représentée dans les graphiques ci-dessous et calculée pour un niveau de confiance de 95% (signifiant qu'on est sûr à 95% que la vraie valeur se trouve dans la marge d'erreur du sondage).</p>
				</div>
				<div class="graph">
					<span class="font2 bleu transp2" style="position:absolute; left:0px; top:41px; text-align:right; width:47.6271%;">Fourchette basse (%)</span>
					<span class="bleuFd transp" style=" position:absolute; left:47.6271%; width : 6.7458%; height:inherit;"></span>
					<span class="bleuFd" style="position:absolute; left:50.8%; top:-30px; width:2px; height:70px;"></span>
					<span class="font2 bleu transp2" style="position:absolute; left:53.3729%; top:-23px; text-align:left;">Fourchette haute (%)</span>
					<span class="bigdata2 bleu" style="position:absolute; left:23.6271%; width : 55.7458%; top:-116px; height:70px; text-align:center;">Score potentiel (%)</span>
				</div>
				<div class="idconfiance font2 spaceH">
					<span class="puceidconfiance bleuFd transp2"></span>
					<p class="font2 bleu transp2">Intervalle de confiance</p>
				</div>
				<p class="blocparagraphe grey spaceH3">Chaque candidat se voit attribuer un score potentiel situé au milieu de cet intervalle de confiance entre la fourchette basse et la fourchette haute du résultat du sondage.</p>
			</div>
		</div>
	</div>
	<div id="txtHint" style="display: block;"></div>
	<br>
	<hr>
	<div class="blocparagraphe">
		<br>
		<h5>Source et méthodologie</h5>
		<p class="grey">Les données ont été agrégées par <a href="https://github.com/nsppolls/nsppolls" target="_blank">Nsppolls</a>.
			<br><br>Sont rassemblés les sondages ayant trait à l'élection présidentielle demandant des intentions de vote, soit les sondages répondant à la question « Si le premier tour avait lieu dimanche, pour qui voteriez-vous ? », ou approchant. Ne sont pas compilés les souhaits de victoire, les chances de l'emporter ou les prédictions.
		</p>
	</div>
	<footer></footer>
</body>

<script type="text/javascript">
	// window.onload = showCustomer();


	document.getElementById("choix1").addEventListener("onchange", showCustomer);
	var data1 = document.getElementById('choix1').value;

	/*=====================================
	=            Fonction ajax            =
	=====================================*/
	function showCustomer(str) {
		var data1 = document.getElementById("choix1").value;
		var xhttp;
		if (str == "") {
			document.getElementById("txtHint").innerHTML = "";
			return;
		}
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("txtHint").innerHTML = "";
				console.log(data1);

			}
			document.getElementById("txtHint").innerHTML = this.responseText;
			getInnerHTML();

		};

		/* Methode GET -> passe une seule variable */
		/* Methode POST -> passe plusieurs variables */
		xhttp.open("GET", "index3.php?data1=" + data1, true);
		xhttp.send();
		// xhttp.open("POST", "index3.php", true);
		// xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		// xhttp.send("data1=" + data1);
	};


	/*=====  End of Fonction ajax  ======*/
</script>
<!-- <script src="js/aos.js"></script>
<script>
	AOS.init({
		easing: 'ease-in-out-sine'
	});
</script> -->
<script>
	function getInnerHTML() {
		// Sélectionnez tous les éléments avec la classe "elementWithHTML"
		var elements = document.querySelectorAll('.bigdata2');
		var elements2 = document.querySelectorAll('.spaceR');

		for (let i = 0; i < elements.length; i++) {
			console.log(elements[i].innerHTML);
			if (elements[i].innerHTML === 'nc') {
				elements2[i - 1].style.width = '0px';
			}

		}
		// // // Parcourez chaque élément et récupérez le contenu HTML interne
		// elements.forEach(function(element, index) {
		// 	var innerHTML = element.innerHTML;

		// 	console.log('InnerHTML de l\'élément ' + (index + 1) + ': ' + innerHTML);
		// });
	}

	// Appelez la fonction pour récupérer les valeurs au chargement de la page
	//window.onload = getInnerHTML;
</script>
<script src="js/accordeon.js"></script>

</html>