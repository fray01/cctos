<?php
class ServiceManager
{
/*********************BEGIN DECLARE SQL CONST********************/
	CONST SQL_ADD_SERVICE = 'INSERT INTO service(abreviationService, nomService) 
			VALUES(:abreviationService, :nomService)';
	
	CONST SQL_UPDATE_SERVICE = 'UPDATE service 
			SET abreviationService = :abreviationService,
			nomService = :nomService
			WHERE idService = :idService';
	CONST SQL_DELETE_SERVICE = 'DELETE FROM service WHERE idService = :idService';
	
	CONST SQL_SELECT_ALL_FIELDS_BY_ID = 'SELECT * FROM service WHERE idService = :idService';

	CONST SQL_SELECT_ALL_SERVICES = 'SELECT * FROM service';
/*********************END DECLARE CONST********************/

/*********************BEGIN DECLARE PUBLIC & PRIVATE********************/
	private $pdoStatement;
	
	public $data;
	public $pdoQuery;
	public $error;
	private $acte;
	
/*********************END DECLARE********************/
	
	public function __construct(){
		$this->pdoQuery = new PdoExecuteQuery();
		$this->acte = new SettingsManager();
		$this->error = new ErrorsManager();
	}
		
	private function isFormSubmit($formname){
		return (isset($_POST['formname']) && ($_POST['formname'])==$formname);
	}
	
	public function addNewService()
	{
		if ($this->isFormSubmit('addService') || $this->isFormSubmit('addService')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['submit']);
			$formValidation->setDataFilter(array(
					'abreviationService' => FILTER_UNSAFE_RAW,
					'nomService' => FILTER_UNSAFE_RAW,
			));
			$data = array(
					'abreviationService' => strtoupper($_POST['abreviation']),
					'nomService' => (string)strip_tags(ucwords($_POST['libelle'])),
			);
				
			$data = $formValidation->getFilteredData($data);
			$bool = $this->pdoQuery->executePdoQuery(self::SQL_ADD_SERVICE, $data);
				return $this->error->isErrorMsg($bool, 'Enregistrement');
			}
		else return;
	}		

	public function updateService()
	{
		if ($this->isFormSubmit('updateService') || $this->isFormSubmit('updateService')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['update']);
			$formValidation->setDataFilter(array(
					'idService' => FILTER_SANITIZE_NUMBER_INT,
					'abreviationService' => FILTER_UNSAFE_RAW,
					'nomService' => FILTER_UNSAFE_RAW,
			));
			$data = array(
					'idService' =>(int)$_POST['idService'],
					'abreviationService' => strtoupper($_POST['abreviation']),
					'nomService' => (string)strip_tags(ucwords($_POST['libelle'])),
			);
		
			$data = $formValidation->getFilteredData($data);
			$bool = $this->pdoQuery->executePdoQuery(self::SQL_UPDATE_SERVICE, $data);
			return $this->error->isErrorMsg($bool, 'Modification');
			}
		else return;
		
	}
	
	public function deleteService()
	{
		
	}

	public function readService($idService)
	{
		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_ALL_FIELDS_BY_ID,
			array(
				'idService' => $idService,
			));
		foreach ($this->pdoStatement as $data){
			return $data;
		}
	}

	public function displayServices()
	{
		$content='';
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_ALL_SERVICES);
		$content .= '<table id="gridAffaire" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Abréviation</th>
					<th>Libellé</th>
					<th>Opérations</th>
				</tr>
			</thead>
			<tbody>';
		if ($this->pdoStatement) {
			foreach ($this->pdoStatement as $data){
				 $content.= '<tr>'.
					'<td>' . $data['abreviationService'] . '</td>'.
					'<td>' . $data['nomService'] . '</td>'.
					'<td><a href="./index.php?p=viewservice&id='. $data['idService'] .'"><span class="label label-success">Modifier</span></a>
	 				</td>'.
				 '</tr>';
			}
		}
		$content .='
			</tbody>
				<tfoot>
					<tr>
						<th>Abréviation</th>
						<th>Libellé</th>
						<th>Opérations</th>
					</tr>
				</tfoot>
			</table>';
		return $content;
	}
	
	public function displayFolderByServices()
	{
		$content='';
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_ALL_SERVICES);
// 		$content .= '';
		if ($this->pdoStatement) {
			foreach ($this->pdoStatement as $data){
				$content.= '
						<div class="row">
							<div class="col-xs-12">
								<div class="box collapsed-box">
									<div class="box-header">
										<i class="fa fa-folder"></i>
										<h3 class="box-title">Dossier '. $data['nomService'] .'</h3>
										<div class="pull-right box-tools">
											<a href="#addActe" class="btn btn-info btn-sm open-popup-link"data-toggle="tooltip"> Effectuer un Acte</a>
											<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa fa-plus"></i></button>
											<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
										</div>
									</div>
									<div class="box-body">
									</div>
									<div class="box-footer clearfix">
										<div class="row">
											  <div class="col-xs-4">
												<label> Nom Praticien :  </label> 
											  </div>
											  <div class="col-xs-4">
												<label> Nom de l\'étudiant : </label>
											  </div>
										</div>
									</div>
								</div>
							</div>
						</div>';
			}
		}
		return $content ;
	}
	
	public function optionServices($idService)
	{
		$option = '';
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_ALL_SERVICES);
		if ($this->pdoStatement){
			foreach ($this->pdoStatement as $data){
				if ( $data['idService'] == $idService ){
					$option .='<option value="' . $data['idService'] . '" selected/>' . $data['nomService'] . '</option>';
				}
				else
					$option .= '<option value="' . $data['idService'] . '" >' . $data['nomService'] . '</option>';
			}
		}
		else $option .= '<option value="" > ------- Aucun service --------- </option>';
		return $option;
	}
	
}
?>