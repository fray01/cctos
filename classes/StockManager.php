<?php
class StockManager
{

	CONST SQL_SELECT_ALL_STOCK = 'SELECT * FROM stock';
	CONST SQL_SELECT_ALL_STOCK_AVALAIBLE = 'SELECT * FROM stock 
			WHERE qteStock>0';
	CONST SQL_SELECT_STOCK_USE = 'SELECT sortie.* , designationStock, nomBatiment
			FROM sortie, stock, batiment
			WHERE sortie.idStock = stock.idStock
			AND sortie.idBatiment = batiment.idBatiment
			AND sortie.idBatiment = :idBatiment';
	CONST SQL_SELECT_ALL_STOCK_BY_ID = 'SELECT * FROM stock
			WHERE idStock = :idStock';	
	CONST SQL_SELECT_ALL_SORTIE_BY_ID = 'SELECT * FROM sortie
			WHERE idSortie = :idSortie';
	CONST SQL_ADD_PRODUIT = 'INSERT INTO 
			stock(designationStock, niveauAlerte)
			VALUES (:designationStock, :niveauAlerte)';
	CONST SQL_UPDATE_PRODUIT = 'UPDATE stock 
			SET designationStock = :designationStock,
			niveauAlerte = :niveauAlerte
			WHERE idStock = :idStock';
	CONST SQL_ENTREE_PRODUIT = 'INSERT INTO 
			entree(qteEntree, idStock)
			VALUES (:qte, :idStock)';
	CONST SQL_SORTIE_PRODUIT = 'INSERT INTO 
			sortie(idBatiment, qteSortie, qteActuelle, idStock)
			VALUES (:idBatiment, :qte, :qte, :idStock)';
	CONST SQL_INCREASE_PRODUIT = 'UPDATE stock 
			SET qteStock = qteStock + :qte
			WHERE idStock = :idStock';
	CONST SQL_DECREASE_PRODUIT = 'UPDATE stock 
			SET qteStock = qteStock - :qte
			WHERE idStock = :idStock';
	CONST SQL_SELECT_ALL_BATIMENT = 'SELECT * FROM batiment';
	
	CONST SQL_SELECT_ALL_IN = 'SELECT entree.* , designationStock
			FROM entree, stock
			WHERE entree.idStock = stock.idStock';
	CONST SQL_SELECT_COUNT_ALL_IN = 'SELECT COUNT(idEntree) as resultat FROM entree,stock
			WHERE entree.idStock = stock.idStock';
	
	CONST SQL_SELECT_ALL_OUT = 'SELECT sortie.* , designationStock, nomBatiment
			FROM sortie, stock, batiment
			WHERE sortie.idStock = stock.idStock
			AND sortie.idBatiment = batiment.idBatiment';
	
	CONST SQL_SELECT_COUNT_ALL_OUT = 'SELECT COUNT(idSortie) as resultat 
			FROM sortie, stock, batiment
			WHERE sortie.idStock = stock.idStock
			AND sortie.idBatiment = batiment.idBatiment';
	
	CONST SQL_SELECT_STOCK_AVALAIBLE_BY_BATIM = 'SELECT DISTINCT stock.*, sortie.qteSortie, sortie.qteSortie
			FROM stock, sortie
			WHERE sortie.idStock = stock.idStock
			AND sortie.idBatiment = :idBatiment
			AND sortie.qteActuelle > 0';
	CONST SQL_USE_SORTIE = 'UPDATE sortie 
			SET qteActuelle = qteActuelle - :qte
			WHERE idSortie = :idSortie';
	
	CONST SQL_SELECT_STOCK_ALERT = 'SELECT COUNT(idStock) as Nbre
			FROM stock
			WHERE stock.qteStock <= stock.niveauAlerte';
	

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
	
	private function isDateFormat($formatInitial, $formatFinal, $string)
	{
		$date = date_create_from_format($formatInitial, $string);
		$date = !empty($date) ? date_format($date, $formatFinal) : '';
		return   $date;
	}
		
