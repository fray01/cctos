<?php
class diagnosticManager
{

		CONST SQL_SELECT_ALL_ACTE = 'SELECT * FROM acte WHERE designationActe<>"Consultation"';
	CONST SQL_ADD_DIAGNOSTIC = 'INSERT INTO 
			resultat (numDentResultat, idPoser, idActe, numDossier)
			VALUES (:numDentResultat, :idPoser, :idActe, :numDossier)';
		CONST SQL_SELECT_DIAGNOSTIC_BY_POSER = 'SELECT resultat.*, acte.designationActe, service.nomService FROM resultat, acte, service
			WHERE resultat.idPoser = :idPoser
			AND acte.idActe = resultat.idActe
			AND acte.idService = service.idService';
		
		CONST SQL_SELECT_DIAGNOSTIC_BY_RESULTAT = 'SELECT distinct resultat.*, designationActe, nomService
			FROM resultat, poser, acte, service
			WHERE poser.idActe = resultat.idActe
			AND resultat.idPoser = :idPoser
			AND resultat.idActe = acte.idActe
			AND acte.idService = service.idService ';
		CONST SQL_SELECT_DIAGNOSTIC_BY_ACTE = 'SELECT distinct resultat.*, acte.designationActe, nomService
			FROM resultat, poser, acte, service
			WHERE poser.idActe = resultat.idActe
			AND resultat.idActe = acte.idActe
			AND acte.idService = service.idService
			AND resultat.numDossier = :numDossier
			AND poser.idPoser = :idPoser';
		
		CONST SQL_UPDATE_DIAGNOSTIC = 'UPDATE resultat 
			SET numDentResultat = :numDentResultat,
			idActe = :idActe
			WHERE idResultat = :idResultat';

		CONST SQL_UPDATE_ETAT_DIAGNOSTIC = 'UPDATE resultat 
			SET etatDiagnostic = :etatDiagnostic
			WHERE idResultat = :idResultat ';
		CONST SQL_SELECT_ALL_DIAGNOSTIC_BY_ID = 'SELECT * FROM resultat
			WHERE resultat.idResultat = :idResultat';
	
CONST SQL_SELECT_ALL_FIELDS_BY_ID = 'SELECT distinct resultat.*, acte.*
	FROM resultat, acte, service, poser
	WHERE service.idService = acte.idService
	AND service.idService = :idService
	AND resultat.idActe = acte.idActe
	AND resultat.idPoser = poser.idPoser
	AND poser.numDossier = :numDossier';
	
CONST SQL_SELECT_ALL_FIELDS_BY_RESULTAT = 'SELECT distinct resultat.*, acte.*
	FROM resultat, acte, service
	WHERE resultat.idActe = acte.idActe
	AND resultat.idResultat = :idResultat';
/*SELECT distinct resultat.*, acte.*
FROM resultat, acte, service, poser
WHERE service.idService = acte.idService
AND service.idService = 2
AND resultat.operationDent = acte.designationActe
AND resultat.idPoser = poser.idPoser
AND poser.numDossier = 1*/

	public $pdoQuery;
	public $data;
	public $error;
	private $pdoStatement;
	
	public function __construct()
	{
		$this->pdoQuery = new PdoExecuteQuery();
		$this->error = new ErrorsManager();
		
	}
	
