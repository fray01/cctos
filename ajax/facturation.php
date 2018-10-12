<?php
require '../classes/WebSiteController.php';
WebSiteController::requiredClasses('../');
$pdoQuery = new PdoExecuteQuery();

	$json = array();
	if (isset($_GET['idService']) AND $_GET['idService']<> ""){
		$id = htmlentities(intval($_GET['idService']));
		$query = 'SELECT nomService from SERVICE WHERE idService =:idService';
		$service = $pdoQuery->executePdoSelectQueryTable($query,array('idService'=> $id));
		//var_dump($service[0]['nomService']);
		if (isset($_GET['idActe']) AND $_GET['idActe'] <> ''){
			$idActe = htmlentities(intval($_GET['idActe']));
			$numDossier = htmlentities(intval($_GET['detail']));
			if ($service[0]['nomService'] =='Consultation'){
				$requete = 'SELECT 
				idActe,
				designationActe,
				reductionSoin,
				reductionConsultation,
				((valeurActe*tarifNormal) - (reductionConsultation*valeurActe*tarifNormal)/100) AS facturation 
				FROM acte, tarif , service, type_patient, patient
				WHERE service.idService ='. $id .' 
				AND acte.idActe ='. $idActe .'
				AND patient.numDossier = '. $numDossier .'
				AND service.idService = acte.idService
				AND tarif.idTarif = acte.idTarif
				AND patient.idTypePatient = type_patient.idTypePatient';
			}
			else{
				$requete = 'SELECT 
					idActe,
					designationActe,
					reductionSoin, 
					((valeurActe*tarifNormal) - (reductionSoin*valeurActe*tarifNormal)/100) AS facturation 
					FROM acte, tarif , service, type_patient, patient
					WHERE service.idService ='. $id .' 
					AND acte.idActe ='. $idActe .'
					AND patient.numDossier = '. $numDossier .'
					AND service.idService = acte.idService
					AND tarif.idTarif = acte.idTarif
					AND patient.idTypePatient = type_patient.idTypePatient';
				}
			}
			else {
				$requete = 'SELECT acte.idActe as idService,
				acte.designationActe as nomService
				FROM acte,poser
				WHERE acte.idService = '. $id;
			}
		$resultat = $pdoQuery->executePdoQuery($requete);
		if(count($resultat)>0){
			foreach($resultat as $data){
				$json[]  = (int)$data['facturation'];
			}
		}
		else $json[] = 0;
	}
		echo json_encode($json);
?>