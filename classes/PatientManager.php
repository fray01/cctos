<?php
class PatientManager
{
	CONST SQL_SELECT_ALL_TYPE_PATIENTS_BY_ID = 'SELECT * FROM type_patient WHERE idTypePatient = :idTypePatient';
	CONST SQL_SELECT_ALL_PATIENTS_BY_ID = 'SELECT * FROM patient WHERE numDossier = :numDossier';
	CONST SQL_SELECT_ALL_TYPE_PATIENTS = 'SELECT * FROM type_patient';
	CONST SQL_SELECT_COUNT_ALL_TYPE_PATIENTS = 'SELECT count(*) as resultat FROM type_patient';
	CONST SQL_SELECT_ALL_PATIENTS ='SELECT distinct patient.*,
			type_patient.*
			FROM type_patient, patient
			WHERE patient.idTypePatient = type_patient.idTypePatient';	
			
	CONST SQL_SELECT_COUNT_ALL_PATIENTS_ON_WAITING ='SELECT count(distinct poser.numDossier) as resultat 
			FROM poser, acte
			WHERE poser.etatPoser = 1
			AND poser.idActe = acte.idActe
			AND acte.idService = :idService';
	
	CONST SQL_SELECT_ALL_PATIENTS_SERVICE ='SELECT distinct patient.*,
			type_patient.*
			FROM type_patient, patient, poser, acte, service
			WHERE patient.idTypePatient = type_patient.idTypePatient';
	
	CONST SQL_SELECT_COUNT_ALL_PATIENTS ='SELECT count(distinct patient.numDossier) as resultat 
			FROM type_patient, 
			patient 
			WHERE patient.idTypePatient = type_patient.idTypePatient';

		CONST SQL_SELECT_COUNT_ALL_PATIENTS_SERVICE ='SELECT count(distinct patient.numDossier) as resultat 
			FROM type_patient, 
			patient, poser, acte, service
			WHERE patient.idTypePatient = type_patient.idTypePatient';
	
	CONST SQL_ADD_TYPE_PATIENT = 'INSERT INTO 
			type_patient(designationTP, reductionConsultation, reductionSoin)
			VALUES (:designationTP, :reductionConsultation, :reductionSoin)';
	CONST SQL_UPDATE_TYPE_PATIENT = 'UPDATE type_patient 
			SET designationTP = :designationTP,
			reductionConsultation = :reductionConsultation,
			reductionSoin = :reductionSoin
			WHERE idTypePatient = :idTypePatient';
	CONST SQL_UPDATE_PATIENT = 'UPDATE patient
			SET dossierPatient =:dossierPatient,
				nomPatient = :nomPatient, 
				PrenomPatient = :PrenomPatient, 
				DDNPatient = :DDNPatient, 
				sexePatient = :sexePatient, 
				professionPatient = :professionPatient, 
				contactPatient = :contactPatient,
				adressePatient = :adressePatient,
				perePatient = :perePatient,
				merePatient = :merePatient,
				assurancePatient = :assurancePatient,
				etatPatient = :etatPatient,
				idTypePatient = :idTypePatient
			WHERE numDossier = :numDossier
			';
	CONST SQL_UPDATE_PATIENT_ADMIN = 'UPDATE patient
			SET idTypePatient = :idTypePatient,
			etatPatient = :etatPatient
			WHERE numDossier = :numDossier';
	
	CONST SQL_ADD_PATIENT = 'INSERT INTO patient
			(
				dossierPatient,
				nomPatient, 
				PrenomPatient, 
				DDNPatient, 
				sexePatient, 
				professionPatient, 
				contactPatient,
				adressePatient,
				perePatient,
				merePatient,
				assurancePatient,
				etatPatient,
				idTypePatient
			)
		VALUES
			(
				:dossierPatient,
				:nomPatient, 
				:PrenomPatient, 
				:DDNPatient, 
				:sexePatient, 
				:professionPatient, 
				:contactPatient,
				:adressePatient,
				:perePatient,
				:merePatient,
				:assurancePatient,
				:etatPatient,
				:idTypePatient
			)';

	CONST SQL_ADD_FOLDER = 'INSERT INTO poser
			(
			coutPoser, 
			idActe, 
			numDossier,
			etatPoser
			)
			VALUES (
			:coutPoser, 
			:idActe, 
			:numDossier,
			:etatPoser
			)';
	CONST SQL_UPDATE_ETAT_POSER_PATIENT ='UPDATE poser 
			SET etatPoser = :etatPoser
			WHERE idPoser = :idPoser';
	CONST SQL_ADD_ACTE_PATIENT = 'INSERT INTO versement (montantVersement, 
			etatVersement,
			idPoser
			)
			VALUES (:montantVersement, 
			:etatVersement,
			:idPoser)';
	
	CONST SQL_SELECT_PATIENT_FOLDER = 'SELECT patient.*, 
			personnel.*
			FROM patient, personnel, suivre
			WHERE patient.numDossier =:numDossier
			AND suivre.idPersonnel = personnel.idPersonnel
			AND suivre.numDossier = patient.numDossier';
	
	CONST SQL_SELECT_PATIENT_FOLDERS = 'SELECT DISTINCT service.*
			FROM acte, poser, patient, service
			WHERE patient.numDossier = :numDossier
			AND poser.idActe = acte.idActe
			AND poser.numDossier = patient.numDossier
			AND service.idService = acte.idService'; 

	CONST SQL_SELECT_PATIENT_ACTES_BY_FOLDER = 'SELECT distinct poser.*, 
			sum(versement.montantVersement) as montantVersement, 
			versement.etatVersement, 
			versement.dateVersement ,
			acte.*, 
			service.*
			FROM poser, 
			versement, 
			acte, 
			service 
			WHERE poser.idPoser = versement.idPoser 
			AND poser.numDossier = :numDossier 
			AND acte.idActe = poser.idActe 
			AND service.idService = :idService
			AND acte.idService = service.idService
			GROUP BY poser.idPoser';
	
	CONST SQL_SELECT_ACCUEIL_PATIENT_ACTES_BY_FOLDER = 'SELECT DISTINCT service.*
			FROM acte, poser, patient, service
			WHERE patient.numDossier = :numDossier
			AND poser.idActe = acte.idActe
			AND poser.numDossier = patient.numDossier
			AND service.idService = acte.idService
			AND service.nomService = :nomService';

	
	CONST SQL_FOLLOW_PATIENT = 'INSERT INTO suivre (dateSuivre, 
			idPersonnel,
			numDossier	
			)
			VALUES (NOW(), 
			:idPersonnel,
			:numDossier)';			
			
	CONST SQL_UPDATE_FOLLOW_PATIENT1 = 'UPDATE poser
	SET idPraticien = :idPersonnel
	WHERE idPoser = :idPoser';			
			
	CONST SQL_UPDATE_FOLLOW_PATIENT2 = 'UPDATE poser
	SET idEtudiant = :idPersonnel
	WHERE idPoser = :idPoser';	
	
	CONST SQL_SELECT_PATIENT_FOLLOWERS = 'SELECT personnel.*
			FROM personnel, poser
			WHERE poser.idPoser =:idPoser
			AND (personnel.idPersonnel = poser.idPraticien
			OR personnel.idPersonnel = poser.idEtudiant)
			ORDER BY personnel.fonctionPersonnel';
	