	private function isFormSubmit($formname){
		return (isset($_POST['formname']) && ($_POST['formname'])==$formname);
	}
	public function optionActe($idActe)
	{
		$option= '';
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_ALL_ACTE);
		if ($this->pdoStatement){
			foreach ($this->pdoStatement as $data){
				if ($data['idActe']== $idActe) {
					$option .= '<option data="'. $data['idActe'] .'" value="' . $data['idActe'] . '" selected/>' . $data['designationActe'] . '</option>';
				}
				else $option .= '<option data="'. $data['idActe'] .'" value="' . $data['idActe'] . '">' . $data['designationActe'] . '</option>';
			}
		}
		else $option .= '<option value="" > -----------Aucun acte -------------</option>';
		return $option;
	}
		
	public function addDiagnostic($numDossier)
	{
		$patient = new PatientManager();
		if ($this->isFormSubmit('addDiagnostic')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['submit']);
			$formValidation->setDataFilter(array(
				'numDentResultat' => FILTER_VALIDATE_INT,
				'idPoser' => FILTER_VALIDATE_INT,
				'idActe' => FILTER_VALIDATE_INT,
				'numDossier' => FILTER_VALIDATE_INT,
				));
			$data = array(
				'numDentResultat' => (int)$_POST['numDentResultat'],
				'idPoser' => (int)$_POST['idPoser'],
				'idActe' => $_POST['idActe'],
				'numDossier' => $numDossier,
			);
			$data = $formValidation->getFilteredData($data);
			$bool = $this->pdoQuery->executePdoQuery(self::SQL_ADD_DIAGNOSTIC, $data);
			$bool = $patient->isSafe($data['idPoser']);
		//	var_dump($bool);
			return $this->error->isErrorMsg($bool, 'Diagnostic');
		}
		else return $this->error->isErrorMsg(false, 'Diagnostic');;
	}	
	public function updateDiagnostic()
	{
		if ($this->isFormSubmit('updateDiagnostic')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['update']);
			$formValidation->setDataFilter(array(
					'numDentResultat' => FILTER_VALIDATE_INT,
					'idActe' => FILTER_VALIDATE_INT,
					'idResultat' => FILTER_VALIDATE_INT,
			));
			$data = array(
					'numDentResultat' => (int)$_POST['numDentResultat'],
					'idActe' => (int)$_POST['idActe'],
					'idResultat' => (int)$_POST['idResultat'],
			);
			$data = $formValidation->getFilteredData($data);
			$bool = $this->pdoQuery->executePdoQuery(self::SQL_UPDATE_DIAGNOSTIC, $data);
			return $this->error->isErrorMsg($bool, 'Modification Diagnostic');
		}
		else return $this->error->isErrorMsg(false, 'Modification Diagnostic');
	}

	public function confirmDiagnostic($idResultat, $etatDiagnostic=1)
	{
		$patient = new PatientManager();
		if (isset($_GET['detail']) && isset($_GET['acte']) && isset($_GET['id']) && isset($_GET['m']) ) {
			$data = array(
				'etatDiagnostic' => $etatDiagnostic,
				'idResultat' => $idResultat,
			);
			$this->pdoQuery->executePdoQuery(self::SQL_UPDATE_ETAT_DIAGNOSTIC, $data);
			$bool = $patient->isSafe($_GET['id']);
			//var_dump($bool);
			return $this->error->isErrorMsg($bool, 'Confirmation Diagnostic');
		}
		else return $this->error->isErrorMsg(false, 'Confirmation Diagnostic');
	}
		public function getDiagnosticById($id)
	{
		$result = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_ALL_DIAGNOSTIC_BY_ID, 
		array(
				'idResultat' => (int)$id
			));
		if (!empty($result)) {
			return $result;
		}
		else{
			return;
		}
	}
	
	public function displayDiagnostic($idPoser, $etatDiagnostic)
	{
		$content='';
		$params = array(
				'idPoser' => (int)$idPoser,
		);
		if ($etatDiagnostic <> ""){
			if ($etatDiagnostic==1){
				$query =self::SQL_SELECT_DIAGNOSTIC_BY_ACTE;
				$params = array(
					'idPoser' =>(int)$idPoser,
					'numDossier' => (int)$_GET['detail'],
					);
			}
			else{
				$query = self::SQL_SELECT_DIAGNOSTIC_BY_RESULTAT;
				$params = array(
					'idPoser' =>(int)$idPoser,
					);
			}
		}
		else $query = self::SQL_SELECT_DIAGNOSTIC_BY_POSER;
		$result = $this->pdoQuery->executePdoSelectQueryTable($query , $params);
		if ($result) {
			$content .= '<table id="filtredTable" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>N°Dent</th>
						<th>Acte à poser</th>';
						if($_SESSION['nomService']=="Consultation" && ($_SESSION['nomService']<>"Accueil" && $_SESSION['nomService']<>"Direction")){
							$content.='<th>Opération</th></tr>';
						}
						else if($_SESSION['nomService']<>"Consultation" && ($_SESSION['nomService']<>"Accueil" && $_SESSION['nomService']<>"Direction") ){
							$content.='<th>Opération</th><th>Etat diagnostic</th></tr>';
						}
						elseif ($_SESSION['nomService']=="Accueil" || $_SESSION['nomService']=='Direction'){
							$content.='<th>Service</th></tr>';
						}
							else $content.='</tr>';
					
				$content.='</thead>
				<tbody>';
				foreach ($result as $data){
					if ($data['etatDiagnostic'] ==1) {
						$etat = '<a class="btn btn-info btn-sm">Diagnostic effectué</a>';
						$operation = '';
					}
					else {
						$etat = '<a class="btn btn-warning btn-sm">En attende de confirmation</a>';
						$operation = '<a href="./index.php?p=diagnostic&detail='.$data['numDossier'].'&id='.$_GET['id'].'&acte='. $data['idActe'].'&m='.$_GET['m'].'&resultat='.$data['idResultat'].'"><span class="label label-success">Confirmer</span></a>';
					}
					$content.= '<tr>'.
							'<td>' . $data['numDentResultat'] . '</td>'.
							'<td>' . $data['designationActe'] . '</td>';
							if($_SESSION['nomService']=="Consultation" && ($_SESSION['nomService']<>"Accueil" && $_SESSION['nomService']<>"Direction")){
								$content.='<td><a href="./index.php?p=diagnostic&detail='.$data['numDossier'].'&id='.$_GET['id'].'&acte='. $data['idActe'].'&m='.$_GET['m'].'&idResultat='.$data['idResultat'].'"><span class="label label-success">modifier</span></a></td></tr>';
							}
							else if($_SESSION['nomService']<>"Consultation" && ($_SESSION['nomService']<>"Accueil" && $_SESSION['nomService']<>"Direction") ){
								$content.='<td>'.$operation.'</td>';
								$content.= '<td>'. $etat .'</td></tr>';
							}
							else if($_SESSION['nomService']=="Accueil" || $_SESSION['nomService']=='Direction'){
								$content.= '<td>'. $data['nomService'] .'</td></tr>';
							}
							else $content.='</tr>';
				}
				$content .='
					</tbody>
						<tfoot>
							<tr>
							<th>N°Dent</th>
							<th>Acte à poser</th>';
								if($_SESSION['nomService']=="Consultation" && ($_SESSION['nomService']<>"Accueil" && $_SESSION['nomService']<>"Direction")){
							$content.='<th>Opération</th></tr>';
						}
						else if($_SESSION['nomService']<>"Consultation" && ($_SESSION['nomService']<>"Accueil" && $_SESSION['nomService']<>"Direction") ){
							$content.='<th>Opération</th><th>Etat diagnostic</th></tr>';
						}
						else if($_SESSION['nomService']=="Accueil" || $_SESSION['nomService']=='Direction' ){
							$content.='<th>Service</th></tr>';
						}
						else $content.='</tr>';
						$content.='</tfoot></table>';
			}
			else $content.='<div class="alert alert-info alert-dismissable"><i class="icon fa fa-info-circle"></i>Ce patient ne dispose d aucun diagnostic medical </div>';
			
			return $content;
	}
	public function optionDent($numDent)
	{
		$option = '';
		for ($i=1; $i<=4; $i++){
			for ($j=1; $j<=8; $j++){
				if (($i.$j)==$numDent) {
					$option .= '<option value="'. $i.$j .'" selected>' . "$i$j ". '</option>';
				}
				else
					$option .= '<option value="'. $i.$j .'">' . "$i$j ". '</option>';
			}
		}
		return $option;
	}
	
	public function readDiagnostic($idResultat)
	{
		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_ALL_FIELDS_BY_RESULTAT,
			array(
				'idResultat' => $idResultat,
			));
		foreach ($this->pdoStatement as $data){
			return $data;
		}
	}
	public function optionActeService($idService, $idActe)
	{
		$option= '';
		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_ALL_FIELDS_BY_ID, array(
			'idService' => $idService,
			'numDossier' =>$_GET['patient'],
		));
		if ($this->pdoStatement){
			foreach ($this->pdoStatement as $data){
				if ($data['idActe']== $libelleActe) {
					$option .= '<option data="'. $data['idActe'] .'" value="' . $data['idActe'] . '" selected/>' . $data['designationActe'] . '</option>';
				}
				else $option .= '<option data="'. $data['idActe'] .'" value="' . $data['idActe'] . '">' . $data['designationActe'] . '</option>';
			}
		}
		else $option .= '<option value="" > ----------- Aucun acte -------------</option>';
		return $option;
	}
	public function optionDentService($idService, $libelleActe)
	{
		$option= '';
		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_ALL_FIELDS_BY_ID, array(
			'idService' => $idService,
			'numDossier' =>$_GET['patient'],
		));
		if ($this->pdoStatement){
			foreach ($this->pdoStatement as $data){
				if ($data['designationActe']== $libelleActe) {
					$option .= '<option data="'. $data['idActe'] .'" value="' . $data['numDentResultat'] . '" selected/>' . $data['numDentResultat'] . '</option>';
				}
				else $option .= '<option data="'. $data['idActe'] .'" value="' . $data['numDentResultat'] . '">' . $data['numDentResultat'] . '</option>';
			}
		}
		else $option .= '<option value="" > -----------Aucune dent ------------- </option>';
		return $option;
	}
		
	/****************End************/
	
}
?>