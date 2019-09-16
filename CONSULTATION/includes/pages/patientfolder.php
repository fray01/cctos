<?php 
$data = null;
$info = null;
	if (isset($_GET['detail'])) {
		$numDossier = $_GET['detail'];
		$data = $this->readPatientFolder($numDossier);
	}
	if (isset($_POST['submit'])){
// 		var_dump($_POST);
		$info = $this->addPatientNewActe();
		unset($_POST);
	}
	elseif (isset($_POST['setbackward'])){
		$info = $this->setBackward();
		unset($_POST);
	}
	if (isset($_GET['detail']) && (isset($_POST['submitE']) || isset($_POST['submitP']))) {
		$info = $this->updateFollowPatient();
	}
$back = '<a href="'.$this->previousPage().'"><i class="fa fa-arrow-circle-left"></i></a>';
?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
			<?php echo $back;?>
	GESTION DES PATIENTS
	<small>Aperçu</small>
	</h1>
</section>

<!-- Main content -->
<section class="content">
			<?php echo $info;?>
			<div class="box box-info">
		<div class="box-header">
			<i class="fa fa-user"></i>
			<h3 class="box-title">Information du Patient</h3>
			<!-- tools box -->
			<div class="pull-right box-tools">
			<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa fa-minus"></i></button>
			<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
			</div><!-- /. tools -->
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-xs-4">
<!-- 					<label> Dossier N° </label> <label> <?php //echo $data['dossierPatient'];?> </label>-->
					<label> Dossier N° </label> <label> <?php echo $data['dossierPatient'];?> </label>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<label> Nom    : </label>		<label> <?php echo $data['nomPatient'];?> </label>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<label> Prénoms   :</label>		<label> <?php echo $data['PrenomPatient'];?> </label>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<label> Date de naissance   :</label>		<label> 
					<?php 
						$date = new DateTime($data['DDNPatient']);
						echo $date->format('d-m-Y');
					?>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<label> Adresse   :</label>		<label> <?php echo $data['adressePatient'];?> </label> 
				</div>
			</div>
		</div>
		</div>
		<?php echo $this->displayPatientFolderByServices($data['numDossier'], $data['nomPatient'], $data['PrenomPatient']);?>
	<!-- /.row -->
</section><!-- /.content -->
</div>
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
<?php echo isset($_GET['id']) && ($_GET['type']=='E' || $_GET['type']=='P') ? '<script> jQuery(function($){ $("#bFollow").click() });</script>':'' ; ?>