// 	CONST SQL_SELECT_POTENTIAL_FOLLOWERS_BY_FONCTION = 'SELECT personnel.*
// 			FROM personnel, etre
// 			WHERE personnel.fonctionPersonnel = :fonctionPersonnel
// 			AND personnel.idPersonnel = etre.idPersonnel
// 			AND date(etre.dateEntree) = CURRENT_DATE
// 			AND etre.idService = :idService
// 			AND etre.dateSortie IS NULL';

	CONST SQL_SELECT_POTENTIAL_FOLLOWERS_BY_FONCTION = 'SELECT DISTINCT personnel.*
			FROM personnel, etre
			WHERE personnel.fonctionPersonnel = :fonctionPersonnel
			AND personnel.idPersonnel = etre.idPersonnel
			AND date(etre.dateEntree) = CURRENT_DATE';

	CONST SQL_SELECT_SERVICE_NAME = 'SELECT nomService 
			FROM service 
			WHERE nomService <> "Accueil" ';
	
	CONST SQL_SELECT_PATIENT_ALERT = 'SELECT COUNT(numDossier) as Nbre
			FROM patient
			WHERE etatPatient=1';
	
	CONST SQL_SELECT_PAYEMENT_INFO ='SELECT patient.NumDossier, patient.nomPatient, patient.PrenomPatient, poser.*, SUM(versement.montantVersement) as totalVersement, acte.designationActe
			FROM patient, poser, versement, acte
			WHERE poser.idPoser = versement.idPoser
			AND poser.numDossier = patient.numDossier
			AND poser.idActe = acte.idActe
			GROUP BY versement.idPoser';
	
	CONST SQL_SELECT_LAST_FOLDER = 'SELECT dossierPatient FROM patient WHERE dossierPatient';
	public $pdoQuery;
	public $data;
	public $error;
	private $pdoStatement;
	
	/****************Begin new type of patient****************/
	public function __construct()
	{
		$this->pdoQuery = new PdoExecuteQuery();
		$this->error = new ErrorsManager();
	}
	
	private function isFormSubmit($formname){
		return (isset($_POST['formname']) && ($_POST['formname'])==$formname);
	}
	
	private function isDateFormat($formatInitial, $formatFinal, $string)
	{
		$date = date_create_from_format($formatInitial, $string);
		$date = !empty($date) ? date_format($date, $formatFinal) : '';
		return   $date;
	}

	private function getLastFolderNumber($centre)
	{
		$i=0;
		$query = '';
		$slashCentre = '';
		$date = date("y");
		$delimiter = '/';
		if ($centre=="INSET"){
			$slashCentre = '/IN';
			$like = '/IN';
			$query .= ' LIKE :like ORDER BY numDossier DESC LIMIT 1';
		}
		else {
			$like = '/IN';
			$query = ' NOT LIKE :like ORDER BY numDossier DESC LIMIT 1';
		}
		$bool = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_LAST_FOLDER . $query, array(
			':like' => '%'.$like,
		));
		if (!empty($bool)){
			$folder = explode("$delimiter", $bool[0]['dossierPatient']);
// 			var_dump($folder[0]);
			(int)$folder[0]+=1;
			
			$IN = !empty($folder[2]) ? ('/'.$folder[1].'/'.$folder[2]) : '/'.$folder[1];
			
// 			var_dump($folder[0]);
// 			var_dump($folder[1]);
// 			die();
			if((int)$folder[1]!==(int)$date){
				$i+=1;
				$FolderNumber = '00'.$i.'/'.$date.$slashCentre;
			}
			else {
				$FolderNumber = '00'.$folder[0].$IN;
			}
		}
		else{
			$i+=1;
			$FolderNumber = '00'.$i.'/'.$date.$slashCentre;
		}
		return $FolderNumber;
	}

	public function addNewTypePatient()
	{
		if ($this->isFormSubmit('addTypePatient') || $this->isFormSubmit('addTypePatient')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['submit']);
			$formValidation->setDataFilter(array(
					'designationTP' => FILTER_UNSAFE_RAW,
					'reductionConsultation' => FILTER_SANITIZE_NUMBER_INT,
					'reductionSoin' => FILTER_SANITIZE_NUMBER_INT,
			));
			$data = array(
					'designationTP' => strip_tags(strtoupper($_POST['designation'])),
					'reductionConsultation' => (int)($_POST['consultation']),
					'reductionSoin' => (int)($_POST['soin']),
			);
		
			$data = $formValidation->getFilteredData($data);
			$bool = $this->pdoQuery->executePdoQuery(self::SQL_ADD_TYPE_PATIENT, $data);
			return $this->error->isErrorMsg($bool, 'Enregistrement');
		}
		else return;
		
	}
	
	public function updateTypePatient()
	{
		if ($this->isFormSubmit('updateTypePatient') || $this->isFormSubmit('updateTypePatient')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['update']);
			$formValidation->setDataFilter(array(
					'idTypePatient' => FILTER_SANITIZE_NUMBER_INT,
					'designationTP' => FILTER_UNSAFE_RAW,
					'reductionConsultation' => FILTER_SANITIZE_NUMBER_INT,
					'reductionSoin' => FILTER_SANITIZE_NUMBER_INT,
			));
			$data = array(
					'idTypePatient' => (int)($_POST['idTypePatient']),
					'designationTP' => strip_tags(strtoupper($_POST['designation'])),
					'reductionConsultation' => (int)$_POST['consultation'],
					'reductionSoin' => (int)$_POST['soin'],
			);
	
			$data = $formValidation->getFilteredData($data);
			$bool = $this->pdoQuery->executePdoQuery(self::SQL_UPDATE_TYPE_PATIENT, $data);
			return $this->error->isErrorMsg($bool, 'Modification');
		}
		else return;
	}
	
	public function deleteTypePatient()
	{
	
	}
	
	public function readTypePatient($idTypePatient)
	{
		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_ALL_TYPE_PATIENTS_BY_ID,
				
		array(
			'idTypePatient' => $idTypePatient,
		));
		foreach ($this->pdoStatement as $data){
			return $data;
		}
	}

	public function displayTypePatient()
	{
		$content='';
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_COUNT_ALL_TYPE_PATIENTS);
		foreach ($this->pdoStatement as $data){
			$resultat = $data['resultat'];
		}
		
		if($resultat<>0){
			$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_ALL_TYPE_PATIENTS);
			$content .= '<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<div class="box">
						<div class="box-header">
							<i class="fa fa-book"></i>
							<h3 class="box-title">Liste des Types de Patients</h3>
								<!-- tools box -->
								<div class="box-tools pull-right">
									<a download="reduction.xls" class="btn btn-info btn-sm" href="#gridAffaire" data-toggle="tooltip" title="exporter vers excel" onclick="return ExcellentExport.excel(this,\'gridAffaire\', \'reduction\');">Exporter vers Excel</i></a>
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" title="Afficher/Masquer"></i></button>
									<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
								</div><!-- /. tools -->
						</div><!-- /.box-header -->
						<div class="box-body">
			<table id="filtredTable" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Libellé</th>
						<th>Reduction Consultation</th>
						<th>Reduction des Soins</th>
						<th>Opérations</th>
					</tr>
				</thead>
				<tbody>';
			if ($this->pdoStatement) {
				foreach ($this->pdoStatement as $data){
					$content.= '<tr>'.
							'<td>' . $data['designationTP'] . '</td>'.
							'<td>' . $data['reductionConsultation'] . '</td>'.
							'<td>' . $data['reductionSoin'] . '</td>'.
							'<td><a href="./index.php?p=typepatient&id='. $data['idTypePatient'] .'"><span class="label label-success">Modifier</span></a>
							</td>'.
						 '</tr>';
				}
			}
			$content .='
				</tbody>
					<tfoot>
						<tr>
							<th>Libellé</th>
							<th>Reduction Consultation</th>
							<th>Reduction des Soins</th>
							<th>Opérations</th>
						</tr>
					</tfoot>
				</table></div></div></div></div>';
		}
		else {
			$content .='<div class="alert alert-info alert-dismissable"><i class="icon fa fa-info-circle"></i> Aucune liste disponible</div>';
		}
		return $content;
	}
	
	public function optionTypePatient($idTypePatient)
	{
		$option = '';
		$condition ='';
		if($_SESSION['nomService']=="Accueil"){
			$condition .= ' WHERE designationTP IN ("CAS SOCIAL", "NORMAL")';
		}
		elseif($_SESSION['nomService']=="Direction"){
			$condition .= ' WHERE designationTP <>"CAS SOCIAL"';
		}
		else $condition;
		
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_ALL_TYPE_PATIENTS . $condition);
		if ($this->pdoStatement){
			foreach ($this->pdoStatement as $data){
				if ( $data['idTypePatient'] == $idTypePatient ){
					$option.='<option value="' . $data['idTypePatient'] . '" selected/>' . $data['designationTP'] . '</option>';
				}
				else 
					$option .= '<option value="' . $data['idTypePatient'] . '" >' . $data['designationTP'] . '</option>';
			}
		}
		else $option .= '<option value="' . $data['idTypePatient'] . '" selected/>' . $data['designationTP'] . '</option>';
		return $option;
	}
	
	private function getTypePatient($idTypePatient)
	{
		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_ALL_TYPE_PATIENTS_BY_ID,
		array(
			'idTypePatient' => $idTypePatient,
		));
		foreach ($this->pdoStatement as $data){
			return $data;
		}
	}
	/*******************End T.O.P**************************/

	/******************Begin Patient************************/

	public function addNewPatient()
	{
		if ($this->isFormSubmit('addPatient')){
			//$pdoQuery = new PdoExecuteQuery();
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['submit']);
			$dossierPatient = $this->getLastFolderNumber($_POST['centre']);
			unset($_POST['centre']);
			$formValidation->setDataFilter(array(
				'dossierPatient' => FILTER_UNSAFE_RAW,
				'nomPatient' => FILTER_UNSAFE_RAW,
				'PrenomPatient' => FILTER_UNSAFE_RAW,
				'DDNPatient' => FILTER_SANITIZE_ENCODED,
				'sexePatient' => FILTER_SANITIZE_ENCODED,
				'professionPatient' => FILTER_UNSAFE_RAW,
				'contactPatient' => FILTER_SANITIZE_ENCODED,
				'adressePatient' => FILTER_SANITIZE_STRING,
				'perePatient' => FILTER_UNSAFE_RAW,
				'merePatient' => FILTER_UNSAFE_RAW,
				'assurancePatient' => FILTER_SANITIZE_ENCODED,
				'etatPatient' => FILTER_SANITIZE_NUMBER_INT,
				'idTypePatient' => FILTER_SANITIZE_NUMBER_INT,
			));
			$data = array(
				'dossierPatient'=> $dossierPatient,
				'nomPatient' => (string)strip_tags(ucwords($_POST['nom'])),
				'PrenomPatient' =>(string)strip_tags(ucwords($_POST['prenom'])),
				'DDNPatient' => $_POST['ddn'],
				'sexePatient' => $_POST['sexe'],
				'professionPatient' => (string)strip_tags(ucwords($_POST['profession'])),
				'contactPatient' => (string)$_POST['contact'],
				'adressePatient' => (string)strip_tags($_POST['adresse']),
				'perePatient' => (string)strip_tags(ucwords($_POST['pere'])),
				'merePatient' => (string)strip_tags(ucwords($_POST['mere'])),
				'assurancePatient' => (string)$_POST['assurance'],
				'idTypePatient' => (int)$_POST['idTypePatient'],
			);
			$idTypePatient = $this->getTypePatient($data['idTypePatient']);
			#var_dump($idTypePatient);echo "<br/>";
			if($idTypePatient['designationTP']=="CAS SOCIAL"){
				$data['etatPatient'] = 1;
			}
			else $data['etatPatient'] = 0;
			$data = $formValidation->getFilteredData($data);
			#var_dump($data);
			if($_POST['nom']==""|| $_POST['prenom']==""){
				#echo "BOOM";
				return $this->error->isErrorMsg($bool, 'Enregistrement');
				#die();
			}
			else{
				$bool = $this->pdoQuery->executePdoQuery(self::SQL_ADD_PATIENT, $data);
				return $this->error->isErrorMsg($bool, 'Enregistrement');
			}
		}
		else return;
	}
	
	public function updatePatient()
	{
		if ($this->isFormSubmit('updatePatient')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['update']);
			#$dossierPatient = $this->getLastFolderNumber($_POST['centre']);
			if ($_SESSION['nomService']=="Accueil") {
				$formValidation->setDataFilter(array(
					'numDossier' => FILTER_SANITIZE_NUMBER_INT,
					'dossierPatient' => FILTER_UNSAFE_RAW,
					'nomPatient' => FILTER_UNSAFE_RAW,
					'PrenomPatient' => FILTER_UNSAFE_RAW,
					'DDNPatient' => FILTER_SANITIZE_ENCODED,
					'sexePatient' => FILTER_SANITIZE_ENCODED,
					'professionPatient' => FILTER_UNSAFE_RAW,
					'contactPatient' => FILTER_SANITIZE_STRING,
					'adressePatient' => FILTER_UNSAFE_RAW,
					'perePatient' => FILTER_UNSAFE_RAW,
					'merePatient' => FILTER_UNSAFE_RAW,
					'assurancePatient' => FILTER_UNSAFE_RAW,
					'idTypePatient' => FILTER_SANITIZE_NUMBER_INT,
				));
				$data = array(
					'numDossier' => (int)$_POST['numDossier'],
					'dossierPatient' => $_POST['dossierPatient'],
					'nomPatient' => strip_tags(ucwords($_POST['nom'])),
					'PrenomPatient' => strip_tags(ucwords($_POST['prenom'])),
					'DDNPatient' => $_POST['ddn'],
					'sexePatient' => $_POST['sexe'],
					'professionPatient' => (string)strip_tags(ucwords($_POST['profession'])),
					'contactPatient' => (string)$_POST['contact'],
					'adressePatient' => strip_tags($_POST['adresse']),
					'perePatient' => strip_tags(ucwords($_POST['pere'])),
					'merePatient' => strip_tags(ucwords($_POST['mere'])),
					'assurancePatient' => $_POST['assurance'],
					'idTypePatient' => (int)$_POST['idTypePatient'],
				);
				$query = self::SQL_UPDATE_PATIENT;
			}
			else{
				$formValidation->setDataFilter(array(
					'numDossier' => (int)$_POST['numDossier'],
					'idTypePatient' => (int)$_POST['idTypePatient'],
				));
				$data = array(
					'numDossier' => (int)$_POST['numDossier'],
					'idTypePatient' => (int)$_POST['idTypePatient'],
				);
				$query = self::SQL_UPDATE_PATIENT_ADMIN;
			}

			$idTypePatient = $this->getTypePatient($data['idTypePatient']);
			$data = $formValidation->getFilteredData($data);
			// var_dump($data);
			// die();
			if($idTypePatient['designationTP']=="CAS SOCIAL"){
				$data['etatPatient'] = 1;
			}
			else $data['etatPatient'] = 0;
			$bool = $this->pdoQuery->executePdoQuery($query, $data);
			return $this->error->isErrorMsg($bool, 'Modification');
		}
	}
	
	public function deletePatient()
	{
	
	}
	
	public function readPatient($numDossier)
	{
		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_ALL_PATIENTS_BY_ID,
			array(
				'numDossier' => $numDossier,
			));
		foreach ($this->pdoStatement as $data){
			return $data;
		}
	}
	
	public function displayPatient($etatPoser, $etatPatient=0)
	{
		$content='';
		$condition='';
		$onWaiting = '';
		$idService = $_SESSION['idService'];
		if($_SESSION['nomService'] <> "Accueil" && $_SESSION['nomService']<>"Direction" ){
			$query = self::SQL_SELECT_ALL_PATIENTS_SERVICE;
			$count = self::SQL_SELECT_COUNT_ALL_PATIENTS_SERVICE;
			$condition = ' AND patient.numDossier = poser.numDossier
			AND acte.idService = service.idService
			AND poser.idActe = acte.idActe
			AND acte.idService = '.$idService ;
			$onWaiting = (!empty($etatPoser)) ? ' AND etatPoser ='.$etatPoser : '';
		}
		else {
			$query = self::SQL_SELECT_ALL_PATIENTS;
			$count = self::SQL_SELECT_COUNT_ALL_PATIENTS;
		}
		if ($etatPatient<>0){
			$etatPatient = (int)$etatPatient;
			$count .=' AND patient.etatPatient ='.$etatPatient . $condition;
			$query .= ' AND patient.etatPatient = '.$etatPatient . $condition;
		}
		else{
			$count .= $condition . $onWaiting;
			$query .= $condition . $onWaiting ;
		}
		$this->pdoStatement = $this->pdoQuery->executePdoQuery($count);
		foreach ($this->pdoStatement as $data){
			$resultat = $data['resultat'];
		}
		if($resultat<>0){
			$this->pdoStatement = $this->pdoQuery->executePdoQuery($query);
			$content .= '<div class="row">
				<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<i class="fa fa-wheelchair"></i>
						<h3 class="box-title">Liste des Patients</h3>
						<div class="pull-right box-tools">
					<a id="member" href="#addMember" class="hide open-popup-link"data-toggle="tooltip"></a>
					<a download="Patients.xls" class="btn btn-info btn-sm" href="#filtredTable" data-toggle="tooltip" title="exporter vers excel" onclick="return ExcellentExport.excel(this,\'filtredTable\', \'Patients\');">Exporter vers Excel</i></a>
						</div>
					</div><!-- /.box-header -->
					<div class="box-body">
					<table id="filtredTable" class="table table-bordered table-striped gridAffaire">
					<thead>
					<tr>
						<th>N°Dossier</th>
						<th>Nom</th>
						<th>Prénoms</th>
						<th>Né(e) le</th>
						<th>Contact</th>
						<th>Adresse</th>
						<th>Assuré</th>
						<th>Catégorie</th>';
						if($_SESSION['nomService']=="Accueil"){
							$content.='<th>Detail</th>';
							$content.='<th>Opération</th></tr>';
						}
						elseif ($_SESSION['nomService']=="Direction"){
							if ($etatPatient==1) {
								$content.='<th>Opération</th></tr>';
							}
							else{
								$content.='<th>Detail</th></tr>';
							}
						}
						else $content.='<th>Detail</th></tr>';
					
				$content.='</thead>
				<tbody>';
			if ($this->pdoStatement) {
				foreach ($this->pdoStatement as $data){
					$content.= '<tr>'.
						'<td>' . $data['dossierPatient'] . '</td>'.
						'<td>' . $data['nomPatient'] . '</td>'.
						'<td>' . $data['PrenomPatient'] . '</td>'.
						'<td>' . $this->isDateFormat('Y-m-d', 'd-m-Y',$data['DDNPatient']) . '</td>'.
						'<td>' . $data['contactPatient'] . '</td>'.
						'<td>' . $data['adressePatient'] . '</td>'.
						'<td>' . $data['assurancePatient'] . '</td>'.
						'<td>' . $data['designationTP'] . '</td>';
						if($_SESSION['nomService']=="Accueil"){
							$content.='<td><a href="./index.php?p=patientfolder&detail='. $data['numDossier'] .'"><span class="label label-info">voir plus</span></a></td>';
							$content.='<td><a href="./index.php?p=viewpatient&id='.$data['numDossier'] .'"><span class="label label-success">Modifier</span></a></td></tr>';
						}
						elseif ($_SESSION['nomService']=="Direction"){
							if ($etatPatient==1) {
								$content.='<td><a href="./index.php?p=viewsocialcaspatient&detail='. $data['numDossier'] .'"><span class="label label-info">Valider</span></a></td>';
							}
							else{
								$content.='<td><a href="./index.php?p=patientfolder&detail='. $data['numDossier'] .'"><span class="label label-info">voir plus</span></a></td></tr>';
							}
						}
						else $content.='<td><a href="./index.php?p=patientfolder&detail='. $data['numDossier'] .'"><span class="label label-info">voir plus</span></a></td></tr>';
				}
			}
				 $content .='
				</tbody>
					<tfoot>
						<tr>
							<th>N°Dossier</th>
							<th>Nom</th>
							<th>Prénoms</th>
							<th>Né(e) le</th>
							<th>Contact</th>
							<th>Adresse</th>
							<th>Assuré</th>
							<th>Catégorie</th>';
						if($_SESSION['nomService']=="Accueil"){
							$content.='<th>Detail</th>';
							$content.='<th>Opération</th></tr>';
						}
						elseif ($_SESSION['nomService']=="Direction"){
							if ($etatPatient==1) {
								$content.='<th>Opération</th></tr>';
							}
							else{
								$content.='<th>Detail</th></tr>';
							}
						}
						else $content.='<th>Detail</th></tr>';
					$content.='</tfoot></table></div></div></div></div>';
		}
		else {
		$content .='<div class="alert alert-info alert-dismissable"><i class="icon fa fa-info-circle"></i> Aucune liste disponible</div>';
		}
		return $content;
	}

	
	public function displayPatientShort()
	{
		$content='';
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_ALL_PATIENTS);

		$content .= '<table id="filtredTable" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>N°Dossier</th>
					<th>Nom</th>
					<th>Prénoms</th>
					<th>Detail</th>
				</tr>
			</thead>
			<tbody>';
		if ($this->pdoStatement) {
			foreach ($this->pdoStatement as $data){
				$content.= '<tr>'.
					'<td>' . $data['dossierPatient'] . '</td>'.
					'<td>' . $data['nomPatient'] . '</td>'.
					'<td>' . $data['PrenomPatient'] . '</td>'.
					'<td><a href="./index.php?p=patientfolder&detail='. $data['numDossier'] .'"><span class="label label-info">voir plus</span></a></td>'.
				'</tr>';
			}
		}
			$content .='
			</tbody>
				<tfoot>
				<tr>
					<th>N°Dossier</th>
					<th>Nom</th>
					<th>Prénoms</th>
					<th>Detail</th>
				</tr>
				</tfoot>
			</table>';
			return $content;
		
	}

	
	public function readPatientFolder($numDossier)
	{

			$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_ALL_PATIENTS_BY_ID,
				array(
					'numDossier' => $numDossier,
				));
		foreach ($this->pdoStatement as $data){

			return $data;
		}
		
	}
	
	private function getService()
	{
		$service = array();
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_SERVICE_NAME);
		foreach ($this->pdoStatement as $data){
			$service[] = $data['nomService'];
		}
		return $service;
	}
	private function patientNewFolder()
	{
		$formValidation = new FormFieldValidation();
		unset($_POST['formname']);
		unset($_POST['submit']);
		$formValidation->setDataFilter(array(
			'coutPoser' => FILTER_SANITIZE_NUMBER_INT,
			'idActe' => FILTER_SANITIZE_NUMBER_INT,
			'numDossier' => FILTER_SANITIZE_NUMBER_INT,
			'etatPoser' => FILTER_SANITIZE_NUMBER_INT,
		));
		$data = array(
			'coutPoser' => (int)$_POST['facturation'],
			'idActe' => (int)$_POST['acte'],
			'numDossier' => (int)$_POST['numDossier'],
			'etatPoser' => 1,
		);
	
		$data = $formValidation->getFilteredData($data);
		$this->pdoQuery->executePdoQuery(self::SQL_ADD_FOLDER, $data);
	}
	
	
	private function addPatientVersement($idPoser, $facturation)
	{
		$formValidation = new FormFieldValidation();
		$formValidation->setDataFilter(array(
			'montantVersement' => FILTER_SANITIZE_NUMBER_INT,
			'etatVersement' => FILTER_SANITIZE_NUMBER_INT,
// 			'facturation' => FILTER_SANITIZE_NUMBER_INT,
			'idPoser' => FILTER_SANITIZE_NUMBER_INT,
		));
		$data = array(
			'montantVersement' => (int)$_POST['versement'],
			'etatVersement' => 0,
// 			'facturation' => (int)$_POST['facturation'],
			'idPoser' => (int)$idPoser,
		);
		if($data['montantVersement'] < $facturation){
		}
		else $data['etatVersement'] = 1;
	
		$data = $formValidation->getFilteredData($data);
		$bool = $this->pdoQuery->executePdoQuery(self::SQL_ADD_ACTE_PATIENT, $data);
		return $bool;
	}
	
	public function addPatientNewActe()
	{
		if (isset($_POST['formname']) && $_POST['formname'] !=''){
			$formname = $_POST['formname'];
			if ($this->isFormSubmit($formname)){
				$this->patientNewFolder();
				$idPoser = $this->pdoQuery->getLastInserId();
				$bool = $this->addPatientVersement($idPoser, (int)$_POST['facturation']);
				return $this->error->isErrorMsg($bool, 'Enregistrement');
			}
			else return;
		}
		else return;
	}
	
	public function setBackward()
	{
		if ($this->isFormSubmit('buyrest') || $this->isFormSubmit('buyrest')){
			unset($_POST['formname']);
			unset($_POST['setbackward']);
			$idPoser = (int)$_POST['idPoser'];
			$facturation = (int)$_POST['versement'];
			return $this->addPatientVersement($idPoser, $facturation);
		}
	}
	
	public function isSafe($idPoser)
	{
		$formValidation = new FormFieldValidation();
		$formValidation->setDataFilter(array(
			'idPoser' => FILTER_SANITIZE_NUMBER_INT,
			'etatPoser' => FILTER_SANITIZE_NUMBER_INT,
		));
		$data = array(
			'idPoser' => (int)$idPoser,
			'etatPoser' => 0,
		);
		$data = $formValidation->getFilteredData($data);
		return $this->pdoQuery->executePdoQuery(self::SQL_UPDATE_ETAT_POSER_PATIENT, $data);
	}
	
