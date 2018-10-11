<?php 
	$data = null;
	$info = null;
	$formname = isset($_GET['id']) ? 'updatePatient':'addPatient';
	$name = isset($_GET['id']) ? 'update' : 'submit';
	if(isset($_POST['submit'])) {
		$info = $this->addNewPatient();
	}
	elseif(isset($_POST['update'])){
		$info = $this->updatePatient();
	}
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
		GESTION DES PATIENTS
		<small>Aperçu</small>
	</h1>
	
</section>

<!-- Main content -->
<section class="content displayPatient">				
					<?php echo $info;?>
					<?php echo $this->displayPatient(0);?>
</section><!-- /.content -->
</div><!-- /.content-wrapper -->