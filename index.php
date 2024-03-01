<html>
<meta charset="utf-8">

<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.2.8/d3.min.js" type="text/JavaScript"></script>
	<script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://unpkg.com/pattern.css" rel="stylesheet">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<?php
setlocale(LC_TIME, "fr_FR.UTF-8");
date_default_timezone_set('Europe/Paris');
?>

<body class='pattern-dots-sm'>
	<h1>Européennes 2024, les derniers sondages</h1>
	<br>
	<form action="">
		<h4>Choisir un sondage</h4>
		<select class="box" id="choix1" name="choix1" onchange="showCustomer(this.value); start();">
			<?php
			/**
			 * * Appel et lecture du csv pour affichage des options dans le select
			 */
			$chemin_fichier_csv = 'fichier_cache.csv';
			// Ouvrez le fichier en mode lecture
			$fichier = fopen($chemin_fichier_csv, 'r');

			fgets($fichier);
			// Lire le fichier ligne par ligne jusqu'à ce que 'toto' soit trouvé
			while (($ligne = fgetcsv($fichier)) !== FALSE) {

				if ($ligne[0] != '') {
					// Vérifier si la ligne contient 'toto'
					if ((in_array('OpinionWay', $ligne)) && (in_array('13-14 décembre 2023', $ligne))) {
						// Faire quelque chose lorsque 'toto' est trouvé dans la ligne
						echo '<option value="' . htmlspecialchars($ligne[0]) . ' | ' . htmlspecialchars($ligne[1]) . '">' . $ligne[0] . ' | ' . $ligne[1] . '</option>';
						echo "Le mot '13-14 décembre 2023' a été trouvé dans la ligne : " . implode(', ', $ligne);
						break; // Sortir de la boucle une fois que 'toto' est trouvé
					}
					echo '<option value="' . htmlspecialchars($ligne[0]) . ' | ' . htmlspecialchars($ligne[1]) . '">' . $ligne[0] . ' | ' . $ligne[1] . '</option>';
					// Si 'toto' n'est pas trouvé, continuer à lire les lignes suivantes
				}
			}
			fclose($fichier);
			?>
		</select>
	</form>
		<div id="txtHint" ></div>
		</br>
	<div id="txtHint2"></div>
	<div class="accordion">Comment lire les résultats des sondages</div>
	<div class="panel">
		<div class="sources">
			<div>
				<div class="blocparagraphe spaceH2">
					<p class="grey">Les sondages sont une méthode statistique qui comprend une part d’erreur liée à la taille de l'échantillon interrogé et à la représentativité de la population (méthode des quotas). Cette marge d'erreur, également nommée "intervalle de confiance", est représentée dans les graphiques ci-dessus et calculée pour un niveau de confiance de 95% (signifiant qu'on est sûr à 95% que la vraie valeur se trouve dans la marge d'erreur du sondage).</p>
				</div>
				<div style="width: 300px; margin: 0px auto;">
					<div class="spaceTop" style="text-align: justify;">Parti politique</div>
					<div class="indice" style="position:relative; left:43.44%;  width:14.16%; "></div>
					<div class="barrGraph" style="display: flex;">
						<div class="code_ENS spaceR" style="width: 102%; background-color: #648eb3;"></div>
						<div class="bigdata2" style="position: relative; top: -61px; left: -3px; line-height: 1em; text-align: left;">Score potentiel (%)</div>
					</div>
				</div>
				<p style="margin-top: 5px;">Intervalle de confiance</p>
				<div class="indice" style="width: 100px; margin: 0px auto; margin-top: 5px;"></div>
				<div>
					<span style="position: relative;left: -60px;"><i style="letter-spacing: -0.5;">Fourchette basse</i></span>
					<span><i style="letter-spacing: -0.5;">haute</i></span>
				</div>
				<p class="blocparagraphe grey spaceH3">Chaque parti se voit attribuer un score potentiel situé au milieu de cet intervalle de confiance entre la fourchette basse et la fourchette haute du résultat du sondage.</p>
		</br>
			</div>
		</div>
	</div>
	<hr>
	<div class="blocparagraphe">
	</br>
		<h5>Source et méthodologie</h5>
		<p class="grey">Les données ont été rassemblées par les contributeurs <a href="https://fr.wikipedia.org/wiki/Sondages_sur_les_%C3%A9lections_europ%C3%A9ennes_de_2024" target="_blank">Wikipedia</a>.
		</p>
	</div>
	</br>
	</br>
	<footer></footer>
</body>

<script type="text/javascript">
	window.onload = showCustomer();
	window.onload = showCustomer2();
	window.onload = nbreOptSel();
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
				// console.log(data1);
				// console.log(data2);
			}
			document.getElementById("txtHint").innerHTML = this.responseText;
			nbreOptSel();
			getInnerHTML();
			showCustomer2();
		};
		xhttp.open("POST", "done.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("data1="+data1);
		// xhttp.open("GET", "done.php?data1=" + data1, true);
		// xhttp.send();
	};

	function showCustomer2(str) {
		var data1 = document.getElementById("choix1").value;
		var data2 = document.getElementById("choix2").value;
		
		var xhttp;
		if (str == "") {
			document.getElementById("txtHint2").innerHTML = "";
			return;
		}
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("txtHint2").innerHTML = this.responseText;
				
			}
			document.getElementById("txtHint2").innerHTML = this.responseText;
			
			var firstChild = document.getElementById("txtHint2").firstElementChild;
			document.getElementById("txtHint2").removeChild(firstChild);
			nbreOptSel();
			echantillon();
		// 	console.log(data1);
		// console.log(data2);
			// document.getElementById("txtHint").style.display = "none";
		};
		// xhttp.open("GET", "done.php?data2=" + data2, true);
		// xhttp.send();
		xhttp.open("POST", "done.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("data1="+data1+"&data2="+data2);
		
	};
	/*=====  End of Fonction ajax  ======*/

	function nbreOptSel(){
		var selectElement = document.getElementById("choix2");
		// Obtenir le nombre d'options dans l'élément <select>
		var numberOfOptions = selectElement.options.length;
		var fondSel2 = document.getElementById("fondSel2");
		if (numberOfOptions == 1) {
			selectElement.style.display = 'none';
			fondSel2.classList.remove("sel2");
			fondSel2.style.display = 'none';
		}
		
	};
	function start(){
		document.getElementById("txtHint").style.display = "block";
	};
</script>
<script>
	function getInnerHTML() {
		// Sélectionnez tous les éléments avec la classe "elementWithHTML"
		var elements = document.querySelectorAll('.bigdata2');
		var elements2 = document.querySelectorAll('.spaceR');

		for (let i = 0; i < elements.length; i++) {
			console.log(elements[i].innerHTML);
			if (elements[i].innerHTML === 'nc %') {
				elements2[i].style.width = '0px';
				elements[i].innerHTML = 'nc';
			}
		}
	};
	// Sélectionner l'élément à ajuster
	var monElement = document.getElementById('monElement');
	// Définir la largeur de l'élément égale à la largeur de l'écran
	monElement.style.width = window.innerWidth + 'px';

	function echantillon(){
		var echantillon = document.getElementById('echantillon');
		if (echantillon.innerHtml == ' personnes interrogées') {
			echantillon.style.display = 'none';
		}
	}
</script>
<script src="js/accordeon.js"></script>

</html>