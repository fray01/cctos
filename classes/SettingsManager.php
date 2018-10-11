<?php
class SettingsManager
{

	CONST SQL_SELECT_ALL_TARIFICATION_BY_ID = 'SELECT * FROM tarif 
			WHERE idTarif = :idTarif';
	
	CONST SQL_SELECT_ALL_ACTE_BY_ID = 'SELECT * FROM acte
			WHERE idActe = :idActe';
	
	CONST SQL_ADD_ACTE = 'INSERT INTO acte(
			designationActe, 
			valeurActe, 
			idTarif, 
			idService
			)
			VALUES(
			:designationActe, 
			:valeurActe, 
			:idTarif, 
			:idService)';
	
	CONST SQL_UPDATE_ACTE = 'UPDATE acte SET
			designationActe = :designationActe , 
			valeurActe = :valeurActe, 
			idTarif = :idTarif, 
			idService = :idService
			WHERE idActe = :idActe';
	
	CONST SQL_ADD_TARIF = 'INSERT INTO tarif(
			codificationTarif, 
			tarifNormal, 
			tarifSocial
			)
			VALUES(
			:codificationTarif, 
			:tarifNormal, 
			:tarifSocial
			)';
	CONST SQL_UPDATE_TARIF = 'UPDATE tarif SET
			codificationTarif = :codificationTarif, 
			tarifNormal = :tarifNormal, 
			tarifSocial = :tarifSocial
			WHERE idTarif = :idTarif';
	
	CONST SQL_SELECT_ALL_ACTE = 'SELECT tarif.*, acte.*, service.*
			FROM tarif, acte, service
			WHERE tarif.idTarif = acte.idTarif
			AND acte.idService = service.idService';
	CONST SQL_SELECT_COUNT_ALL_ACTE = 'SELECT count(tarif.idTarif) as resultat
			FROM tarif, acte, service
			WHERE tarif.idTarif = acte.idTarif
			AND acte.idService = service.idService';
	
	
	CONST SQL_SELECT_TARIFICATION = 'SELECT * FROM tarif';
	
	CONST SQL_SELECT_COUNT_ALL_TARIFICATION = 'SELECT COUNT(*) as resultat FROM tarif';
	
	CONST SQL_COMPTER_SERVICE = 'SELECT count(*) AS nbre FROM service';
	
	CONST SQL_COMPTER_PERSONNEL = 'SELECT count(*) AS nbre FROM personnel';
	
	CONST SQL_COMPTER_POSER = 'SELECT count(*) AS nbre FROM poser';
	
	CONST SQL_COMPTER_PATIENT = 'SELECT count(*) AS nbre FROM patient';
	
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
	
	public function isFormAdd()
	{
		if ($this->isFormSubmit('addActe')){
			$bool = $this->addActe();
		}
		elseif ($this->isFormSubmit('addTarification') || $this->isFormSubmit('addTarification')){
			$bool = $this->addTarification();
		}
			return $this->error->isErrorMsg($bool, 'Enregistrement');
	}
	
	public function isFormUpdate()
	{
		if ($this->isFormSubmit('updateActe') || $this->isFormSubmit('updateActe')){
			$bool = $this->updateActe();
		}
		elseif ($this->isFormSubmit('updateTarification') || $this->isFormSubmit('updateTarification')){
			$bool = $this->updateTarification();
		}
		//else return;
		return $this->error->isErrorMsg($bool, 'Modification');
	}
	
	private function addActe()
	{
		$formValidation = new FormFieldValidation();
		unset($_POST['formname']);
		unset($_POST['submit']);
		$formValidation->setDataFilter(array(
			'designationActe' => FILTER_UNSAFE_RAW,
			'valeurActe' => FILTER_SANITIZE_NUMBER_INT,
			'idTarif' => FILTER_SANITIZE_NUMBER_INT,
			'idService' => FILTER_SANITIZE_NUMBER_INT
		));
		$data = array(
			'designationActe' => (string)strip_tags(ucwords(($_POST['designation']))), 
			'valeurActe' => (int)($_POST['valeur']), 
			'idTarif' => (int)($_POST['codification']), 
			'idService' => (int)($_POST['service'])
		);
	
		$data = $formValidation->getFilteredData($data);
		return $this->pdoQuery->executePdoQuery(self::SQL_ADD_ACTE, $data);
	}
	
	private function updateActe()
	{
// 		if ($this->isFormSubmit('updateActe') || $this->isFormSubmit('updatedActe')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['update']);
			$formValidation->setDataFilter(array(
				'idActe' => FILTER_SANITIZE_NUMBER_INT,
				'designationActe' => FILTER_UNSAFE_RAW,
				'valeurActe' => FILTER_SANITIZE_NUMBER_INT,
				'idTarif' => FILTER_SANITIZE_NUMBER_INT,
				'idService' => FILTER_SANITIZE_NUMBER_INT
			));
			$data = array(
				'idActe' => (int)($_POST['idActe']),
				'designationActe' => (string)strip_tags(ucwords($_POST['designation'])), 
				'valeurActe' => (int)($_POST['valeur']), 
				'idTarif' => (int)($_POST['codification']), 
				'idService' => (int)($_POST['service'])
			);

			$data = $formValidation->getFilteredData($data);
			//var_dump($data);
			return $this->pdoQuery->executePdoQuery(self::SQL_UPDATE_ACTE, $data);
// 		}
// 		else return;
	}

	
	public function displayActe()
	{
		$content='';
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_COUNT_ALL_ACTE);
		foreach ($this->pdoStatement as $data){
			$resultat = $data['resultat'];
		}
		if($resultat<>0){
			$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_ALL_ACTE);
			$content .= '<div class="box-body">
			<table id="filtredTable" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Désignation</th>
						<th>Code</th>
						<th>Tarif Normal</th>
						<th>Tarif Social</th>
						<th>Service</th>
						<th>Opérations</th>
					</tr>
				</thead>
				<tbody>';
			if ($this->pdoStatement) {
				foreach ($this->pdoStatement as $data){
					$content.= '<tr>'.
							'<td>' . $data['designationActe'] . '</td>'.
							'<td>' . $data['valeurActe'] . '</td>'.
							'<td>' . $data['tarifNormal']*$data['valeurActe']. '</td>'.
							'<td>' . $data['tarifSocial']*$data['valeurActe'] . '</td>'.
							'<td>' . $data['nomService'] . '</td>'.
							'<td><a href="./index.php?p=tarif&id='. $data['idActe'] .'"><span class="label label-success">Modifier</span></a>
		 					</td>'.
		 				'</tr>';
				}
			}
			$content .='
				</tbody>
					<tfoot>
						<tr>
							<th>Désignation</th>
							<th>Code</th>
							<th>Tarif Normal</th>
							<th>Tarif Social</th>
							<th>Service</th>
							<th>Opérations</th>
						</tr>
					</tfoot>
				</table></div>';
		}
		else {
			$content .='<div class="alert alert-info alert-dismissable"><i class="icon fa fa-info-circle"></i> Aucune liste disponible</div>';
		}
		return $content;
	}
	
	public function readActe($idActe)
	{
		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_ALL_ACTE_BY_ID,
			array(
				'idActe' => $idActe,
			));
		foreach ($this->pdoStatement as $data){
			return $data;
		}
	}
		
	private function addTarification()
	{
// 		if ($this->isFormSubmit('addTarification') || $this->isFormSubmit('addTarification')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['submit']);
			$formValidation->setDataFilter(array(
				'codificationTarif' => FILTER_SANITIZE_STRING,
				'tarifNormal' => FILTER_SANITIZE_NUMBER_INT,
				'tarifSocial' => FILTER_SANITIZE_NUMBER_INT,
			));
			$data = array(
				'codificationTarif' => strtoupper($_POST['codification']),
				'tarifNormal' => (int)($_POST['normal']),
				'tarifSocial' => (int)($_POST['social'])
				);

			$data = $formValidation->getFilteredData($data);
			return $this->pdoQuery->executePdoQuery(self::SQL_ADD_TARIF, $data);

	}
	
	private function updateTarification()
	{
// 		if ($this->isFormSubmit('updateTarification') || $this->isFormSubmit('updateTarification')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['update']);
			$formValidation->setDataFilter(array(
				'idTarif' => FILTER_SANITIZE_NUMBER_INT,
				'codificationTarif' => FILTER_SANITIZE_STRING,
				'tarifNormal' => FILTER_SANITIZE_NUMBER_INT,
				'tarifSocial' => FILTER_SANITIZE_NUMBER_INT,
			));
			$data = array(
				'idTarif' => (int)($_POST['idTarif']),
				'codificationTarif' => strtoupper($_POST['codification']),
				'tarifNormal' => (int)($_POST['normal']),
				'tarifSocial' => (int)($_POST['social'])
			);
	
			$data = $formValidation->getFilteredData($data);
		//	var_dump($data);
			return $this->pdoQuery->executePdoQuery(self::SQL_UPDATE_TARIF, $data);
// 		}
// 		else return;
	}
	public function displayTarification()
	{
		$content='';
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_COUNT_ALL_TARIFICATION);
		foreach ($this->pdoStatement as $data){
			$resultat = $data['resultat'];
		}
		if($resultat<>0){
			$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_TARIFICATION);
			$content .= '<div class="box-body">
			<table id="gridAffaire" class="table table-bordered table-striped gridAffaire">
				<thead>
					<tr>
						<th>Codification</th>
						<th>Tarif Normal</th>
						<th>Tarif Social</th>
						<th>Opérations</th>
					</tr>
				</thead>
				<tbody>';
				foreach ($this->pdoStatement as $data){
					$content.= '<tr>'.
							'<td>' . $data['codificationTarif'] . '</td>'.
							'<td>' . $data['tarifNormal'] . '</td>'.
							'<td>' . $data['tarifSocial'] . '</td>'.
							'<td><a href="./index.php?p=tarif&cod='. $data['idTarif'] .'"><span class="label label-success">Modifier</span></a>
		 					</td>'.
	 					'</tr>';
				}
				$content .='
				</tbody>
					<tfoot>
					<tr>
						<th>Codification</th>
						<th>Tarif Normal</th>
						<th>Tarif Social</th>
						<th>Opérations</th>
					</tr>
					</tfoot>
				</table></div>';
		}
		else{
			$content .='<div class="alert alert-info alert-dismissable"><i class="icon fa fa-info-circle"></i> Aucune liste disponible</div>';
		}
		return $content;
	}
	
	public function optionTarification($idTarif)
	{
		$option = '';
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_TARIFICATION);
		if ($this->pdoStatement){
			foreach($this->pdoStatement as $data){
				if ( $data['idTarif'] == $idTarif ){
					$option .= '<option value="' . $data['idTarif'] . '" selected/>' . $data['codificationTarif'] . '</option>';
				}
				else
					$option .= '<option value="' . $data['idTarif'] . '" >' . $data['codificationTarif'] . '</option>';
			}
		}
		else $option .= '<option value=""> ----------------- </option>';
		return $option;
	}
	
	public function readTarification($idTarif)
	{
		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_ALL_TARIFICATION_BY_ID,
				array(
					'idTarif' => $idTarif,
				));
		foreach ($this->pdoStatement as $data){
			return $data;
		}
	}	
	
	public function countService()
	{
		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_COMPTER_SERVICE,array(''));
		foreach ($this->pdoStatement as $data){
			return $data['nbre'];
		}
	}
	
	public function countPersonnel()
	{
		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_COMPTER_PERSONNEL,array(''));
		foreach ($this->pdoStatement as $data){
			return $data['nbre'];
		}
	}
	
	public function countPoser()
	{
		$pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_COMPTER_POSER);
		foreach ($pdoStatement as $data){
			return $data['nbre'];
		}
	}
	
	public function countPatient()
	{
		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_COMPTER_PATIENT,array(''));
		foreach ($this->pdoStatement as $data){
			return $data['nbre'];
		}
	}
	
	public function optionCentre()
	{
		$centres = array(
			'vilasco' => 'VILASCO', 
			'inset' => 'INSET',
		);
		echo '<option value="">Veuillez selectionner un centre !</option>';
		foreach ($centres as $key => $data){
// 		if ( $data == $idPersonnel ){
// 			echo '<option value="' . $centres[$key] . '" selected/>' . $data . '</option>';
// 		}
// 		else
			echo '<option value="' . $centres[$key] . '">' . $data . '</option>';
		}
	}
}
?>
