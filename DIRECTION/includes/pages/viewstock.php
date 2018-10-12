<?php 
	$data = null;
	$info = null;
	$produit = null;
	$formname = isset($_GET['id']) ? 'updateProduit':'addProduit';
	$name = isset($_GET['id']) ? 'updateP' : 'submit';
	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	$cod = isset($_GET['cod']) ? (int)$_GET['cod'] : 0;
	if(isset($_POST['submit'])) {
		$info = $this->addNewProduit();
	}
	elseif(isset($_POST['mouv'])){
	
	$data = $this->mouvementProduit();
	}
	elseif(isset($_POST['updateP'])){
		$info = $this->updateProduit();
	}
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$dataProduit = $this->readProduit($id);
	}
$back = '<a href="'.$this->previousPage().'"><i class="fa fa-arrow-circle-left"></i></a>';
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	
<section class="content-header">
	<h1>
		<?php echo $back;?>
		GESTION DES STOCKS
		<small>Aperçu</small>
	</h1>
</section>

<!-- Main content -->
<section class="content">
<?php 
if(!empty($data)){
		if ($data["error"]) {
				echo ' <div class="alert alert-'.$data["type"].' alert-dismissable">'
						. '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
						.$data["info"].' </div>';
		}
		else {
				echo ' <div class="alert alert-'.$data["type"].' alert-dismissable">'
						. '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
						.$data["info"].' </div>';
		}
	 }

?>
		<?php echo $info;?>
				<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6">
								<div class="box box-info	<?php echo isset($_GET['id']) ? '':'collapsed-box'; ?>">
						<div class="box-header">
										<i class="fa fa-plus-square"></i>
										<h3 class="box-title">Ajouter un nouveau produit</h3>
										<!-- tools box -->
										<div class="box-tools pull-right">
												<button class="btn btn-box-tool" data-widget="collapse"><i class="fa <?php echo isset($_GET['id']) ? 'fa-minus':'fa-plus'; ?>"></i></button>
												<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
										</div><!-- /. tools -->
						</div>
						<div class="box-body">
								<form action="./index.php?p=viewstock" method="post" name="formname">
																						<input type="hidden" name="formname" value="<?php echo $formname;?>">
																						<input type="hidden" name="idStock" value="<?php echo $produit['idStock'];?>">
																						<div class="form-group has-feedback">
																										<label>Désignation :</label>
																										<input type="text" class="form-control" placeholder="Saisissez Désignation" name="designationStock" value="<?php echo $produit['designationStock'];?>"/>
																										<span class="glyphicon glyphicon-notes form-control-feedback"></span>
																						</div>
																						<div class="form-group has-feedback">
																										<label>Niveau d'alerte :</label>
																										<input type="number" min="0" class="form-control" name="niveauAlerte" value="<?php echo isset($produit['niveauAlerte']) ? $produit['niveauAlerte'] : 5 ;?>"/>
																										<span class="glyphicon glyphicon-notes form-control-feedback"></span>
																						</div>
										<div class="box-footer clearfix">
														<button class="pull-right btn btn-primary" id="sendEmail" name="<?php echo $name;?>">Valider <i class="fa fa-check-circle"></i></button>
										</div>
								</form>
						</div>
				</div>
		</div>
</div>
<div class="row">
		<div class="col-xs-1"></div>
		<div class="col-xs-10">
						<div class="box">
										<div class="box-header">
														<i class="fa fa-wheelchair"></i>
														<h3 class="box-title">Liste des Produits en stocks</h3>
														<div class="box-tools pull-right">
														<a id="approduit" href="#approvisionnement" class="hide open-popup-link"data-toggle="tooltip"></a>
																		<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" title="Afficher/Masquer"></i></button>
																		<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
														</div><!-- /. tools -->
										</div><!-- /.box-header -->
										<div class="box-body">
														<?php echo $this->displayStock(); ?>
										</div><!-- /.box-body -->
						</div><!-- /.box -->
		</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div id="approvisionnement" class="white-popup mfp-hide">

		<p class="login-box-msg">Mouvement</p>

		<form action="./index.php?p=viewstock" method="post" name="formname">
				<input id="inOut" type="hidden" name="formname" value="in">
				<div class="form-group has-feedback">
								<label>Opération</label>
								<select class="form-control operation" name="operation">
												<option value="0">Entree</option>
												<option value="1">Sortie</option>
								</select>
				</div>
				<input type="hidden" name="idStock" value="<?php echo $cod;?>">
<div class="form-group destination hidden">
				<label for="service">Destination</label>
				<select class="form-control" name="idBatiment">
							 <?php echo $this->optionBatiment(''); ?>
				</select>
</div>
<div class="form-group has-feedback">
				<label>Quantité :</label>
				<input type="number"	min="0" class="form-control" name="qte" value=""/>
				<span class="glyphicon glyphicon-notes form-control-feedback"></span>
</div>
<div class="row">
				<div class="col-xs-6">
				<button type="cancel" class="btn btn-block btn-flat">Annuler</button>
				</div>
			<div class="col-xs-6">
				 <button type="submit" class="btn btn-block btn-primary btn-flat" name="mouv">Valider</button>
			</div><!-- /.col -->
</div> 
	</form>

</div><!-- /.form-box -->
	

<style>
.white-popup {
position: relative;
background: #FFF;
padding: 20px;
width: auto;
max-width: 500px;
margin: 20px auto;
}
</style>	
<script> 
//jQuery.noConflict();
$('.open-popup-link').magnificPopup({
type:'inline',
midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
});

</script> 
<?php echo isset($_GET['cod']) ? '<script> jQuery(function($){ $("#approduit").click() });</script>':'' ; ?>