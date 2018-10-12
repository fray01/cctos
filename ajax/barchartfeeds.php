<?php
require '../classes/WebSiteController.php';
WebSiteController::requiredClasses('../');
$pdoQuery = new PdoExecuteQuery();
$resultat = array();
$color = array();
if (isset($_GET['q'])) {
	$query= 'SELECT count(numDossier) as resultat FROM patient';
	$pdoStatement = $pdoQuery->executePdoQuery($query);
	foreach ($pdoStatement as $data){
		$resultat['resultat'] = $data['resultat'];
	}
	if ($resultat['resultat']<>0) {
		$requete= 'SELECT 
			type_patient.idTypePatient as id, 
			type_patient.designationTP as label,
			(SELECT COUNT(patient.numDossier) FROM patient WHERE patient.idTypePatient = id) as value
			FROM type_patient, patient
			GROUP BY id, label, value';
		$pdoStatement = $pdoQuery->executePdoQuery($requete);
		foreach ($pdoStatement as $row) {
			$total = $row;
			$resultat['data'][] = (int)$row['value'];
			$resultat['label'][] = $row['label'];
		}
		$total = count($resultat);
		if($total>0){
			for($i=0; $i<$total; $i++){
				$color[$i] ="#00c30b";
				$mycolor = $color[$i];
				$data = [
					'labels'=> $resultat['label'],
					'datasets' =>array([
						'fillColor'=>'rgba(210, 214, 222, 1)',
						'strokeColor'=>'rgba(210, 214, 222, 1)',
						'pointColor'=>'rgba(210, 214, 222, 1)',
						'data' => $resultat['data']
					])
				];
			}
		}
		echo json_encode($data);
	}
	else {
		$data = null;
		return json_encode($data);
	}
}
?>