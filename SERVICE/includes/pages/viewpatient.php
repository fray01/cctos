<?php 
	$data = null;
	$formname = isset($_GET['id']) ? 'updatePatient':'addPatient';
	$name = isset($_GET['id']) ? 'update' : 'submit';
	if (isset($_GET['id'])) {
		$numDossier = $_GET['id'];
		$data = $this->readPatient($numDossier);
	}
$back = '<a href="'.$this->previousPage().'"><i class="fa fa-arrow-circle-left"></i></a>';
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo $back;?>
		GESTION DE L'HISTORIQUE GESTION DES PATIENTS
		<small>Aperçu</small>
	</h1>
</section>

<!-- Main content -->
<section class="content displayPatient">
			<!-- quick email widget -->
			<?php echo $this->displayPatient(0);?>
</section><!-- /.content -->
</div><!-- /.content-wrapper -->