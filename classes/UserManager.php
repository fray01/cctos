<?php
class UserManager
{
	
	CONST SQL_SELECT_ALL_FIELDS_BY_ID = 'SELECT * FROM personnel WHERE idPersonnel = :idPersonnel';
	CONST SQL_ADD_PERSONNEL = 'INSERT INTO `personnel` (
			 `matriculePersonnel`, 			
			 `nomPersonnel`, 
			`PrenomPersonnel`,
			 `DDNPersonnel`, 
			`sexePersonnel`, 
			`fonctionPersonnel`, 
			`contactPersonnel`, 
			`adressePersonnel`, 
			`vignettePersonnel`
			)
		VALUES
			(
				:matriculePersonnel,
				:nomPersonnel,
				:PrenomPersonnel,
				:DDNPersonnel,
				:sexePersonnel,
				:fonctionPersonnel,
				:contactPersonnel,
				:adressePersonnel,
				:vignettePersonnel
			)';
	
	CONST SQL_SELECT_MEMBERS_ALL_FIELDS = 'SELECT * FROM parent WHERE idParent = :idParent';	
	
	CONST SQL_SELECT_EMPLOYEE_ACTIVITIES = 'SELECT poser.*, acte.designationActe, service.nomService, patient.numDossier
		FROM poser, acte, service, patient
		WHERE poser.idActe = acte.idActe
		AND acte.idService = service.idService
		AND poser.numDossier = patient.numDossier
		AND poser.etatPoser = 0
		AND (poser.idPraticien = :idPersonnel OR poser.idEtudiant = :idPersonnel)';
	
	CONST SQL_SELECT_EMPLOYEE_STAT = 'SELECT COUNT(poser.idPoser) as resultat, service.nomService
		FROM poser, acte, service
		WHERE (poser.idPraticien = :idPersonnel OR poser.idEtudiant = :idPersonnel)
		AND acte.idService = service.idService
		AND poser.idActe = acte.idActe
		GROUP BY service.idService';
	CONST SQL_SELECT_EMPLOYEE_IN_TODAY = 'SELECT DISTINCT etre.*
		FROM etre 
        WHERE date(etre.dateEntree) = CURRENT_DATE
		AND etre.dateSortie IS NULL
		AND etre.idPersonnel = :idPersonnel
		GROUP BY etre.idEtre DESC';
	
	CONST SQL_ADD_PERSONNEL_FAMILY = 'INSERT INTO `parent` (
			nomParent, 
			DDNParent, 
			lienParent,
			idPersonnel,
			vignetteParent
			)
		VALUES
			(
			:nomParent, 
			:DDNParent, 
			:lienParent,
			:idPersonnel,
			:vignetteParent
			)';
	CONST SQL_UPDATE_PERSONNEL_FAMILY = 'UPDATE parent
			SET nomParent = :nomParent,
				DDNParent = :DDNParent, 
				lienParent = :lienParent, 
				idPersonnel = :idPersonnel,
				vignetteParent = :vignetteParent
			WHERE idParent = :idParent';
	
	CONST SQL_UPDATE_EMPLOYEE = 'UPDATE personnel
			SET nomPersonnel = :nomPersonnel,
				matriculePersonnel = :matriculePersonnel,
				PrenomPersonnel = :PrenomPersonnel, 
				DDNPersonnel = :DDNPersonnel, 
				sexePersonnel = :sexePersonnel, 
				fonctionPersonnel = :fonctionPersonnel, 
				contactPersonnel = :contactPersonnel,
				adressePersonnel = :adressePersonnel,
				vignettePersonnel = :vignettePersonnel
			WHERE idPersonnel = :idPersonnel';
	
	CONST SQL_SELECT_ALL_EMPLOYEE = 'SELECT *
			FROM personnel';
	
	
	CONST SQL_SELECT_COUNT_ALL_EMPLOYEE = 'SELECT COUNT(idPersonnel) as resultat FROM personnel';
	CONST SQL_SELECT_ALL_MEMBERS = 'SELECT * FROM parent
			WHERE idPersonnel = :idPersonnel';
	
	CONST SQL_SELECT_EMPLOYEE_TOTAL_IN_OUT = 'SELECT count(idEtre) as resultat FROM etre ';
	CONST SQL_SELECT_EMPLOYEE_IN_OUT = 'SELECT etre.*, 
			service.*, 
			personnel.*
			FROM etre, service, personnel
			WHERE etre.idPersonnel = personnel.idPersonnel
			AND etre.idService = service.idService';
	
	CONST SQL_SELECT_EMPLOYEE_TOTAL_TODAY_IN_OUT = 'SELECT count(idEtre) as resultat 
			FROM etre , personnel
			WHERE etre.idPersonnel = personnel.idPersonnel
			AND date(etre.dateEntree) = CURDATE()';
