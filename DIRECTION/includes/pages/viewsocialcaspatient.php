<?php 
	$data = null;
	$dataPatient = null;
	 $info = null;
	$formname = isset($_GET['detail']) ? 'updatePatient':'addPatient';
	$name = isset($_GET['detail']) ? 'update' : 'submit';
	if (isset($_GET['detail'])) {
		$numDossier = $_GET['detail'];
		$data = $this->readTypePatient('');
		$dataPatient = $this->readPatient($numDossier);
		if(isset($_POST['update'])){
			$info = $this->updatePatient();
		}
	}
	elseif(isset($_GET['id'])){
		if(isset($_POST['update'])){
			$info = $this->updatePatient();
		}
	}
$back = '<a href="'.$this->previousPage().'"><i class="fa fa-arrow-circle-left"></i></a>';
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo $back;?>
		GESTION DES CAS SOCIAUX
		<small>Aperçu</small>
	</h1>
</section>

<!-- Main content -->
<section class="content displayCasSocial">
					<?php echo $info;?>
					<?php echo $this->displayPatient('',1);?>
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div id="addMember" class="white-popup mfp-hide">
		<div class="register-box-body">
			<p class="login-box-msg">Confirmer statut</p>
			<form action="./index.php?p=viewsocialcaspatient&detail=<?php echo $_GET['detail'];?>" method="post" name="formname">
				<input type="hidden" name="formname" value="updatePatient">
				<input type="hidden" name="numDossier" value="<?php echo $dataPatient['numDossier'];?>">
				<div class="form-group">
					<label>Appliquer un type de reduction en tant que...</label>
					<select id="type_patient" name="idTypePatient" class="form-control">
					<?php echo $this->optionTypePatient('');?>
					</select>
				</div>
		</div>
				<div class="row">
						<div class="col-xs-6">
						<button type="cancel" class="btn btn-block btn-flat">Annuler</button>
						</div>
					<div class="col-xs-6">
						<button type="submit" name="update" class="btn btn-primary btn-block btn-flat">Modifier</button>
					</div><!-- /.col -->
				</div>
			</form>
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
<?php echo isset($_GET['detail']) ? '<script> jQuery(function($){ $("#member").click() });</script>':'' ; ?>
