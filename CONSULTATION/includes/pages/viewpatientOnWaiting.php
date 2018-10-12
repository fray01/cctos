<?php 
	$data = null;
	$formname = isset($_GET['id']) ? 'updatePatient':'addPatient';
	$name = isset($_GET['id']) ? 'update' : 'submit';
	if (isset($_GET['id'])) {
		$numDossier = $_GET['id'];
		$data = $this->readPatient($numDossier);
	}
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		PATIENTS EN ATTENTE DE SOINS
		<small>Aperçu</small>
	</h1>
</section>

<!-- Main content -->
<section class="content displayPatientOnWaiting">
			<!-- quick email widget -->
			<?php echo $this->displayPatient(1);?>
</section><!-- /.content -->
</div><!-- /.content-wrapper -->