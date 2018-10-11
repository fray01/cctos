<?php
$diagnostic = null;
$info = null;
$bool = isset($_GET['m']) ? (int)$_GET['m'] : '';
$formname = isset($_GET['cod']) ? 'updateDiagnostic':'addDiagnostic';
$cod = isset($_GET['cod']) ? (int)$_GET['cod'] : '';
$name = isset($_GET['cod']) ? 'update' : 'submit';
$button = isset($_GET['cod']) ? 'modifier' : 'Ajouter <i class="fa fa-plus"></i>';
$id = isset($_GET['id']) ? (int)$_GET['id'] : '';
if(isset($_POST['submit'])){
	$info = $this->addDiagnostic();
}
elseif(isset($_POST['update'])){
	$info = $this->updateDiagnostic();
}
$diagnostic = $this->readDiagnostic();
$selected = isset($diagnostic['operationDent']) ? $diagnostic['operationDent'] : '';
$back = '<a href="'.$this->previousPage().'"><i class="fa fa-arrow-circle-left"></i></a>';
?>
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
			<?php echo $back;?>
				DIAGNOSTIC
				<small>Aperçu</small>
			</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<?php echo $info;?>
			<div class="row">
			<div class="col-md-2">
			</div>
				<div class="col-md-8">
					<div class="box box-info">
						<div class="box-header">
							<h3 class="box-title">Diagnostic</h3>
							<!-- tools box -->
								<div class="box-tools pull-right">
												<button class="btn btn-box-tool" data-widget="collapse" title="Afficher/Masquer"><i class="fa fa-minus"></i></button>
												<button class="btn btn-box-tool" data-widget="remove" title="Fermer"><i class="fa fa-times"></i></button>
								</div>
						</div><!-- /.box-header -->
						<div class="box-body">
						<?php echo $this->displayDiagnostic($bool); ?>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div><!-- /.col -->
			</div><!-- /.row -->
		</section><!-- /.content -->
	</div><!-- /.content-wrapper -->
<!-- page script -->
<script>
  $(".basic").select2();
  
</script>