// 	CONST SQL_SELECT_EMPLOYEE_TODAY_IN_OUT ='SELECT etre.*,
// 		service.*, 
// 		personnel.* 
// 		FROM etre, service, personnel 
// 		WHERE etre.idPersonnel = personnel.idPersonnel 
// 		AND etre.idService = service.idService 
// 		AND date(etre.dateEntree) = CURDATE()';
	
	CONST SQL_SELECT_EMPLOYEE_TODAY_IN_OUT ='SELECT etre.*,
		personnel.* 
		FROM etre, personnel 
		WHERE etre.idPersonnel = personnel.idPersonnel 
		AND date(etre.dateEntree) = CURDATE()';
	
	CONST SQL_ADD_PERSONNEL_TIME_IN = 'INSERT INTO etre 
			(
				dateEntree,
				idPersonnel
			)
			VALUES(
				NOW(),
				:idPersonnel
			)';

	CONST SQL_UPDATE_PERSONNEL_TIME_OUT = 'UPDATE etre 
			SET dateSortie = NOW()
			WHERE idEtre = :idEtre';

	CONST SQL_SELECT_IN_OUT_BY_ID = 'SELECT * FROM etre WHERE idEtre = :idEtre';

// 	CONST SQL_SELECT_PERSONNEL_IN_GROUPBY_SERVICE = 'SELECT COUNT(personnel.idPersonnel) AS personne, service.abreviationService AS service
// 		FROM service, personnel LEFT JOIN etre
// 		ON personnel.idPersonnel = etre.idPersonnel
// 		WHERE etre.idService = service.idService
// 		AND DATE(etre.dateEntree) = DATE_FORMAT(CURRENT_DATE ,\'%Y-%m-%d\')
// 		AND etre.dateSortie IS NULL
// 		GROUP BY service.idService';	
		
	CONST SQL_SELECT_PERSONNEL_IN_GROUPBY_SERVICE = 'SELECT COUNT(personnel.idPersonnel) AS personne FROM personnel LEFT JOIN etre
		ON personnel.idPersonnel = etre.idPersonnel
		WHERE DATE(etre.dateEntree) = DATE_FORMAT(CURRENT_DATE ,"%Y-%m-%d")
		AND etre.dateSortie IS NULL';
	
	public $pdoQuery;
	public $data;
	public $error;
	
	private $pdoStatement;
	CONST DEFAULTPICTURE = 'default.jpg';
	public $dot = '../';
	public $picturePath = 'upload/picturefolder/';

	public function __construct()
	{
		$this->pdoQuery = new PdoExecuteQuery();
		$this->error = new ErrorsManager();
		
// 		$this->uploadFile = new UploadFile();
	}
	
	private function isDateFormat($formatInitial, $formatFinal, $string)
	{
		$date = date_create_from_format($formatInitial, $string);
		$date = !empty($date) ? date_format($date, $formatFinal) : '';
		return   $date;
	}
	
	private function setPicturePath($path)
	{
		$this->picturePath = $path;
	}
	
	private function getPicturePath()
	{
		return $this->picturePath;
	}
	private function isFormSubmit($formname){
		return (isset($_POST['formname']) && ($_POST['formname'])==$formname);
	}
	
	private function getAvatar($files, $path)
	{
// 		$files = $_FILES['vignette'];
		$uploadFile = new UploadFile();
		$uploadFile->setDestination($path);
		$uploadFile->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png', 'pdf'));
		if (isset($files) && !empty($files['name'])){
			$uploadFile->setNewFileName($files['name']);
			$uploadFile->upload($files);
			$filename = $uploadFile->getNewFileName();
		}
		else{
			$uploadFile->setNewFileName(self::DEFAULTPICTURE);
			$filename = $uploadFile->getNewFileName();
		}
		return $uploadFile->getDestination().'/'.$filename;
	}
	
	public function addEmployee()
	{
		if ($this->isFormSubmit('addPersonnel')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['submit']);
			$formValidation->setDataFilter(array(
					'nomPersonnel' => FILTER_UNSAFE_RAW,
					'matriculePersonnel' => FILTER_UNSAFE_RAW,
					'PrenomPersonnel' => FILTER_UNSAFE_RAW,
					'DDNPersonnel' => FILTER_SANITIZE_STRING,
					'sexePersonnel' => FILTER_SANITIZE_STRING,
					'fonctionPersonnel' => FILTER_SANITIZE_ENCODED,
					'contactPersonnel' => FILTER_SANITIZE_ENCODED,
					'adressePersonnel' => FILTER_SANITIZE_STRING,
					'vignettePersonnel' => FILTER_UNSAFE_RAW,
			));
			
			$filepath = $this->getAvatar($_FILES['vignette'], 'upload/picturefolder/');
			$data = array(
					'nomPersonnel' => ucwords(strip_tags($_POST['nom'])),
					'matriculePersonnel' =>strtoupper(strip_tags($_POST['matricule'])),
					'PrenomPersonnel' => ucwords(strip_tags($_POST['prenom'])),
					'DDNPersonnel' => $_POST['ddn'],
					'sexePersonnel' => $_POST['sexe'],
					'fonctionPersonnel' => ucwords(strtolower($_POST['fonction'])),
					'contactPersonnel' => (string)$_POST['contact'],
					'adressePersonnel' => (string)$_POST['adresse'],
					'vignettePersonnel' => $filepath,
			);
			
			$data = $formValidation->getFilteredData($data);
			$bool = $this->pdoQuery->executePdoQuery(self::SQL_ADD_PERSONNEL, $data);
			return $this->error->isErrorMsg($bool, 'Enregistrement');
		}
		else return;
	}
	
	public function updateEmployee()
	{
		if ($this->isFormSubmit('updatePersonnel')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['update']);
			$formValidation->setDataFilter(array(
					'idPersonnel' => FILTER_SANITIZE_NUMBER_INT,
					'matriculePersonnel' => FILTER_UNSAFE_RAW,
					'nomPersonnel' => FILTER_UNSAFE_RAW,
					'PrenomPersonnel' => FILTER_UNSAFE_RAW,
					'DDNPersonnel' => FILTER_SANITIZE_STRING,
					'sexePersonnel' => FILTER_SANITIZE_STRING,
					'fonctionPersonnel' => FILTER_SANITIZE_ENCODED,
					'contactPersonnel' => FILTER_SANITIZE_ENCODED,
					'adressePersonnel' => FILTER_SANITIZE_STRING,
					'vignettePersonnel' => FILTER_UNSAFE_RAW,
			));
			$data = array(
					'idPersonnel' => (int)$_POST['idPersonnel'],
					'matriculePersonnel' =>strtoupper(strip_tags(strtolower($_POST['matricule']))),
					'nomPersonnel' => ucwords(strip_tags($_POST['nom'])),
					'PrenomPersonnel' => ucwords(strip_tags($_POST['prenom'])),
					'DDNPersonnel' => $_POST['ddn'],
					'sexePersonnel' => $_POST['sexe'],
					'fonctionPersonnel' => ucwords(strtolower($_POST['fonction'])),
					'contactPersonnel' => (string)$_POST['contact'],
					'adressePersonnel' => (string)$_POST['adresse'],
// 					'vignettePersonnel' => (string)$_POST['vignette']
			);
			
			if (file_exists($this->dot.$_POST['fileUpload'])){
				$picture = explode($this->picturePath, $_POST['fileUpload']);
				
				if(!empty($_FILES['vignette']['name'])){
					if($_FILES['vignette']['name'] <> $picture[1]){
						$filepath = $this->getAvatar($_FILES['vignette'], 'upload/picturefolder/');
						unset($_POST['fileUpload']);
					}
					else $filepath = $_POST['fileUpload'];
				}
				else {
					$filepath = $_POST['fileUpload'];
				}
				
				$data['vignettePersonnel'] = $filepath;
				$data = $formValidation->getFilteredData($data);
				$bool = $this->pdoQuery->executePdoQuery(self::SQL_UPDATE_EMPLOYEE, $data);
				return $this->error->isErrorMsg($bool, 'Modification');
				
			}
			else return;
		}
		else return;
		
	}
	
	public function readEmployee($idPersonnel)
	{
		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_ALL_FIELDS_BY_ID,
				array(
					'idPersonnel' => $idPersonnel,
				));
		foreach ($this->pdoStatement as $data){
			return $data;
		}
		
	}

	public function readAffiliation($idParent)
	{
			$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_MEMBERS_ALL_FIELDS,
				array(
					'idParent' => $idParent,
				));
		foreach ($this->pdoStatement as $data){
			return $data;
		}
		
	}
	
	public function optionFonction($idPersonnel)
	{
		$fonctions = array(
				"Praticien" => "Praticien",
				"Etudiant" => "Etudiant",
				"Autres" => "Autres"
		);
		foreach ($fonctions as $key => $data){
			if ( $data == $idPersonnel ){
				echo '<option value="' . $fonctions[$key] . '" selected/>' . $data . '</option>';
			}
			else
				echo '<option value="' . $fonctions[$key] . '">' . $data . '</option>';
			}
		}
		
		
	public function optionPersonnel()
	{
		$option = '';
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_ALL_EMPLOYEE);
		if ($this->pdoStatement){
			foreach ($this->pdoStatement as $data){
				$option .= '<option value="' . $data['idPersonnel'] . '" >' . $data['nomPersonnel'] . ' '. $data['PrenomPersonnel']. ' -- ('. $data['matriculePersonnel']. ')</option>';
			}
		}
		else $option .= '<option value="" > ----------------- </option>';
		return $option;
	}
	
	public function optionAffiliation($idParent)
	{
		$affiliations = array(
			"Père"=>"Père",
			"Mère"=>"Mère",
			"Epouse"=>"Epouse",
			"Epoux"=>"Epoux",
			"Enfant"=>"Enfant",
			"Autres"=>"Autres",
		);
		foreach ($affiliations as $key => $data){
			if ( $data == $idParent ){
				echo '<option value="' . $affiliations[$key] . '" selected/>' . $data . '</option>';
			}
			else
				echo '<option value="' . $affiliations[$key] . '">' . $data . '</option>';
		}
		
		
	}
	public function displayEmployees()
	{
		$content='';
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_COUNT_ALL_EMPLOYEE);
		foreach ($this->pdoStatement as $data){
			$resultat = $data['resultat'];
		}
		
		if($resultat<>0){
			$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_ALL_EMPLOYEE);
			$content .= '<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<i class="fa fa-user-md"></i>
							<h3 class="box-title">Liste du personnel</h3>
							<!-- tools box -->
							<div class="box-tools pull-right">
								<a download="personnel.xls" href="#gridAffaire" class="btn btn-info btn-sm " data-toggle="tooltip" onclick="return ExcellentExport.excel(this, \'gridAffaire\', \'Liste du personnel\');">Exportation vers Excel</a>
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
							</div><!-- /. tools -->
						</div>
						<!-- /.box-header -->
						<div class="box-body">
			<table id="gridAffaire" class="table table-bordered table-striped gridAffaire">
				<thead>
					<tr>
						<th>Nom</th>
						<th>Prénoms</th>
						<th>Age</th>
						<th>Sexe</th>
						<th>Profession</th>
						<th>Contact</th>
						<th>Adresse</th>
						<th>Detail</th>
						<th>Operations</th>
					</tr>
				</thead>
				<tbody>';
			if ($this->pdoStatement) {
				foreach ($this->pdoStatement as $data){
					 $content.= '<tr>'.
						 '<td>' . $data['nomPersonnel'] . '</td>'.
						 '<td>' . $data['PrenomPersonnel'] . '</td>'.
						 '<td>' . $this->isDateFormat('Y-m-d', 'd-m-Y',$data['DDNPersonnel']) . '</td>'.
						 '<td>' . $data['sexePersonnel'] . '</td>'.
						 '<td>' . $data['fonctionPersonnel'] . '</td>'.
						 '<td>' . $data['contactPersonnel'] . '</td>'.
						 '<td>' . $data['adressePersonnel'] . '</td>'.
						 '<td><a href="./index.php?p=viewpersonnel&id='. $data['idPersonnel'] .'"><span class="label label-success">Modifier</span></a>'.
						'<td><a href="./index.php?p=personnelfolder&detail='. $data['idPersonnel'] .'"><span class="label label-info">voir plus</span></a></td>'.
						 '</td>'.
					 '</tr>';
				}
			}
			$content .='
				</tbody>
					<tfoot>
						<tr>
							<th>Nom</th>
							<th>Prénoms</th>
							<th>Age</th>
							<th>Sexe</th>
							<th>Profession</th>
							<th>Contact</th>
							<th>Adresse</th>
							<th>Detail</th>
							<th>Operations</th>
						</tr>
					</tfoot>
				</table></div></div></div></div>';
		}
		else {
			$content .='<div class="alert alert-info alert-dismissable"><i class="icon fa fa-info-circle"></i> Aucune liste disponible</div>';
		}
		return $content;
	}
	public function displayEmployeesFamilyMembers($idPersonnel, $matriculePersonnel,$nomPersonnel, $prenomPersonnel)
	{
		$content='';
		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_ALL_MEMBERS,array(
				'idPersonnel' => $idPersonnel));
		if ($this->pdoStatement) {
			$content .= '<div class="row">
								<div class="col-xs-12">
									<div class="box box-info collapsed-box">
										<div class="box-header">
											<i class="fa fa-folder"></i>
											<h3 class="box-title">Personnes afiliées</h3>
											<div class="pull-right box-tools">
												<a download="personnel-afiliées('.$nomPersonnel.'-'.$prenomPersonnel.').xls" class="btn btn-info btn-sm" href="#gridAffaire" data-toggle="tooltip" title="exporter vers excel" onclick="return ExcellentExport.excel(this,\'gridAffaire\', \'Ayant droits '.$nomPersonnel.'-'.$prenomPersonnel.'\');">Exporter vers Excel</i></a>
												<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa fa-plus"></i></button>
												<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
											</div>
										</div>
									<div class="box-body">
									<table id="gridAffaire" class="table table-bordered table-striped gridAffaire">
				<thead>
					<tr>
						<th>Nom & Prénoms</th>
						<th>Age</th>
						<th>Type d\'afiliation</th>
						<th>Image</th>
						<th>Operations</th>
					</tr>
				</thead>
				<tbody>';
			foreach ($this->pdoStatement as $data){
				$content.= '<tr>'.
						'<td>' . $data['nomParent'] . '</td>'.
						'<td>' . $this->isDateFormat('Y-m-d', 'd-m-Y',$data['DDNParent']) . '</td>'.
						'<td>' . $data['lienParent'] . '</td>'.
						'<td>
								<a class="image-popup" href="../'.$data['vignetteParent'].'">
								<div class="image">
									<img src="../'.$data['vignetteParent'].'" class="img-circle" alt="User Image" height="32" width="32">
								</div>
								</a>
						</td>'.
						'<td><a href="./index.php?p=personnelfolder&detail='. $data['idPersonnel'] .'&parent='. $data['idParent'] .'"><span class="label label-success">Modifier</span></a>'.
						'</td>'.
					 '</tr>';
			}
			$content .='
				</tbody>
					<tfoot>
						<tr>
							<th>Nom & Prénoms</th>
							<th>Age</th>
							<th>Type d\'afiliation</th>
							<th>Image</th>
							<th>Operations</th>
						</tr>
					</tfoot>
				</table>
				</div></div></div></div>';
		}
		else $content .='<div class="alert alert-info alert-dismissable"><i class="icon fa fa-info-circle"></i> Cet employé ne dispose d\' aucune affiliation </div>';
		return $content;
	}
	public function displayInOut()
	{
		$content='';
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_EMPLOYEE_TOTAL_IN_OUT);
		foreach ($this->pdoStatement as $data){
			$resultat = $data['resultat'];
		}
		if($resultat<>0){
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_EMPLOYEE_IN_OUT);
			$content .= '<div class="row">
								<div class="col-xs-12">
									<div class="box collapsed-box">
										<div class="box-header">
											<i class="fa fa-folder"></i>
											<h3 class="box-title">Historique des présences</h3>
											<div class="pull-right box-tools">
												<a download="liste-de-presence-'.date('d-m-Y').'.xls" class="btn btn-info btn-sm" href="#gridAffaire" data-toggle="tooltip" title="exporter vers excel" onclick="return ExcellentExport.excel(this,\'gridAffaire\', \'Liste de présence imprimé le'.date('d-m-Y').'\');">Exporter vers Excel</i></a>
												<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa fa-plus"></i></button>
												<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
											</div>
										</div>
									<div class="box-body">
								<table id="gridAffaire" class="table table-bordered table-striped gridAffaire">
					<thead>
					<tr>
						<th>Matricule</th>
						<th>Nom & Prénoms</th>
						<th>Entrée le...</th>
						<th>Sortie le...</th>
						<th>Service</th>';
						if($_SESSION['nomService']=="Accueil"){
							$content.='<th>Opération</th></tr>';
						}
						else $content.='</tr>';
						$content.='</thead>
						<tbody>';
				foreach ($this->pdoStatement as $data){
				$content.= '<tr>'.
						'<td>' . $data['matriculePersonnel'] . '</td>'.
						'<td>' . $data['nomPersonnel'] .' '.$data['PrenomPersonnel']. '</td>'.
						'<td>' . $this->isDateFormat('Y-m-d H:i:s', 'd-m-Y H:i:s',$data['dateEntree']) . '</td>'.
						'<td>' . $this->isDateFormat('Y-m-d H:i:s', 'd-m-Y H:i:s',$data['dateSortie']) . '</td>'.
						'<td>' . $data['nomService'] . '</td>';
						if($_SESSION['nomService']=="Accueil"){
							if(empty($data['dateSortie'])){
								$content.='<td><a href="./index.php?p=pointage&detail='. $data['idEtre'] .'">
								<span class="label label-success">Sortir</span></a>';
							}
							else $content.='<td></td></tr>';
						}
						else $content.='</tr>';
			}
			$content .='
				</tbody>
					<tfoot>
						<tr>
							<th>Matricule</th>
							<th>Nom & Prénoms</th>
							<th>Entrée le...</th>
							<th>Sortie le...</th>
							<th>Service</th>';
						if($_SESSION['nomService']=="Accueil"){
							$content.='<th>Opération</th></tr>';
						}
						else $content.='</tr>';
					$content.='</tfoot>
				</table>
				</div></div></div></div>';
		}
		else {
			$content .='<div class="alert alert-info alert-dismissable"><i class="icon fa fa-info-circle"></i> Aucune liste disponible</div>';
		}
		return $content;
	}

	public function displayTodayInOut()
	{
		$content='';
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_EMPLOYEE_TODAY_IN_OUT);
		if(count($this->pdoStatement)<>0){
// 			$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_EMPLOYEE_TODAY_IN_OUT);
			$content .= '<div class="row">
								<div class="col-xs-12">
									<div class="box ">
										<div class="box-header">
											<i class="fa fa-folder"></i>
											<h3 class="box-title">Liste des présences du '.date('d-m-Y').'</h3>
											<div class="pull-right box-tools">
												<a download="liste-de-presence-'.date('d-m-Y').'.xls" class="btn btn-info btn-sm" href="#gridAffaire" data-toggle="tooltip" title="exporter vers excel" onclick="return ExcellentExport.excel(this,\'gridAffaire\', \'Liste de présence du'.date('d-m-Y').'\');">Exporter vers Excel</i></a>
												<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa fa-minus"></i></button>
												<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
											</div>
										</div>
									<div class="box-body">
								<table id="gridAffaire" class="table table-bordered table-striped gridAffaire">
					<thead>
					<tr>
						<th>Matricule</th>
						<th>Nom & Prénoms</th>
						<th>Entrée le...</th>
						<th>Sortie le...</th>';
						if($_SESSION['nomService']=="Accueil"){
							$content.='<th>Opération</th></tr>';
						}
						else $content.='</tr>';
						$content.='</thead>
						<tbody>';
				foreach ($this->pdoStatement as $data){
				$content.= '<tr>'.
						'<td>' . $data['matriculePersonnel'] . '</td>'.
						'<td>' . $data['nomPersonnel'] .' '.$data['PrenomPersonnel']. '</td>'.
						'<td>' . $this->isDateFormat('Y-m-d H:i:s', 'd-m-Y H:i:s',$data['dateEntree']) . '</td>'.
						'<td>' . $this->isDateFormat('Y-m-d H:i:s', 'd-m-Y H:i:s',$data['dateSortie']) . '</td>';
						if($_SESSION['nomService']=="Accueil"){
							if(empty($data['dateSortie'])){
								$content.='<td><a href="./index.php?p=pointage&detail='. $data['idEtre'] .'">
								<span class="label label-success">Sortir</span></a>';
							}
							else $content.='<td></td></tr>';
						}
						else $content.='</tr>';
			}
			$content .='
				</tbody>
					<tfoot>
						<tr>
							<th>Matricule</th>
							<th>Nom & Prénoms</th>
							<th>Entrée le...</th>
							<th>Sortie le...</th>';
						if($_SESSION['nomService']=="Accueil"){
							$content.='<th>Opération</th></tr>';
						}
						else $content.='</tr>';
					$content.='</tfoot>
				</table>
				</div></div></div></div>';
		}
		else {
			$content .='<div class="alert alert-info alert-dismissable"><i class="icon fa fa-info-circle"></i> Aucune liste disponible</div>';
		}
		return $content;
	}
	
	public function addPersonnelNewFamilyMember()
	{
		if ($this->isFormSubmit('addNewMember')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['submit']);
			$formValidation->setDataFilter(array(
					'nomParent' => FILTER_UNSAFE_RAW,
					'DDNParent' => FILTER_SANITIZE_STRING,
					'lienParent' => FILTER_UNSAFE_RAW,
					'idPersonnel' => FILTER_VALIDATE_INT,
					'vignetteParent' => FILTER_UNSAFE_RAW,
			));
			$filepath = $this->getAvatar($_FILES['vignette'], 'upload/picturefamilymembers/');
			$data = array(
					'nomParent' => strip_tags(ucwords($_POST['nomParent'])),
					'DDNParent' => $_POST['DDNParent'],
					'lienParent' => strip_tags(ucwords($_POST['affiliation'])),
					'idPersonnel' => (int)$_POST['idPersonnel'],
					'vignetteParent' => $filepath,
			);
				
			$data = $formValidation->getFilteredData($data);
			$bool = $this->pdoQuery->executePdoQuery(self::SQL_ADD_PERSONNEL_FAMILY, $data);
			return $this->error->isErrorMsg($bool, 'Enregistrement');
		}
		else return;
	}
	
	public function updatePersonnelNewFamilyMember()
	{
		if ($this->isFormSubmit('updateNewMember')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['update']);
			$formValidation->setDataFilter(array(
					'nomParent' => FILTER_UNSAFE_RAW,
					'DDNParent' => FILTER_SANITIZE_STRING,
					'lienParent' => FILTER_UNSAFE_RAW,
					'idPersonnel' => FILTER_VALIDATE_INT,
					'idParent' => FILTER_VALIDATE_INT,
					'vignetteParent' => FILTER_UNSAFE_RAW,
			));
			$data = array(
					'nomParent' => strip_tags(ucwords($_POST['nomParent'])),
					'DDNParent' => $_POST['DDNParent'],
					'lienParent' => strip_tags(ucwords($_POST['affiliation'])),
					'idPersonnel' => (int)$_POST['idPersonnel'],
					'idParent' => (int)$_POST['idParent'],
			);
			
			if (file_exists($this->dot.$_POST['fileUpload'])){
				$this->setPicturePath('upload/picturefamilymembers/');
				$this->picturePath = $this->getPicturePath();
				$picture = explode($this->picturePath, $_POST['fileUpload']);
				
				if(!empty($_FILES['vignette']['name'])){
					if($_FILES['vignette']['name'] <> $picture[1]){
						$filepath = $this->getAvatar($_FILES['vignette'], 'upload/picturefamilymembers/');
						unset($_POST['fileUpload']);
					}
					else $filepath = $_POST['fileUpload'];
				}
				else {
					$filepath = $_POST['fileUpload'];
				}
					
				$data['vignetteParent'] = $filepath;
				$data = $formValidation->getFilteredData($data);
				$bool = $this->pdoQuery->executePdoQuery(self::SQL_UPDATE_PERSONNEL_FAMILY, $data);
				return $this->error->isErrorMsg($bool, 'Modification');
		}
		else return;
	}
	else return;
}
		
	public function isOn()
	{
		if ($this->isFormSubmit('entree')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['submit']);
			$formValidation->setDataFilter(array(
					'idPersonnel' => FILTER_VALIDATE_INT,
// 					'idService' => FILTER_VALIDATE_INT,
			));
			$data = array(
				'idPersonnel' => (int)$_POST['idPersonnel'],
// 				'idService' => (int)$_POST['idService'],
				);
				
			$data = $formValidation->getFilteredData($data);
			$bool = $this->pdoQuery->executePdoQuery(self::SQL_ADD_PERSONNEL_TIME_IN, $data);
			return $this->error->isErrorMsg($bool, 'Pointage d\'entrée ');
		}
		else return;
	}
	
	public function isOut($idEtre)
	{
		$formValidation = new FormFieldValidation();
		unset($_POST['formname']);
		unset($_POST['update']);
		$formValidation->setDataFilter(array(
			'idEtre' => FILTER_VALIDATE_INT,
		));
		$data = array(
			'idEtre' => (int)$idEtre,
		);
		$data = $formValidation->getFilteredData($data);
		$bool = $this->pdoQuery->executePdoQuery(self::SQL_UPDATE_PERSONNEL_TIME_OUT, $data);
		return $this->error->isErrorMsg($bool, 'Pointage de sortie');
	}
	
	public function readInOut($idEtre)
	{
		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_IN_OUT_BY_ID,
			array(
				'idEtre' => $idEtre,
			));
		foreach ($this->pdoStatement as $data){
			return $data;
		}
	
	}
	