public function displayPatientFolderByServices($numDossier, $nomPatient, $prenomPatient)
	{
		$services = $this->getService();
		$content='';
		$bFollow = '';
		if (in_array($_SESSION['nomService'], $services) && $_SESSION['nomService']<>'Direction'){
			$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_ACCUEIL_PATIENT_ACTES_BY_FOLDER,
				array(
					'numDossier' => $numDossier,
					'nomService' => $_SESSION['nomService'],
				));
				$bFollow = '<a id="bFollow" href="#follow"  class="btn btn-info btn-sm open-popup-link hidden" data-toggle="tooltip"></a>';
		}
		else{
		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_PATIENT_FOLDERS,
			array(
				'numDossier' => $numDossier,
			));
		}
		if ($this->pdoStatement) {
			foreach ($this->pdoStatement as $data){
				if ($data['nomService']=="Consultation") {
					$link = isset($_GET['m']) ? '' : '&m=0';
				}
				else $link = '&m=1';
				$content.= '
						<div class="row">
							<div class="col-xs-12">
								<div class="box ">
									<div class="box-header">
										<i class="fa fa-folder"></i>
										<h3 class="box-title">Dossier '. $data['nomService'] .'</h3>
										<div class="pull-right box-tools">'.$bFollow;
											$header ='';
											$tdEmpty ='';
											if (!in_array($_SESSION['nomService'], $services) && $_SESSION['nomService']<>"Direction"){
												$content.='<a href="#patientActe"  class="btn btn-info btn-sm open-popup-link add" data-toggle="tooltip" data="'. $data['idService'] .'"> Effectuer un Acte</a>';
												$header ='<th>Reste a payer</th>
														<th>Effectuer le règlement</th>';
												$tdEmpty ='<td></td><td></td>';
												
											}elseif($_SESSION['nomService']=="Direction"){
												$header ='<th>Reste a payer</th>';
												$tdEmpty ='<td></td>';
											}
											$content.='<input class="service" type="hidden" name="idService" value="'. $data['idService'] .'">
											<a download="Dossier-'.$data['nomService'].'-Patient-'.$nomPatient.' '.$prenomPatient.'.xls" href="#gridAffaire-'.$data['nomService'].'" class="btn btn-info btn-sm " data-toggle="tooltip" title="Exporter vers Excel" onclick="return ExcellentExport.excel(this, \'gridAffaire-'.$data['nomService'].'\', \'Dossier '.$data['nomService'].'\');"><i class="fa fa-file-excel-o"></i></a>
												<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa fa-minus"></i></button>
											<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
										</div>
									</div>
									<div class="box-body">
										<table id="gridAffaire-'.$data['nomService'].'" class="table table-bordered table-striped gridAffaire">
											<thead>
												<tr>
													<th>Date</th>
													<th>Acte</th>
													<th>Montant Total</th>
													<th>Paiement partiel</th>
													<th>Solde</th>'.$header.'
													<th>Etat</th>
													<th>Voir</th>
													<th>Etudiant</th>
													<th>Praticien</th>
												</tr>
											</thead>
											<tbody>';
											
												$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_PATIENT_ACTES_BY_FOLDER,
														array(
																'idService' => $data['idService'],
																'numDossier' => $numDossier
														));
												if ($this->pdoStatement){
													
													foreach ($this->pdoStatement as $data){
														if ($data['montantVersement'] < $data['coutPoser']){
															$data['etatVersement'] = 'Non';
														}
														else {
															$data['etatVersement'] = 'Oui';
														}
														$content.= '<tr>'.
																'<td>' . $this->isDateFormat('Y-m-d H:i:s', 'd-m-Y H:i:s',$data['datePoser']) . '</td>'.
																'<td>' . $data['designationActe'] . '</td>'.
																'<td>' . $data['coutPoser'] . '</td>'.
																'<td>' . $data['montantVersement'] . '</td>'.
																'<td>' . $data['etatVersement'] . '</td>';
																	if((int)$data['coutPoser'] > (int)$data['montantVersement']){
																		$rest = ($data['coutPoser'] - (int)$data['montantVersement']);
																		if (!in_array($_SESSION['nomService'], $services) && ($_SESSION['nomService'] <> "Direction")){
																			$content .= '<td><button class="btn btn-info btn-sm">'. $rest .'</button></td>'.
																					'<td><form action="./index.php?p=patientfolder&detail='.$_GET['detail'].'" name="formname" method="POST">
																			<input type="hidden" name="formname" value="buyrest">
																			<input type="hidden" name="resteapayer" value="'. $rest .'">
																			<input type="hidden" name="idPoser" value="'. $data['idPoser'] .'">
																			<input type="hidden" name="idActe" value="'. $data['idActe'] .'">
																				<div id="versement" class="form-group">
																					<input class="form-control" type="number" name="versement" min="0" max="'. $rest .'">
																					</div>
																						<button type="submit" name="setbackward" class=" btn btn-primary">Valider</button>
																				</form>
																			</td>';
																		}
																		elseif($_SESSION['nomService'] == "Direction"){
																			$content .= '<td><button class="btn btn-info btn-sm">'. $rest .'</button></td>';
																		}
																	}else $content .=$tdEmpty;
																if($data['etatPoser'] == 1){
																	$content .='<td><button class="btn btn-warning btn-sm">en attente</button></td>';
																}else $content .='<td><button class="btn btn-success btn-sm">effectué</button></td>';
																$content .='<td><a class="btn btn-info btn-sm" href="index.php?p=diagnostic&detail='.$_GET['detail'].'&id='.$data['idPoser'].'&acte='.$data['idActe'].$link.'">Diagnostic</a></td>';
																$praticien = "<a href=\"./index.php?p=patientfolder&detail=".$_GET['detail']."&id=".$data['idPoser']."&type=P\">affecter</a>";
																$etudiant = "<a href=\"./index.php?p=patientfolder&detail=".$_GET['detail']."&id=".$data['idPoser']."&type=E\">affecter</a>";
																if($_SESSION['nomService']=="Direction" || $_SESSION['nomService']=="Accueil"){
																	$praticien = '<label> Aucun</label>';
																	$etudiant = $praticien;
																}
																$followers = $this->readFollower($data['idPoser']);
																if(!empty($followers))
																{	
																	foreach ($followers as $follower){
																		if($follower["fonctionPersonnel"]=="Etudiant"){$etudiant = '<label>'.$follower["nomPersonnel"].' '. $follower["PrenomPersonnel"].'</label>';}
																		if($follower["fonctionPersonnel"]=="Praticien") {$praticien = '<label>'.$follower["nomPersonnel"].' '. $follower["PrenomPersonnel"].'</label>';}
																	}

																}
																$content.='<td>'.$etudiant.'</td> 
																		<td>'.$praticien.'</td>';
																
														}
												}
												else return ;
												$content.='</tbody><tfoot>
													<tr>
														<th>Date</th>
														<th>Acte</th>
														<th>Montant Total</th>
														<th>Paiement partiel</th>
														<th>Solde</th>'.$header.'
														<th>Etat</th>
														<th>Voir</th>
														<th>Etudiant</th>
														<th>Praticien</th>
													</tr>
												</tfoot>
										</table>
									</div>									
									<div class="box-footer clearfix">
										<div class="col-xs-4">
											<a href="index.php?p=print&detail='.$data['numDossier'].'&id='.$data['idService'].'&lab='.$data['nomService'].'" class="btn btn-info btn-sm" title="imprimer">imprimer<i class="fa fa-print"></i></a>
										</div>
									</div><!-- /.box-footer -->';
									if(isset($_GET['id']) && isset($_GET['type'])){
										$select = '';
										$button = '';
										$label = '';
										$id = (int)$_GET['id'];
										$label = ($_GET['type'] == 'P') ? 'Praticien': $label ;
										$label = ($_GET['type'] == 'E') ? 'Etudiant': $label ;
										$select = ($_GET['type'] == 'P') ? $this->selectFollower("Praticien"): $select ;
										$select = ($_GET['type'] == 'E') ? $this->selectFollower("Etudiant"): $select ;
										$button = ($_GET['type'] == 'P') ? '<button type="submit" name="submitP" class=" btn btn-primary">Valider</button>': $button ;
										$button = ($_GET['type'] == 'E') ? '<button type="submit" name="submitE" class=" btn btn-primary">Valider</button>': $button ;
										$form = '<div id="follow" class="white-popup mfp-hide">'.
												'<form action="./index.php?p=patientfolder&detail='.$_GET['detail'].'" name="formname" method="POST">'.
												'<input type="hidden" name="formname" value="updateFollowPatient">'.
												'<input type="hidden" name="idPoser" value="'.$id.'">'.
												'<div class="form-group">'.
												'<label for="idPersonnel">'.$label.' : </label>'.$select.
												'</div>'.
												'<div class="form-group">'.$button.
												'</div>'.
												'</form></div>';
										$content.= $form ;
										}
									$content.='</div>
							</div>
						</div>';
			}
		}
		else{
			$content .= ' <div class="alert alert-info alert-dismissable"><i class="icon fa fa-info-circle"></i> Ce patient ne dispose d aucun dossier medical </div>';
		}
		return $content ;
	}
		/****************End************/
	
