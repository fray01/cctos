<?php 
	$data = null;
	$info = null;
	$formname = isset($_GET['id']) ? 'updateTypePatient':'addTypePatient';
	$name = isset($_GET['id']) ? 'update' : 'submit';
	if(isset($_POST['submit'])) {
		$info =  $this->addNewTypePatient();
	}
	elseif(isset($_POST['update'])){
		$info =  $this->updateTypePatient();
	}
	if (isset($_GET['id'])) {
		$idTypePatient = $_GET['id'];
		$data = $this->readTypePatient($idTypePatient);
	}
$back = '<a href="'.$this->previousPage().'"><i class="fa fa-arrow-circle-left"></i></a>';
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo $back;?>
			GESTION DES PARAMETRES PATIENTS
			<small>Aperçu</small>
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
			<?php echo $info;?>
		<div class="row">
			<div class="col-md-2"></div>
		<!-- left column -->
			<div class="col-md-8">
				<div class="box box-primary <?php echo isset($_GET['id']) ? '':'collapsed-box'; ?> ">
					<div class="box-header">
						<i class="fa fa-tag"></i>
						<h3 class="box-title">Configurer Patients</h3>
						<!-- tools box -->
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa <?php echo isset($_GET['id']) ? 'fa-minus':'fa-plus'; ?>"></i></button>
							<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
						</div><!-- /. tools -->
					</div><!-- /.box-header -->
						<!-- form start -->
						<div class="box-body">
					<form role="form" action="./index.php?p=typepatient" name="formname" method="POST">
						<input type="hidden" name="formname" value="<?php echo $formname;?>">
						<input type="hidden" name="idTypePatient" value="<?php echo $data['idTypePatient'];?>">
						<div class="form-group">
							<label for="des">Désignation</label>
							<input type="text" class="form-control" id="designation" name="designation" placeholder="Entrer la désignation" value="<?php echo $data['designationTP'];?>">
						</div>
						<div class="form-group">
							<label for="valeur">Consultation (Réduction consultation en %)</label>
							<input type="number" min="0" class="form-control" id="valeur" name="consultation" placeholder="Entrer la valeur de la reduction" value="<?php echo $data['reductionConsultation'];?>">
						</div>
						<div class="form-group">
							<label for="soins">Soins (Reduction soins en %)</label>
							<input type="number" min="0" class="form-control" id="soins" name="soin" placeholder="Entrer la valeur de la reduction des soins" value="<?php echo $data['reductionSoin'];?>">
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="<?php echo $name;?>">Valider <i class="fa fa-check-circle"></i></button>
						</div>
					</form>
						</div><!-- /.box-body -->

				</div><!-- /.box -->

			</div><!--/.col (left) -->
			<!-- right column -->
		</div><!-- /.row -->
			<?php echo $this->displayTypePatient();?>
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->