<?php 
	$dataTarif = null;
	$dataActe = null;
	$info = null;
	$formnameActe = isset($_GET['id']) ? 'updateActe':'addActe';
	$name = isset($_GET['id']) ? 'update' : 'submit';
	$nameTarif = isset($_GET['cod']) ? 'update' : 'submit';
	
	$formnameTarification = isset($_GET['cod']) ? 'updateTarification':'addTarification';
	if(isset($_POST['submit'])) {
		$info = $this->isFormAdd();
	}
	elseif(isset($_POST['update'])){
		$info = $this->isFormUpdate();
	}
	
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$dataActe = $this->readActe($id);
	}
	elseif(isset($_GET['cod'])){
		$cod = $_GET['cod'];
		$dataTarif = $this->readTarification($cod);
	}
$back = '<a href="'.$this->previousPage().'"><i class="fa fa-arrow-circle-left"></i></a>';
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo $back;?>
			GESTION DES TARIFS
			<small>Aperçu</small>
		</h1>
	</section>
		<?php echo $info;?>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-3">
			</div><!-- /.col -->
			<div class="col-md-6">
				<div class="box">
					<div class="box-header">
						<i class="fa fa-book"></i>
						<h3 class="box-title">Codifications</h3>
							<!-- tools box -->
							<div class="box-tools pull-right">
								<a id="newcodif" href="#addCodif" class="btn btn-info btn-sm open-popup-link"data-toggle="tooltip"> Créer une codification</a>
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" title="Afficher/Masquer"></i></button>
								<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
							</div><!-- /. tools -->
					</div><!-- /.box-header -->
					<?php echo $this->displayTarification()?>
				</div><!-- /.box -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<i class="fa fa-book"></i>
						<h3 class="box-title">Liste des Actes</h3>
							<!-- tools box -->
							<div class="box-tools pull-right">
								<a id="newacte" href="#addActe" class="btn btn-info btn-sm open-popup-link"data-toggle="tooltip"> Ajouter un Acte</a>
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" title="Afficher/Masquer"></i></button>
								<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
							</div><!-- /. tools -->
					</div><!-- /.box-header -->
						<?php echo $this->displayActe();?>
				</div><!-- /.box -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div id="addActe" class="white-popup mfp-hide">
				  
	<p class="login-box-msg">Enregistrer un acte</p>

						<form role="form" action="./index.php?p=tarif" name="formname" method="POST">
							<input type="hidden" name="formname" value="<?php echo $formnameActe;?>">
							<input type="hidden" name="idActe" value="<?php echo $dataActe['idActe'];?>">
							<div class="form-group">
								<label for="des">Désignation</label>
								<input type="text" class="form-control" id="designation" name="designation" placeholder="Enter la désignation" value="<?php echo $dataActe['designationActe'];?>">
							</div>
								<div class="form-group">
									<label for="Valeur">Valeur</label>
									<input type="number" min="0" class="form-control" id="valeur" name="valeur" placeholder="Entrer le Tarif" value="<?php echo $dataActe['valeurActe'];?>">
								</div>
								<div class="form-group">
									<label for="codification">Codification</label>
									<select class="form-control" name="codification">
										<?php 
											$this->optionTarification($dataActe['idTarif']);
										?>
									</select>
								</div>
								<div class="form-group">
									<label for="service">Service</label>
									<select class="form-control" name="service">
										<?php echo $this->optionServices($dataActe['idService']);?>
									</select>
								</div>
							  <div class="row">
								  <div class="col-xs-6">
								  <button type="cancel" class="btn btn-block btn-flat">Annuler</button>
								  </div>
								<div class="col-xs-6">
								  <button type="submit" class="btn btn-primary btn-block btn-flat"  name="<?php echo $name;?>">Valider</button>
								</div><!-- /.col -->
							  </div> 
						</form>

  </div><!-- /.form-box -->
<div id="addCodif" class="white-popup mfp-hide">
				  
	<p class="login-box-msg">Créer une codification</p>
					<form role="form" action="./index.php?p=tarif" name="formname" method="POST">
					<input type="hidden" name="formname" value="<?php echo $formnameTarification;?>">
					<input type="hidden" name="idTarif" value="<?php echo $dataTarif['idTarif'];?>">
					<div class="form-group">
							<label for="codif">Codification</label>
							<input type="text" class="form-control" id="codif" placeholder="Enter la codification" name="codification" value="<?php echo $dataTarif['codificationTarif'];?>">
						</div>
						<div class="form-group">
							<label for="tn">Tarif normal</label>
							<input type="number" min="0" class="form-control" id="tn" placeholder="Entrer le Tarif" name="normal" value="<?php echo $dataTarif['tarifNormal'];?>">
						</div>
						<div class="form-group">
							<label for="ts">Tarif social</label>
							<input type="number" min="0" class="form-control" id="ts" placeholder="Entrer le Tarif" name="social" value="<?php echo $dataTarif['tarifSocial'];?>">
						</div>
							  <div class="row">
								  <div class="col-xs-6">
								  <button type="cancel" class="btn btn-block btn-flat">Annuler</button>
								  </div>
								<div class="col-xs-6">
								  <button type="submit" class="btn btn-primary btn-block btn-flat"  name="<?php echo $nameTarif;?>">Valider</button>
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
<?php echo isset($_GET['cod']) ? '<script> jQuery(function($){ $("#newcodif").click() });</script>':'' ; ?>
<?php echo isset($_GET['id']) ? '<script> jQuery(function($){ $("#newacte").click() });</script>':'' ; ?>