/***************************BEGIN FOLLOWING*************************/	
	
	public function addFollowPatient()
	{
			//var_dump($_POST);
		if ($this->isFormSubmit('addFollowPatient')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['submitF']);
			$formValidation->setDataFilter(array(
					'idPersonnel' => FILTER_SANITIZE_NUMBER_INT,
					'numDossier' => FILTER_SANITIZE_NUMBER_INT,
			));
			$data = array(
					'idPersonnel' => (int)($_POST['idPersonnel']),
					'numDossier' => (int)($_POST['numDossier']),
			);
		
			$data = $formValidation->getFilteredData($data);
			$bool = $this->pdoQuery->executePdoQuery(self::SQL_FOLLOW_PATIENT, $data);
			return $this->error->isErrorMsg($bool, 'Enregistrement');
		}
		else return;
		
	}
	
	public function updateFollowPatient()
	{
		if ($this->isFormSubmit('updateFollowPatient')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			$formValidation->setDataFilter(array(
					'idPersonnel' => FILTER_SANITIZE_NUMBER_INT,
					'idPoser' => FILTER_SANITIZE_NUMBER_INT,
			));
			$data = array(
					'idPersonnel' => (int)($_POST['idPersonnel']),
					'idPoser' => (int)($_POST['idPoser']),
			);
		
			$data = $formValidation->getFilteredData($data);
			if(isset($_POST['submitE'])){
				$bool = $this->pdoQuery->executePdoQuery(self::SQL_UPDATE_FOLLOW_PATIENT2, $data);
			}
			else $bool = $this->pdoQuery->executePdoQuery(self::SQL_UPDATE_FOLLOW_PATIENT1, $data);
			return $this->error->isErrorMsg($bool, 'Modification');
		}
		else return;
		
	}
	
	public function readFollower($idPoser)
	{
			$params = array(
				'idPoser' => $idPoser,
			);
			$data = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_PATIENT_FOLLOWERS, $params);
			return $data;
	}
		
	public function selectFollower($fonction)
	{
			$option ='';
			$params = array(
				'fonctionPersonnel' => $fonction,
// 				'idService' => $_SESSION['idService']
			);
			$data = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_POTENTIAL_FOLLOWERS_BY_FONCTION, $params);
			$option.='<select class="form-control" name="idPersonnel">';
			//var_dump($data);
			$ok = false;
			foreach ($data as $follower){
				$option .= '<option value="' . $follower['idPersonnel']. '">' .$follower['nomPersonnel'].' '.$follower['PrenomPersonnel'].'</option>';
				$ok = true;
			}
			if($ok ==false){$option .= '<option> Aucune personne présente dans ce service </option>';}
			$option.='</select>';
			return $option;
	}
