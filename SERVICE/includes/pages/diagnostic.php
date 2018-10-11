<?php
$diagnostic = null;
$info = null;
$formname = isset($_GET['cod']) ? 'updateDiagnostic':'addDiagnostic';
$cod = isset($_GET['cod']) ? (int)$_GET['cod'] : '';
$name = isset($_GET['cod']) ? 'update' : 'submit';
$button = isset($_GET['cod']) ? 'modifier' : 'Ajouter <i class="fa fa-plus"></i>';
$info = $this->confirmDiagnostic();
if(isset($_POST['submit'])){
	$info = $this->addDiagnostic();
}
elseif(isset($_POST['update'])){
		$info = $this->updateDiagnostic();
}
if(isset($_GET['detail']) && isset($_GET['id']) && isset($_GET['acte'])){
	$diagnostic = $this->readDiagnostic();
}
$id = isset($_GET['id']) ? (int)$_GET['id'] : '';
$detail = isset($_GET['detail']) ? (int)$_GET['detail'] : '';
$idActe = isset($_GET['acte']) ? (int)$_GET['acte'] : '';

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
			<?php echo $info; ?>
		<?php $form = '<div class="row">
			<div class="col-md-2">
			</div>
			<div class="col-md-8">
				<div class="box box-info">
				<div class="box-header">
					<i class="fa fa-user-plus"></i>
					<h3 class="box-title">Ajouter un diagnostic</h3>
					<!-- tools box -->
					<div class="pull-right box-tools">
						<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa fa-minus"></i></button>
						<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
					</div><!-- /. tools -->
				</div>
				<div class="box-body">
					<form action="index.php?p=diagnostic&detail='.$detail.'&id='.$id.'&acte='.$idActe.'&m=0" method="post">
					<div class="form-group">
					  <div class="row input_fields_wrap">
					  <div id="field2clone">
						<div class="col-xs-4">
								<input type="hidden" class="form-control" name="formname" value="'.$formname.'"/>
								<input type="hidden" class="form-control" name="idResultat" value="'.$diagnostic['idResultat'].'"/>
								<input type="hidden" class="form-control" name="idPoser" value="'.$id.'"/>
							<div class="form-group has-feedback">
						<select class="form-control basic" name="numDentResultat">
							'.$this->optionDent($diagnostic['numDentResultat']).'
						</select>
								
							</div>
						</div>
						<div class="col-xs-8">
						  <div class="form-group has-feedback">
						  <select class="form-control basic" name="operationDent">
								  '. $this->optionActe($diagnostic['idActe']).'
						  </select>
						  </div>
						</div>
						</div>
					  </div>
						<button type="submit" class="pull-right btn btn-primary" name="'.$name .'">'. $button. ' </button>
					</form>
					</div>
				</div>
				</div>
			</div>
		</div>' ;
		if($_SESSION['nomService'] == 'Radio' || $_SESSION['nomService'] == 'Radiologie'){
			echo $form;
		}
		?>
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
						<?php 
							if($_SESSION['nomService'] == 'radio' || $_SESSION['nomService'] == 'radiologie'){
								echo $this->displayDiagnostic();
							}else echo $this->displayDiagnostic(1);
						?>
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

