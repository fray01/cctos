<?php
require '../classes/WebSiteController.php';
WebSiteController::requiredClasses('../');
$pdoQuery = new PdoExecuteQuery();
// if (isset($_POST['submit'])){
// 	var_dump($_POST);
// }

if(isset($_GET['go']) || isset($_GET['idService'])) {
 
		$numDossier = isset($_GET['detail']) ? (int)$_GET['detail']: '';
	$json = array();
// 	if (isset($_GET['detail']) && $_GET['detail']<>''){
		
	if(isset($_GET['go'])) {
		$requete = 'SELECT count(DISTINCT service.idService) as nbr
		FROM service, 
		acte, 
		poser, 
		patient 
		WHERE acte.idService = service.idService 
		AND patient.numDossier = '. $numDossier .' 
		AND poser.idActe <> acte.idActe 
		AND acte.idService is not null 
		ORDER BY service.idService DESC';
		
		$resultat = $pdoQuery->executePdoQuery($requete);
		foreach ($resultat as $data){
			$nbr = $data['nbr'];
		}
		if ($nbr != 0){
			$requete = 'SELECT service.* FROM service
				WHERE idService NOT IN(
				SELECT acte.idService FROM acte, poser
				WHERE acte.idActe = poser.idActe
				AND poser.numDossier = '. $numDossier .')
				AND service.nomService NOT IN("Direction","Accueil")
				AND service.idService IN (SELECT idService from acte)';
		}
		else {
			$requete = 'SELECT DISTINCT service.idService as idService, 
			service.nomService as nomService
			FROM service, acte
			WHERE acte.idService = service.idService
			AND service.nomService<>"Direction"';
		}
    }
    elseif(isset($_GET['idService']) AND $_GET['idService']<> "") {
        $id = htmlentities(intval($_GET['idService']));
        $requete = 'SELECT acte.idActe AS idService, 
        		acte.designationActe AS nomService 
        		FROM acte
        		WHERE acte.idService = '. $id;
    }
// }
    
    $resultat = $pdoQuery->executePdoQuery($requete);
    
     
    // résultats
    	foreach($resultat as $donnees) {
	        $json[$donnees['idService']][] = $donnees['nomService'];
	    }
    // envoi du résultat au success
    echo json_encode($json);
}
?>