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
  	setlocale(LC_TIME, "fr_FR.UTF-8");
	date_default_timezone_set('Europe/Paris');
	// $date = date("d-m-Y");
	// $heure = date("H:i");
	// Print("Nous sommes le $date et il est $heure");
	// date_default_timezone_set('UTC');
	// setlocale(LC_TIME, "fr_FR.UTF-8");

  	$file = 'https://raw.githubusercontent.com/nsppolls/nsppolls/master/presidentielle.json'; 
  	$data = file_get_contents($file); 
	// $obj = json_decode($data);

// /--------------------------------/	
	// $data = file_get_contents($file); 
	$obj = json_decode($data, true);
	$retour = usort($obj, function($a, $b) {
   		return $a["fin_enquete"] > $b["fin_enquete"] ? -1 : 1;
 	});
	// print_r($obj);
// /--------------------------------/

  ?>

<body>

	<h1>Présidentielle 2022, tous les sondages</h1>
	<br>
	<form action="">
		<select class="box" id="choix1" name="choix1" onchange="showCustomer(this.value);">
		    <?php
		    	/**
		    	 * Objectif : mettre dans l'ordre alphabétique la liste des clubs issue du xml
		    	 * [1] on crée un tableau et on remplit en récupèrant la liste dans le désordre
		    	 * [2] on crée un objet via "ArrayObject()" avec le tableau [1] en paramètre
		    	 *  et on supprime les doublons du tableau avec array_unique
		    	 */
		    	
		    	/*----------  [1]  ----------*/
		    	
		    	$menuDeroulant1 = array();
				$i=0;
				foreach ($obj as $value) {
					foreach ($value['tours'] as $toto) {
						$menuDeroulant1[] = $toto['tour'];
					}
				}
				
				/*----------  [2]  ----------*/
				
				$menuDeroulant1ArrayObject = new ArrayObject(array_unique($menuDeroulant1));
				foreach ($menuDeroulant1ArrayObject as $val) {
					echo '<option value="'.$val.'" id="tour'.$i++.'">'.$val.'</option>';
				}
							
			?>
		</select>
		<select class="box" id="choix2" name="choix2" onchange="showCustomer2(this.value);">
		</select>
		<select class="box" id="choix3" name="choix3"  onchange="showCustomer3(this.value);">
		</select>
	</form>
    <!-- <h3 style="width: 80%;">À quelques mois présidentielle, qui se tiendra le dimanche 10 avril pour le premier tour et le 24 avril pour le deuxième, explorez l'intégralité des sondages et les tendances de chaque candidat.</h3>
    <br> -->
    <!-- <section id="solutions" style="display: block;"> -->
		<div class="accordion">Comment lire les résultats des sondages</div>
		<div class="panel">
			<div class="sources">
				<div>
					<div class="blocparagraphe spaceH2">
						<!-- <p>Comment lire les résultats des sondages</p> -->
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
	<!-- </section> -->
    <div id="txtHint" style="display: block;" ></div>
   	<br>
   	<hr>
   	<div class="blocparagraphe">
	   	<br>
	   	<h5>Source et méthodologie</h5>
		<p class="grey">Les données ont été agrégées par <a href="https://github.com/nsppolls/nsppolls" target="_blank">Nsppolls</a>.
			<br><br>Sont rassemblés les sondages ayant trait à l'élection  présidentielle demandant des intentions de vote, soit les sondages répondant à la question « Si le premier tour avait lieu dimanche, pour qui voteriez-vous ? », ou approchant. Ne sont pas compilés les souhaits de victoire, les chances de l'emporter ou les prédictions.
		</p>
	</div>
    <footer></footer>
</body>

<script type="text/javascript">

	window.onload = showCustomer();
	window.onload = showCustomer2();
	window.onload = showCustomer3();

   
   	document.getElementById("choix1").addEventListener("onchange", showCustomer);
   	document.getElementById("choix2").addEventListener("onchange", showCustomer2);
   	document.getElementById("choix3").addEventListener("onchange", showCustomer3);

	var data1 = document.getElementById('choix1').value;
	var data2 = document.getElementById('choix2').value;
	var data3 = document.getElementById('choix3').value;

/*=====================================
=            Fonction ajax            =
=====================================*/
function showCustomer(str) {
 	var data1 = document.getElementById("choix1").value;
	var xhttp;
	if (str == "") {
      	document.getElementById("choix2").innerHTML = "";
      	return;
    }	      	
	xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
	    	document.getElementById("choix3").style.display = "block";
	    	document.getElementById("choix3").innerHTML = "<option>Sélectionnez une hypothèse</option>";
	    	document.getElementById("txtHint").innerHTML = "";
	    	document.getElementById("choix2").innerHTML = this.responseText;
      	}
	};
  	/* Methode GET -> passe une seule variable */
  	/* Methode POST -> passe plusieurs variables */
  	// xhttp.open("GET", "getuser.php?Ville="+choixRencontre,true);
  	// xhttp.send();
  	xhttp.open("POST", "menu1.php", true);
  	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xhttp.send("data1="+data1);
};

function showCustomer2(str) {
    var data1 = document.getElementById('choix1').value;
	var data2 = document.getElementById('choix2').value;
	var data3 = document.getElementById('choix3').value;
	var xhttp;
	console.log(data2);
	if (str == "Sélectionner un sondage") {
      document.getElementById("choix3").style.display = "block";
      return;
    }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
	    	document.getElementById("txtHint").style.display = "none";
	    	document.getElementById("choix3").style.display = "block";
	    	document.getElementById("choix3").innerHTML = this.responseText;
	    	// document.getElementById("message").innerHTML = 'Sondage ' +data2.slice(0, 6);
      	}
	};
	xhttp.open("POST", "menu2.php", true);
  	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xhttp.send("data1="+data1+"&data2="+data2);
};
	
function showCustomer3(str) {
    var data1 = document.getElementById('choix1').value;
	var data2 = document.getElementById('choix2').value;
	var data3 = document.getElementById('choix3').value;
	
	var xhttp;

    if (str == "Sélectionner une hypothèse") {
      document.getElementById("txtHint").style.display = "none";
		return;
    }

    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
    		document.getElementById("txtHint").style.display = "block";
	    	document.getElementById("txtHint").innerHTML = this.responseText;
      	}
    };

  	xhttp.open("POST", "done.php", true);
  	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xhttp.send("data1="+data1+"&data2="+data2+"&data3="+data3);
};	
/*=====  End of Fonction ajax  ======*/

</script>
<script src="js/aos.js"></script>
<script>
    AOS.init({
    easing: 'ease-in-out-sine'
    });
</script>
<script src="js/accordeon.js"></script>
</html> 