/***************************END FOLLOWING*************************/		
	
	public function countAlertPatient()
	{
		$result = array(
			'nbre' => 0,
			'info' => '',
		);
		$param = array('');
		$data = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_PATIENT_ALERT, $param);
		$nbrow = sizeOf($data);
		if ($nbrow==0){return $result;}
			foreach ($data as $nbre){
					$result = array(
						'nbre' => (int)$nbre['Nbre'],
						'info' => '<li><a href="./index.php?p=viewsocialcaspatient"><i class="fa fa-wheelchair text-aqua"></i>'.(int)$nbre['Nbre'].
						' Patient(s) en attente de validation'.
						'</a></li>',
					);
					return $result;
			}
	}
	
	public function countAlertPatientOnWaiting()
	{
		$result = array(
			'nbre' => 0,
			'info' => '',
		);
		$param = array(
			'idService' => $_SESSION["idService"],
		);
		$data = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_COUNT_ALL_PATIENTS_ON_WAITING, $param);
		$nbrow = sizeOf($data);
		if ($nbrow==0){return $result;}
			foreach ($data as $nbre){
					$result = array(
						'nbre' => (int)$nbre['resultat'],
						'info' => '<li><a href="./index.php?p=viewpatientOnWaiting"><i class="fa fa-wheelchair text-aqua"></i>'.(int)$nbre['resultat'].
						' Patient(s) en attente de soins'.
						'</a></li>',
					);
					return $result;
			}
	}	

	
	public function displayPatientPrintFolder($idService, $numDossier)
	{
			$content='';
		
			$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_PATIENT_ACTES_BY_FOLDER,
					array(
							'numDossier' => $numDossier,
							'idService' => $idService
					));
					
			if ($this->pdoStatement){
				
				$content.=' <div class="row">
				  <div class="col-xs-12 table-responsive">
					<table class="table table-striped">
					  <thead>
						<tr>
						  <th>Date</th>
						  <th>Acte</th>
						  <th>Montant Total</th>
						  <th>Paiement partiel</th>
						  <th>Solde</th>
						  <th>Etat</th>
						  <th>Etudiant</th>
						  <th>Praticien</th>
						</tr>
					  </thead>
					  <tbody>';
						foreach ($this->pdoStatement as $data){
							if ($data['montantVersement'] < $data['coutPoser']){
								$data['etatVersement'] = 'Non';
							}
							else {
								$data['etatVersement'] = 'Oui';
							}
							$content.= '<tr>'.
									'<td>' . $this->isDateFormat('Y-m-d H:i:s', 'd-m-Y H:i:s',$data['datePoser']) . '</td>'.
									'<td>' . $data['designationActe'] . '</td>'.
									'<td>' . $data['coutPoser'] . '</td>'.
									'<td>' . $data['montantVersement'] . '</td>'.
									'<td>' . $data['etatVersement'] . '</td>';
									if($data['etatPoser']==1){
										$content .='<td>en attente</td>';
									}else $content .='<td>effectué</td>';
									$praticien = '<label> Aucun</label>';
									$etudiant = $praticien;
									$followers = $this->readFollower($data['idPoser']);
									if(!empty($followers))
									{
										foreach ($followers as $follower){
											if($follower["fonctionPersonnel"]=="Etudiant"){$etudiant = '<label>'.$follower["nomPersonnel"].' '. $follower["PrenomPersonnel"].'</label>';}
											if($follower["fonctionPersonnel"]=="Praticien") {$praticien = '<label>'.$follower["nomPersonnel"].' '. $follower["PrenomPersonnel"].'</label>';}
										}

									}
									$content.='<td>'.$etudiant.'</td> 
											<td>'.$praticien.'</td>';
											
							}
							$content.='
								  </tbody>
								</table>
							  </div><!-- /.col -->
							</div>';
				return $content;
			}
			else return ;
		
	}
	

	
	public function displayPaymentInfo()
	{
		$content='';
		$param = array('');
		$result = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_PAYEMENT_INFO, $param);
		
		if(sizeOf($result)>0){

			$content .= '<div class="row">
								<div class="col-xs-12">
									<div class="box">
										<div class="box-header">
											<i class="fa fa-folder"></i>
											<h3 class="box-title">Liste des patients n\'ayant pas soldé</h3>
											<div class="pull-right box-tools">
												<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa fa-plus"></i></button>
												<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
											</div>
										</div>
									<div class="box-body">
					<table id="filtredTable" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Date</th>
						<th>Dossier</th>
						<th>Patient</th>
						<th>Acte</th>
						<th>Etat</th>
						<th>Montant Total</th>
						<th>Versement Total</th>
					</tr>
				</thead>
				<tbody>';
				foreach ($result as $data){
				if($data['coutPoser'] == $data['totalVersement']){
					continue;
				}
				$etat = ($data['etatPoser'] == 0) ? 'effectué' : 'en attente';
					$content.= '<tr>'.
						'<td>' . $data['datePoser'] . '</td>'.
						'<td>' . $data['NumDossier'] . '</td>'.
						'<td>' . $data['nomPatient'] . ' '. $data['PrenomPatient'] . '</td>'.
						'<td>' . $data['designationActe'] . '</td>'.
						'<td>' . $etat . '</td>'.
						'<td>' . $data['coutPoser'] . '</td>'.
						'<td>' . $data['totalVersement'] . '</td>'.
					'</tr>';
				}
			
				$content .='
				</tbody>
					<tfoot>
					<tr>
						<th>Date</th>
						<th>Dossier</th>
						<th>Patient</th>
						<th>Acte</th>
						<th>Etat</th>
						<th>Montant Total</th>
						<th>Versement Total</th>
					</tr>
					</tfoot>
				</table>
				</div></div></div></div>';
		}else {
			$content .= ' <div class="alert alert-info alert-dismissable"><i class="icon fa fa-info-circle"></i> Aucun acte effectué </div>';
		}
			return $content;
	}
}
?>
