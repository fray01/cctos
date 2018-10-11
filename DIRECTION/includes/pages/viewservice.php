<?php 
$data = null;
$info = null;
$formname = isset($_GET['id']) ? 'updateService':'addService';
$name = isset($_GET['id']) ? 'update' : 'submit';
if(isset($_POST['submit'])) {
	$info = $this->addNewService();
}
elseif(isset($_POST['update'])){
	$info = $this->updateService();
}
if (isset($_GET['id'])) {
	$idService = $_GET['id'];
	$data = $this->readService($idService);
}
$back = '<a href="'.$this->previousPage().'"><i class="fa fa-arrow-circle-left"></i></a>';
?>
<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
		<?php echo $back;?>
				GESTION DES SERVICES
				<small>Aperçu</small>
			</h1>
			
		</section>

		<!-- Main content -->
		<section class="content">
		<?php echo $info;?>
	<!-- quick email widget -->
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
			<div class="box box-info <?php echo isset($_GET['id']) ? '':'collapsed-box'; ?>">
				<div class="box-header">
					<i class="fa fa-user-plus"></i>
					<h3 class="box-title">Ajouter un Service</h3>
					<!-- tools box -->
					<div class="pull-right box-tools">
						<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa <?php echo isset($_GET['id']) ? 'fa-minus':'fa-plus'; ?>"></i></button>
						<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
					</div><!-- /. tools -->
				</div>
				<div class="box-body">
					<div class="col-lg-3"></div>
					<form action="./index.php?p=viewservice" method="post" class="col-lg-5" name="formname">
					
							<input type="hidden" name="formname" value="<?php echo $formname;?>">
							<input type="hidden" name="idService" value="<?php echo $data['idService'];?>">
							<div class="form-group has-feedback">
								<input type="text" class="form-control" name="abreviation" placeholder="Abreviation du service" value="<?php echo $data['abreviationService'];?>"/>
								<span class="form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="text" class="form-control" name="libelle" placeholder="Libelle du service" value="<?php echo $data['nomService'];?>"/>
								<span class="form-control-feedback" ></span>
							</div>
				</div>
						<div class="box-footer clearfix">
							<button class="pull-right btn btn-primary" id="sendEmail" name="<?php echo $name ;?>">Valider <i class="fa fa-check-circle"></i></button>
						</div>
				</form>
			</div>
			</div>
			</div>
			<div class="row">
			<div class="col-md-2"></div>
				<div class="col-xs-8">
					<div class="box box-info">
						<div class="box-header">
							<h3 class="box-title">Services</h3>
							<!-- tools box -->
								<div class="box-tools pull-right">
												<button class="btn btn-box-tool" data-widget="collapse" title="Afficher/Masquer"><i class="fa fa-minus"></i></button>
												<button class="btn btn-box-tool" data-widget="remove" title="Fermer"><i class="fa fa-times"></i></button>
								</div>
						</div><!-- /.box-header -->
						<div class="box-body">
							<?php echo $this->displayService();?>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div><!-- /.col -->
			</div><!-- /.row -->
		</section><!-- /.content -->
	</div><!-- /.content-wrapper -->
<!-- page script -->
