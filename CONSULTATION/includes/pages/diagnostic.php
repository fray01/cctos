<?php
$diagnostic = null;
$info = null;
$formname = isset($_GET['idResultat']) ? 'updateDiagnostic':'addDiagnostic';
$cod = isset($_GET['idResultat']) ? (int)$_GET['idResultat'] : '';
$name = isset($_GET['idResultat']) ? 'update' : 'submit';
$button = isset($_GET['idResultat']) ? 'modifier' : 'Ajouter <i class="fa fa-plus"></i>';
if(isset($_POST['submit'])){
	$info = $this->addDiagnostic();
}
elseif(isset($_POST['update'])){
		$info = $this->updateDiagnostic();
}
if(isset($_GET['detail']) && isset($_GET['id']) && isset($_GET['acte']) && isset($_GET['idResultat'])){
	$diagnostic = $this->readDiagnosticConsultation((int)$_GET['idResultat']);
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
		<div class="row">
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
					<?php echo '<form action="index.php?p=diagnostic&detail='.$detail.'&id='.$id.'&acte='.$idActe.'&m=0" method="post">'; ?>
					<div class="form-group">
					  <div class="row input_fields_wrap">
					  <div id="field2clone">
						<div class="col-xs-4">
								<input type="hidden" class="form-control" name="formname" value="<?php echo $formname ;?>"/>
								<input type="hidden" class="form-control" name="idResultat" value="<?php echo $diagnostic['idResultat'] ; ?>"/>
								<input type="hidden" class="form-control" name="idPoser" value="<?php echo $id ; ?>"/>
							<div class="form-group has-feedback">
						<select class="form-control basic" name="numDentResultat">
							<?php 
									echo $this->optionDent($diagnostic['numDentResultat']);
								?>
						</select>
								<!-- <input type="number" class="form-control" placeholder="N° dent" min="1" min="48" name="numDentResultat" value="<?php //echo $diagnostic['numDentResultat']; ?>"/> -->
							</div>
						</div>
						<div class="col-xs-8">
						  <div class="form-group has-feedback">
						  <select class="form-control basic" name="idActe">
								  <?php 
									echo $this->optionActe($diagnostic['idActe']);
								  ?>
						  </select>
						  </div>
						</div>
						</div>
					  </div>
						<?php echo'<button type="submit" class="pull-right btn btn-primary" name="'.$name .'">'. $button. ' </button>';?>
					</form>
					</div>
				</div>
				</div>
			</div>
		</div>
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
						<?php echo $this->displayDiagnostic();?>
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

