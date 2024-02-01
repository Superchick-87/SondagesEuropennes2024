<?php
include (dirname(__FILE__).'/includes/functions.php');

$dataB=$_POST['data1'];
$data2=$_POST['data2'];
$data3=$_POST['data3'];

// chemin d'accès à votre fichier JSON
$file = 'https://raw.githubusercontent.com/nsppolls/nsppolls/master/presidentielle.json'; 
// mettre le contenu du fichier dans une variable
$data = file_get_contents($file); 
// décoder le flux JSON
// $obj = json_decode($data); 
// accéder à l'élément approprié
				// setlocale(LC_TIME, 'fr_FR');
				setlocale(LC_TIME, "fr_FR.UTF-8");
				date_default_timezone_set('Europe/Paris');
$obj = json_decode($data, true);
// accéder à l'élément approprié
$retour = usort($obj, function($a, $b) {
			return $a["fin_enquete"] > $b["fin_enquete"] ? -1 : 1;
		});

foreach ($obj as $transaction_main) {
	$cart[] = array($transaction_main["nom_institut"]);
}
	foreach ($obj as $value) {
		foreach ($value['tours'] as $toto) {
			if (($toto['tour'] == $dataB) && (strftime('%d %b %g',strtotime($value['fin_enquete'])).' | '.$value['commanditaire'].' | '.$value['nom_institut'] == $data2)) {
				echo '<h3>Si le '.strtolower($dataB).' de l’élection présidentielle avait lieu dimanche prochain pour lequel des candidats suivants y aurait-il le plus de chances que vous votiez ?</h3>';
				if ($value['commanditaire'] == '') {
					echo '<p class="grey"><i>Sondage '.$value['nom_institut'].' réalisé entre le '.strftime('%A %e %B',strtotime($value['debut_enquete'])).' et le '.strftime('%A %e %B %Y',strtotime($value['fin_enquete'])).' auprès d\'un échantillon de '.number_format($value['echantillon'], 0, ',', ' ').' personnes.</i></p>';
				}
				else{
					echo '<p class="grey"><i>Sondage '.$value['nom_institut'].' réalisé pour '.$value['commanditaire'].' entre le '.strftime('%A %e %B',strtotime($value['debut_enquete'])).' et le '.strftime('%A %e %B %Y',strtotime($value['fin_enquete'])).' auprès d\'un échantillon de '.number_format($value['echantillon'], 0, ',', ' ').' personnes.</i></p>';
				}
				echo '<p class="grey"><i>- Consulter <a href=" '.$value['lien'].'" target="_blank"> la notice</a> -</i></p>';
				foreach ($toto['hypotheses'] as $hypos) {
					if ($hypos['hypothese'] == $data3) {
						echo '<h2>'.$hypos['hypothese'].'</h2>';
						echo '<p>Sous échantillon : '.$hypos['sous_echantillon'].'</p><br>';
						$atrier = [];
						for($i=0;$i<count($hypos['candidats']);$i++) {
							$atrier[] = $hypos['candidats'][$i];
						}
						
						$toto = usort($atrier, function($c, $d) {
							return $c["intentions"] > $d["intentions"] ? -1 : 1;
						});
						echo "<div class ='flex'>";
							foreach ($atrier as $cands) {
								$n = 0;
								echo '
								<div class="spaceH" data-aos="zoom-in" data-aos-duration="500">
									<img src="images/'.ddc($cands['candidat']).'.jpeg" alt="'.$cands['candidat'].'">
									<h4 id="'.$cands['intentions'].'" class="font1">'.$cands['candidat'].'</h4>
									<p class="bigdata bleu">'.$cands['intentions'].'%</p>
									<p class="lengend">- '.$cands['parti'][$n++].' -</p>
									<div style="width:300px; height:40px;">
										<span style="width:20%; background-color:red;"></span>
										<span style="background-color:orange;"></span>
									</div>
									<div class="graph">
										<span class="font2 bleu transp2"" style="position:absolute; left:0px; top:41px; text-align:right; width:'.($cands['erreur_inf']).'%;">'.round($cands['erreur_inf'],2).'%</span>
										<span class="bleuFd transp" style=" position:absolute; left:'.($cands['erreur_inf']).'%; width : '.($cands['erreur_sup']-$cands['erreur_inf']).'%; height:inherit;"></span>
										
										<span class="bleuFd" style="position:absolute; left:'.($cands['intentions']-0.2).'%; top:-30px; width:2px; height:70px;"></span>
										
										<span class="font2 bleu transp2" style="position:absolute; left:'.(($cands['erreur_inf'])+($cands['erreur_sup'] - $cands['erreur_inf'])).'%; top:-22px; text-align:right;">'.round($cands['erreur_sup'],2).'%</span>
										
									</div>
								</div>';
							}
						echo "</div>";
						// <span class="font2 bleu" style="position:absolute; left:'.$cands['erreur_inf'].'%; width : '.($cands['erreur_sup']-$cands['erreur_inf']).'%; top:-52px; height:70px; text-align:center;">'.round($cands['intentions'],2).'%</span>
					}
				}
			}
		}
	}
?>