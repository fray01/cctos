<?php 
$data = null;
$formname = 'entree';
$name = 'submit';
$info = '';
$idPersonnel = null;
$idEtre = null;

if(isset($_POST['submit'])){
	$info = $this->isOn();
}
if(isset($_GET['entrer'])){
	$idPersonnel = (int)$_GET['entrer'];
}
if(isset($_GET['sortir'])) {
	$idEtre = $_GET['sortir'];
	$data = $this->readInOut($idEtre);
	$info = $this->isOut($data['idEtre']);
}
?>
<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				GESTION DES ENTREES/SORTIES
				<small>Aperçu</small>
			</h1>
		</section>
		<section class="content">
			<?php echo $info; ?>
			<?php echo $this->displayPersonnel();?>
		<section class="content">
	</div><!-- /.content-wrapper -->
<div id="entrer" class="white-popup mfp-hide">
	<p class="login-box-msg">Entrée</p>
		<form action="./index.php?p=pointage" method="post" name="formname">
			<input type="hidden" name="formname" value="<?php echo $formname;?>">
			<input type="hidden" name="idPersonnel" value="<?php echo $idPersonnel;?>">
			<div class="form-group has-feedback">
			<label> Confirmez-vous que cet employé est bel et bien là?</label>
			</div>
			<div class="row">
				<div class="col-xs-6 col-lg-6">
					<button class="btn btn-danger" id="cancel" type="cancel">Non <i class="fa fa-check-cross"></i></button>
				</div>
				<div class="col-xs-6 col-lg-6">
					<button class="btn btn-primary" id="submit" name="<?php echo $name;?>">Oui <i class="fa fa-check-circle"></i></button>
				</div>
			</div>
		</form>
</div><!-- /.form-box -->
<!-- page script -->
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
<?php echo isset($_GET['entrer']) ? '<script> jQuery(function($){ $("#bEntrer").click() });</script>':'' ; ?>