	public function addNewProduit()
	{
		if ($this->isFormSubmit('addProduit') && !empty($_POST['designationStock'])){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['submit']);
			$formValidation->setDataFilter(array(
					'designationStock' => FILTER_UNSAFE_RAW,
					'niveauAlerte' => FILTER_VALIDATE_INT,
                            ));
			$data = array(
					'designationStock' => strip_tags($_POST['designationStock']),
					'niveauAlerte' => (int)$_POST['niveauAlerte']
			);
			$data = $formValidation->getFilteredData($data);
			$bool = $this->pdoQuery->executePdoQuery(self::SQL_ADD_PRODUIT, $data);
			return $this->error->isErrorMsg($bool, 'Enregistrement');
		}
		else return;
		
	}

	
	
	public function mouvementProduit()
	{
		if ($this->isFormSubmit('in')){
			return $this->inProduit();
		}
		elseif($this->isFormSubmit('out')){
			return $this->outProduit();
		}
		else return ;
	}
	
	private function inProduit()
	{
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['submit']);
			$formValidation->setDataFilter(array(
					'qte' => FILTER_VALIDATE_INT,
					'idStock' => FILTER_VALIDATE_INT,
			));
			$data = array(
					'qte' => (int)($_POST['qte']),
					'idStock' => (int)$_POST['idStock'],
			);
			$data = $formValidation->getFilteredData($data);
			$bool = $this->pdoQuery->executePdoQuery(self::SQL_ENTREE_PRODUIT, $data);

			if($bool){
			$bool = $this->pdoQuery->executePdoQuery(self::SQL_INCREASE_PRODUIT, $data);
			
				if($bool){
				$result = array(
									'error' => 0,
									'type' => 'success',
									'info' => 'Votre opération a été effectuée avec succès'
					);
					return $result;
				}else{
					$result = array(
						'error' => 1,
						'type' => 'alert',
						'info' => 'L\'opération a échoué'
					);
					return $result;
				
				}
			} else {
				$result = array(
					'error' => 1,
					'type' => 'alert',
					'info' => 'L\'opération a échoué'
				);
				return $result;
			
			}
			
	}
	
	
	
	private function outProduit()
	{
				$formValidation = new FormFieldValidation();
				unset($_POST['formname']);
				unset($_POST['submit']);
				
			$result = $this->getProduitById($_POST['idStock']);
			if((int)$_POST['qte'] <= $result[0]['qteStock'])
			{
			
							$formValidation->setDataFilter(array(
									'idBatiment' => FILTER_VALIDATE_INT,
									'qte' => FILTER_VALIDATE_INT,
									'idStock' => FILTER_VALIDATE_INT,
							));
							$data = array(
									'idBatiment' => (int)$_POST['idBatiment'],
									'qte' => (int)($_POST['qte']),
									'idStock' => (int)($_POST['idStock']),
							);
							//var_dump($result);
							$data = $formValidation->getFilteredData($data);
						if($this->pdoQuery->executePdoQuery(self::SQL_SORTIE_PRODUIT, $data)){

							$formValidation->setDataFilter(array(
									'qte' => FILTER_VALIDATE_INT,
									'idStock' => FILTER_VALIDATE_INT,
							));
							$data = array(
									'qte' => (int)($_POST['qte']),
									'idStock' => (int)($_POST['idStock']),
							);
									$update = $this->pdoQuery->executePdoQuery(self::SQL_DECREASE_PRODUIT, $data);
									if($update){
									
											$result = array(
															'error' => 0,
															'type' => 'success',
															'info' => 'Vous pouvez disposer de ce produit'
											);
										return $result;
									}else{
											//		$this->deleteUtilise($lastId);
										$result = array(
											'error' => 1,
											'type' => 'alert',
											'info' => 'Désolé. Une erreur est survenue au cour de l\'opération'
										);
										return $result ;
									}
								
						} else {
							$result = array(
								'error' => 1,
								'type' => 'alert',
								'info' => 'L\'opération a échoué'
							);
							return $result;
						}
			}else {
				$result = array(
								'error' => 2,
								'type' => 'warning',
								'info' => 'Désolé il n\'en reste que '.$result[0]['qteStock']
				);
				return $result;
			}
	/*	}else {
			$result = array(
							'error' => 1,
							'type' => 'alert',
							'info' => 'L\'opération a échoué'
			);
			return $result;
		}*/
}
	
	public function getProduitById($id)
	{

			$data = array(
				'idStock' => (int)$id,
			);	
			$result = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_ALL_STOCK_BY_ID, $data);
                        if (!empty($result)) {
                        return $result;
                        } else {
                            return '';
                        }
	}				
	public function getSortieById($id)
	{

			$data = array(
				'idSortie' => (int)$id,
			);	
			$result = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_ALL_SORTIE_BY_ID, $data);
                        if (!empty($result)) {
                        return $result;
                        } else {
                            return '';
                        }
	}
	
	public function updateProduit()
	{
		if ($this->isFormSubmit('updateProduit')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['updateP']);
			$formValidation->setDataFilter(array(
					'designationStock' => FILTER_UNSAFE_RAW,
					'niveauAlerte' => FILTER_VALIDATE_INT,
					'idStock' => FILTER_VALIDATE_INT,
			));
			$data = array(
					'designationStock' => strip_tags($_POST['designationStock']),
					'niveauAlerte' => (int)$_POST['niveauAlerte'],
					'idStock' => (int)$_POST['idStock'],
			);
			$data = $formValidation->getFilteredData($data);
			$bool= $this->pdoQuery->executePdoQuery(self::SQL_UPDATE_PRODUIT, $data);
				return $this->error->isErrorMsg($bool, 'Modification');
			}
		else return;
	}
	
	public function useProduct()
	{
		if ($this->isFormSubmit('useProduct')){
			$formValidation = new FormFieldValidation();
			unset($_POST['formname']);
			unset($_POST['updateP']);
			$product = $this->getSortieById($_POST['idSortie']);
			if((int)$_POST['qte'] > $product[0]['qteActuelle']){
				$result = array(
					'error' => 1,
					'type' => 'warning',
					'info' => 'Désolé. Vous en disposez que '.$product[0]['qteActuelle']
				);
				return $result ;
			}
			$formValidation->setDataFilter(array(
					'qte' => FILTER_VALIDATE_INT,
					'idSortie' => FILTER_VALIDATE_INT,
			));
			$data = array(
					'qte' => (int)$_POST['qte'],
					'idSortie' => (int)$_POST['idSortie'],
			);
			$data = $formValidation->getFilteredData($data);
			$bool = $this->pdoQuery->executePdoQuery(self::SQL_USE_SORTIE, $data);
			if($bool){
				$result = array(
								'error' => 0,
								'type' => 'success',
								'info' => 'Opération éffectuée avec succès'
				);
				return $result;
			}else{
				$result = array(
					'error' => 1,
					'type' => 'alert',
					'info' => 'Désolé. Une erreur est survenue au cour de l\'opération'
				);
				return $result ;
			}

		}else{
				$result = array(
					'error' => 1,
					'type' => 'warning',
					'info' => 'Désolé. Veuillez remplir correctement le formulaire'
				);
				return $result ;
			}
	}
	
	public function optionProduit($selected='')
	{
			$option='';
            $item = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_ALL_STOCK_AVALAIBLE);
		if ($item){
			foreach ($item as $data){
			$select = ($selected == $data['idStock']) ? 'selected' : '';
            $option .= '<option value="' . $data['idStock'] . '" '.$select.' >' . $data['designationStock'] . '</option>';
			}
		}
		else $option .= '<option value="" > Aucun Produit </option>';
		return $option;
	}
  

	public function displayStock()
	{
		$content='';
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_ALL_STOCK);
		$content .= '<table id="filtredTable" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Désignation</th>
					<th>Quantité actuelle</th>
					<th>Niveau d\'alerte</th>
					<th>Opérations</th>
					<th>Etat</th>
				</tr>
			</thead>
			<tbody>';
		if ($this->pdoStatement) {
			foreach ($this->pdoStatement as $data){
				$etat='<span class="label label-info">Normal</span>';
				$etat = ($data['qteStock']<=$data['niveauAlerte']) ? '<span class="label label-warning">Alerte</span>' : $etat;
				$etat = ($data['qteStock'] ==0 ) ? '<span class="label label-danger">Rupture de stock</span>' : $etat;
				$content.= '<tr>'.
						'<td>' . $data['designationStock'] . '</td>'.
						'<td>' . $data['qteStock'] . '</td>'.
						'<td>' . $data['niveauAlerte'] . '</td>'.
						'<td><a href="./index.php?p=viewstock&cod='. $data['idStock'] .'"><span class="label label-success">Entree/Sortie</span></a>
                             <a href="./index.php?p=viewstock&id='. $data['idStock'] .'"><span class="label label-default">Modifier</span></a>
						</td>'.
						'<td>'.$etat.'</td>'.
					 '</tr>';
			}
		}
		return $content .='
			</tbody>
				<tfoot>
					<tr>
					<th>Désignation</th>
					<th>Quantité actuelle</th>
					<th>Niveau d\'alerte</th>
					<th>Opérations</th>
					<th>Etat</th>
					</tr>
				</tfoot>
			</table>';
	}
	
	public function optionBatiment($idBatiment)
	{
		$option = '';
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_ALL_BATIMENT);
		if ($this->pdoStatement){
			foreach ($this->pdoStatement as $data){
				if ( $data['idBatiment'] == $idBatiment ){
					$option .='<option value="' . $data['idBatiment'] . '" selected/>' . $data['nomBatiment'] . '</option>';
				}
				else
					$option .= '<option value="' . $data['idBatiment'] . '" >' . $data['nomBatiment'] . '</option>';
			}
		}
		else $option .= '<option value="" > vide </option>';
		return $option;
	}
	
	public function optionStock($idBatiment)
	{
		$option = '';
		$data = array(
			'idBatiment' => (int)$idBatiment,
		);	
		$this->pdoStatement = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_STOCK_AVALAIBLE_BY_BATIM, $data);
		if ($this->pdoStatement){
			foreach ($this->pdoStatement as $data){
				//	var_dump($data);
					$option .='<option value="'. $data['idSortie'] . '">' . $data['designationStock'].'('.$data['qteActuelle']. ')</option>';
				
			}
		}
		else $option .= '<option value="" > vide </option>';
		return $option;
	}


	public function displayIn()
	{
		$content='';
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_COUNT_ALL_IN);
		foreach ($this->pdoStatement as $data){
			$resultat = $data['resultat'];
		}
		if($resultat<>0){
			$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_ALL_IN);
			$content .= '<div class="row">
				<div class="col-xs-1"></div>
				<div class="col-xs-10">
					<div class="box box-info">
						<div class="box-header">
							<i class="fa fa-download"></i>
							<h3 class="box-title">Entrée en Stock</h3>
							<div class="box-tools pull-right">
								<a download="entree-de-stock.xls" class="btn btn-info btn-sm" href="#gridAffaire" data-toggle="tooltip" title="exporter vers excel" onclick="return ExcellentExport.excel(this,\'gridAffaire\', \'Entrée de stock imprimé le '.date('d-m-Y').'\');">Exporter vers Excel</i></a>
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" title="Afficher/Masquer"></i></button>
								<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
							</div><!-- /. tools -->
						</div><!-- /.box-header -->
						<div class="box-body"><table id="filtredTable" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Date</th>
						<th>Désignation</th>
						<th>quantité</th>
					</tr>
				</thead>
				<tbody>';
			if ($this->pdoStatement) {
				foreach ($this->pdoStatement as $data){
					$content.= '<tr>'.
									'<td>' . $this->isDateFormat('Y-m-d H:i:s', 'd-m-Y H:i:s',$data['dateEntree']) . '</td>'.
									'<td>' . $data['designationStock'] . '</td>'.
									'<td>' . $data['qteEntree'] . '</td>'.
							'</tr>';
				}
			}
			$content .='
				</tbody>
					<tfoot>
						<tr>
						<th>Date</th>
						<th>Désignation</th>
						<th>quantité</th>
						</tr>
					</tfoot>
				</table></div><!-- /.box-body -->
				</div><!-- /.box -->
			</div><!-- /.col -->
		</div><!-- /.row -->';
		}
		else{
			$content .='<div class="alert alert-info alert-dismissable"><i class="icon fa fa-info-circle"></i> Aucune liste disponible</div>';
		}
		return $content;
	}
  

	public function displayOut()
	{
		$content='';
		$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_COUNT_ALL_OUT);
		foreach ($this->pdoStatement as $data){
			$resultat = $data['resultat'];
		}
		if($resultat<>0){
			$this->pdoStatement = $this->pdoQuery->executePdoQuery(self::SQL_SELECT_ALL_OUT);
			$bUse = $_SESSION['nomService']<>"Direction" ? '<th>Opération</th>' : '';
			$pHidden = $_SESSION['nomService']<>"Direction" ? 'hidden' : '';
			$content .= '<div class="row">
						<div class="col-xs-12">
							<div class="box ">
								<div class="box-header">
									<i class="fa fa-folder"></i>
									<h3 class="box-title">Sortie de Stock</h3>
									<div class="pull-right box-tools">
										<a id="bUseProduct" href="#useProduct" class="hide open-popup-link hidden"data-toggle="tooltip"></a>
										<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa fa-minus"></i></button>
										<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
									</div>
								</div>
							<div class="box-body">
				<table id="gridAffaire" class="table table-bordered table-striped gridAffaire">
				<thead>
					<tr>
						<th>Date</th>
						<th>Désignation</th>
						<th>Approvisionnement</th>
						<th>Quantité disponible</th>
						<th>Destination</th>
						<th>Etat</th>'.$bUse.'
					</tr>
				</thead>
				<tbody>';
			if ($this->pdoStatement) {
				foreach ($this->pdoStatement as $data){
					if($_SESSION['nomService']<>"Direction" && $data['qteActuelle']<=0){continue;}
					$etat='<span class="label label-info">Normal</span>';
					$etat = ($data['qteActuelle']==0) ? '<span class="label label-default">Epuisé</span>' : $etat;
					$dUse = ($bUse <>'' && $data['qteActuelle']>0) ? '<td><a href="./index.php?p=pharmacie&cod='. $data['idSortie'] .'"><span class="label label-success">utiliser</span></a></td>' : '<td><span class="label label-default">Vide</span></td>';
					$dUse = ($bUse =='') ? '' : $dUse;
					$content.= '<tr>'.
									'<td>' . $this->isDateFormat('Y-m-d H:i:s', 'd-m-Y H:i:s', $data['dateSortie']) . '</td>'.
									'<td>' . $data['designationStock'] . '</td>'.
									'<td>' . $data['qteSortie'] . '</td>'.
									'<td>' . $data['qteActuelle'] . '</td>'.
									'<td>' . $data['nomBatiment'] . '</td>'.
									'<td>'.$etat.'</td>'.$dUse.
							'</tr>';
				}
			}
			$content .='
				</tbody>
					<tfoot>
						<tr>
						<th>Date</th>
						<th>Désignation</th>
						<th>Approvisionnement</th>
						<th>Quantité disponible</th>
						<th>Destination</th>
						<th>Etat</th>'.$bUse.'
						</tr>
					</tfoot>
				</table>
				</div></div></div></div>';
		}
		else{
			$content .='<div class="alert alert-info alert-dismissable"><i class="icon fa fa-info-circle"></i> Aucune liste disponible</div>';
		}
		return $content;
	}	
	
	public function countAlertStock()
	{
		$result = array(
			'nbre' => 0,
			'info' => '',
		);
		$param = array('');
		$data = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_STOCK_ALERT, $param);
		$nbrow = sizeOf($data);
		if ($nbrow==0){return $result;}
			foreach ($data as $nbre){
					$result = array(
						'nbre' => (int)$nbre['Nbre'],
						'info' => '<li><a href="./index.php?p=viewstock"><i class="fa fa-database text-aqua"></i>'.(int)$nbre['Nbre'].
						' Produit(s) en alerte'.
						'</a></li>',
					);
					return $result;
			}
	}

	/****************End************/
	
}
?>