// 	public function displayPersonnelIn()
// 	{
// 		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_PERSONNEL_IN_GROUPBY_SERVICE,array(''));
// 		$content='<div class="col-md-5">';
// 		$init = '<div class="info-box bg-purple"><span class="info-box-icon"><i class="fa fa-user-md"></i></span><div class="info-box-content"><span class="info-box-text">aucun service actif</span></div></div>';
// 		foreach ($this->pdoStatement as $data){
// 		$init='';
// 			$content.='<div class="info-box bg-purple">'
// 			. '<span class="info-box-icon"><i class="fa fa-user-md"></i></span>'
// 			. '<div class="info-box-content">'
// 			. '<span class="info-box-text">'.$data['service'].'</span>'
// 			. '<span class="info-box-number">'.$data['personne'].' Personnes</span>'
// 			. '</div>'
// 			. '</div>';
// 		}
// 		$content.=$init;
// 		$content.='</div>';
// 		return $content;
// 	}
	
	public function displayPersonnelIn()
	{
		$pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_PERSONNEL_IN_GROUPBY_SERVICE);
		$content='<div class="col-md-5">';
		foreach ($pdoStatement as $data){
			$resultat = $data['personne'];
		}
		$data = $pdoStatement;
		if ((int)$resultat <> 0){
			$content.='<div class="info-box bg-purple">'
			. '<span class="info-box-icon"><i class="fa fa-user-md"></i></span>'
			. '<div class="info-box-content">'
// 			. '<span class="info-box-text">'.$data['service'].'</span>'
			. '<span class="info-box-number">'.$resultat.' Personne(s) disponible(s)</span>'
			. '</div>'
			. '</div>';
		}
		else{
			$content .= '<div class="info-box bg-purple"><span class="info-box-icon"><i class="fa fa-user-md"></i></span><div class="info-box-content"><span class="info-box-text">aucun service actif</span></div></div>';
		}
		
		$content.='</div>';
		return $content;
	}
	
	public function displayPersonnel()
	{
		$content='';
		$result = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_ALL_EMPLOYEE);
		$nb = sizeOf($result);
		if($nb>0){
			$content .= '<div class="row">
								<div class="col-xs-12">
									<div class="box ">
										<div class="box-header">
											<i class="fa fa-folder"></i>
											<h3 class="box-title">Liste de présence du '.date('d-m-Y').'</h3>
											<div class="pull-right box-tools">
												<a id="bEntrer" href="#entrer" class="hide open-popup-link"data-toggle="tooltip"></a>
												<a download="liste-de-presence-'.date('d-m-Y').'.xls" class="btn btn-info btn-sm" href="#gridAffaire" data-toggle="tooltip" title="exporter vers excel" onclick="return ExcellentExport.excel(this,\'gridAffaire\', \'Liste de présence imprimé le'.date('d-m-Y').'\');">Exporter vers Excel</i></a>
												<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa fa-minus"></i></button>
												<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
											</div>
										</div>
									<div class="box-body">
								<table id="gridAffaire" class="table table-bordered table-striped gridAffaire">
					<thead>
					<tr>
						<th>Matricule</th>
						<th>Nom & Prénoms</th>
						<th>Entrée le...</th>
						<th>Sortie le...</th>';
						if($_SESSION['nomService']=="Accueil"){
							$content.='<th>Opération</th></tr>';
						}
						else $content.='</tr>';
						$content.='</thead>
						<tbody>';
				foreach ($result as $data){
						$personnelIn = $this->personnelIn($data['idPersonnel']);
							$dateEntree = '';
							$dateSortie = '';
							$nomService = '';
							$idEtre = 0;
							$bOperation = '<a href="./index.php?p=pointage&entrer='. $data['idPersonnel'] .'">
								<span class="label label-success">Faire Entrer</span></a>';
						if($personnelIn!=null){
							$dateEntree = $this->isDateFormat('Y-m-d H:i:s', 'd-m-Y H:i:s',$personnelIn['dateEntree']);
							$dateSortie =$this->isDateFormat('Y-m-d H:i:s', 'd-m-Y H:i:s',$personnelIn['dateSortie']);
// 							$nomService = $personnelIn['nomService'];
							$idEtre = $personnelIn['idEtre'];
							$bOperation = '<a href="./index.php?p=pointage&sortir='.$idEtre.'">
								<span class="label label-danger">Faire Sortir</span></a>';
						}

				$content.= '<tr>'.
						'<td>' . $data['matriculePersonnel'] . '</td>'.
						'<td>' . $data['nomPersonnel'] .' '.$data['PrenomPersonnel']. '</td>'.
						'<td>' . $dateEntree . '</td>'.
						'<td>' . $dateSortie . '</td>';
						if($_SESSION['nomService']=="Accueil"){
							if(empty($data['dateSortie'])){
								$content.='<td>'.$bOperation;
							}
							else $content.='<td></td></tr>';
						}
						else $content.='</tr>';
			}
			$content .='
				</tbody>
					<tfoot>
						<tr>
							<th>Matricule</th>
							<th>Nom & Prénoms</th>
							<th>Entrée le...</th>
							<th>Sortie le...</th>';
						if($_SESSION['nomService']=="Accueil"){
							$content.='<th>Opération</th></tr>';
						}
						else $content.='</tr>';
					$content.='</tfoot>
				</table>
				</div></div></div></div>';
		}
		else {
			$content .='<div class="alert alert-info alert-dismissable"><i class="icon fa fa-info-circle"></i> Aucune liste disponible</div>';
		}
		return $content;
	}
	
	
	public function personnelIn($idPersonnel)
	{
	
		$param = array(
			"idPersonnel"=>$idPersonnel,
		);
		$result = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_EMPLOYEE_IN_TODAY, $param);
		$personnelInfo = null;
		foreach ($result as $data){
			$personnelInfo = $data;
		}
		return $personnelInfo;
		
	}
		
	public function displayPersonnelActivities($idPersonnel, $nomPersonnel, $prenomPersonnel)
	{
	$param = array(
		'idPersonnel' => $idPersonnel
	);
		$content='';
		$result = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_EMPLOYEE_ACTIVITIES, $param);
		$nb = sizeOf($result);
		if($nb>0){
			$content .= '<div class="row">
								<div class="col-xs-12">
									<div class="box box-warning box collapsed-box">
										<div class="box-header">
											<i class="fa fa-folder"></i>
											<h3 class="box-title">Historique activités</h3>
											<div class="pull-right box-tools">
												<a download="fiche-activité-('.$nomPersonnel.'-'.$prenomPersonnel.').xls" class="btn btn-info btn-sm" href="#gridAffaire-activite" data-toggle="tooltip" title="exporter vers excel" onclick="return ExcellentExport.excel(this,\'gridAffaire-activite\', \'suivie acte '.$nomPersonnel.'-'.$prenomPersonnel.'\');">Exporter vers Excel</i></a>
												<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa fa-plus"></i></button>
												<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
											</div>
										</div>
									<div class="box-body">
								<table id="gridAffaire-activite" class="table table-bordered table-striped gridAffaire">
					<thead>
					<tr>
						<th>Date</th>
						<th>Acte</th>
						<th>Service</th>
						<th>Numéro dossier</th>
					</tr>';
					$content.='</thead>
						<tbody>';
				foreach ($result as $data){

				$content.= '<tr>'.
						'<td>' . $this->isDateFormat('Y-m-d H:i:s', 'd-m-Y H:i:s',$data['datePoser']) . '</td>'.
						'<td>' . $data['designationActe'] .'</td>'.
						'<td>' . $data['nomService'] . '</td>'.
						'<td><a href="./index.php?p=patientfolder&detail='. $data['numDossier'] .'">'. $data['numDossier'] .' >> </a></td>
						</tr>';
			}
			$content .='
				</tbody>
					<tfoot>
					<tr>
						<th>Date</th>
						<th>Acte</th>
						<th>Service</th>
						<th>Numéro dossier</th>
					</tr>';
					$content.='</tfoot>
				</table>
				</div></div></div></div>';
		}
		else {
			$content .='<div class="alert alert-info alert-dismissable"><i class="icon fa fa-info-circle"></i> Aucune activité à ce jour</div>';
		}
		return $content;
	}

	public function displayPersonnelStat($idPersonnel,$nomPersonnel, $prenomPersonnel)
	{
		$content='';
		$param = array(
				'idPersonnel' => $idPersonnel
		);
		
		$result = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_EMPLOYEE_STAT, $param);
		$nb = sizeOf($result);
		if($nb>0){
			$content .= '<div class="row">
								<div class="col-xs-12">
									<div class="box collapsed-box">
										<div class="box-header">
											<i class="fa fa-folder"></i>
											<h3 class="box-title">Total des interventions par service</h3>
											<div class="pull-right box-tools">
												<a download="fiche-suivie-('.$nomPersonnel.'-'.$prenomPersonnel.').xls" class="btn btn-info btn-sm" href="#gridAffaire-stat" data-toggle="tooltip" title="exporter vers excel" onclick="return ExcellentExport.excel(this,\'gridAffaire-stat\', \'suivie acte '.$nomPersonnel.'-'.$prenomPersonnel.'\');">Exporter vers Excel</i></a>
												<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa fa-plus"></i></button>
												<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
											</div>
										</div>
									<div class="box-body">
								<table id="gridAffaire-stat" class="table table-bordered table-striped gridAffaire">
					<thead>
					<tr>
						<th>Service</th>
						<th>Total acte effectué </th>
					</tr>';
			$content.='</thead>
						<tbody>';
			foreach ($result as $data){
	
				$content.= '<tr>'.
						'<td>' . $data['nomService'] . '</td>'.
						'<td>' . $data['resultat'] .'</td>'.
						'</tr>';
			}
			$content .='
				</tbody>
					<tfoot>
					<tr>
						<th>Service</th>
						<th>Total acte effectué </th>
					</tr>';
			$content.='</tfoot>
				</table>
				</div></div></div></div>';
		}
		else {
			$content .='<div class="alert alert-info alert-dismissable"><i class="icon fa fa-info-circle"></i> Aucune opération effectuée à ce jour</div>';
		}
		return $content;
	}
}
?>