<?php
require '../classes/WebSiteController.php';
WebSiteController::requiredClasses('../');
$pdoQuery = new PdoExecuteQuery();
$data = array();
$color = array("#f56954","#00a65a", "#f39c12", "#00c0ef", "#3c8dbc", "#d2d6de", "#d2d6de", "#FFFF35", "#FF7835", "#35FF35", "#354BFF", "#FF35D2");
$mycolor = "#7300EF";

			$requete= 'SELECT count(*) AS value, abreviationService AS label
						FROM poser, acte, service
						WHERE poser.idActe = acte.idActe
						AND acte.idService = service.idService
                        AND DATE(poser.datePoser) between :deb AND :fin
						GROUP BY abreviationService ASC';

			$deb = date("Ymd");
			$fin = date("Ymd");
		
		if(isset($_GET['deb']) || isset($_GET['fin']) && (!empty($_GET['deb']) && !empty($_GET['fin']))){
			$deb = date($_GET['deb']);
			$fin = date($_GET['fin']);
			$param = array(
				'deb'=> $deb,
				'fin'=> $fin
			);
		}
		
		
		$resultat = $pdoQuery->executePdoSelectQueryTable($requete, $param);
		$nb = count($resultat);
		if($nb>0){
			for($i=0;$i<$nb; $i++){
				if (array_key_exists($i, $color)) {
						$mycolor = $color[$i];
				} else $mycolor ="#7300EF";
				$data[$i] = array(
					"value" =>(int)$resultat[$i]["value"],
					"color" =>$mycolor,
					"label" => $resultat[$i]["label"]
				);
			}
			echo json_encode($data);
		}
		else{
			$data = null;
			return json_encode($data);
		}
	
?>