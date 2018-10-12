<?php 
	$info = null;
	$data = null;
	$formname = isset($_GET['id']) ? 'updatePersonnel':'addPersonnel';
	$name = isset($_GET['id']) ? 'update' : 'submit';
	if(isset($_POST['submit'])) {
		$info = $this->addEmployee();
	}
	elseif(isset($_POST['update'])){
		$info = $this->updateEmployee();
	}
	if (isset($_GET['id'])) {
		$idPersonnel = $_GET['id'];
		$data = $this->readEmployee($idPersonnel);
	}
	
	$back = '<a href="'.$this->previousPage().'"><i class="fa fa-arrow-circle-left"></i></a>';
	
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
		<?php echo $back;?>
			GESTION DU PERSONNEL
			<small>Aperçu</small>
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
		<?php echo $info;?>
		<div class="box box-info <?php echo isset($_GET['id']) ? '':'collapsed-box'; ?>">
			<div class="box-header">
				<i class="fa fa-user-plus"></i>
				<h3 class="box-title">Ajouter Personnel</h3>
				<!-- tools box -->
				<div class="pull-right box-tools">
					<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa <?php echo isset($_GET['id']) ? 'fa-minus':'fa-plus'; ?>"></i></button>
					<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
				</div><!-- /. tools -->
			</div>
			<div class="box-body">
				<div class="col-lg-3"></div>
				<form action="./index.php?p=viewpersonnel" method="post" class="col-lg-5" name="formname" enctype="multipart/form-data">
					<input type="hidden" name="formname" value="<?php echo $formname;?>">
					<input type="hidden" name="idPersonnel" value="<?php echo $data['idPersonnel'];?>">
						<div class="form-group has-feedback">
							<input type="text" class="form-control" placeholder="Matricule" name="matricule" value="<?php echo $data['matriculePersonnel'];?>"/>
							<span class="glyphicon glyphicon-notes form-control-feedback"></span>
						</div>
					<div class="form-group has-feedback">
							<input type="text" class="form-control" placeholder="Nom" name="nom" value="<?php echo $data['nomPersonnel'];?>"/>
							<span class="glyphicon glyphicon-notes form-control-feedback"></span>
						</div>
						<div class="form-group has-feedback">
							<input type="text" class="form-control" placeholder="Prénom" name="prenom" value="<?php echo $data['PrenomPersonnel'];?>"/>
							<span class="glyphicon glyphicon-notes form-control-feedback" ></span>
						</div>
						<div class="form-group has-feedback">
							<label> Image de profil</label>
							<input type="file" class="form-control" id="vignette" name="vignette"/>
							<input type="hidden" class="form-control" id="fileUpload" name="fileUpload" value="<?php echo $data['vignettePersonnel'];?>"/>
							</div>
						<div class="form-group has-feedback">
							<label>Date de naissance</label>
							<input type="date" class="form-control" name="ddn" value="<?php echo $data['DDNPersonnel'];?>"/>
							<span class="glyphicon glyphicon-calendar form-control-feedback" ></span>
						</div>
						<div class="form-group has-feedback">
							<label>Sexe :</label>
							<div class="row">
								<div class="col-xs-4">
										<label>
											<input type="radio" name="sexe" id="H" <?php if (!isset($_GET['id'])) echo "checked";?>  
											<?php if (isset($_GET['id']) && $data['sexePersonnel']=="H") echo "checked";?> value="H"/>Homme
										</label>
								</div><!-- /.col -->
								<div class="col-xs-4">
										<label>
											<input type="radio" name="sexe" id="F"
											<?php if (isset($_GET['id']) && $data['sexePersonnel']=="F") echo "checked";?> value="F"/>Femme
										</label>
								</div><!-- /.col -->
							</div>
						</div>
						<div class="form-group has-feedback">
						<label>Fonction</label>
						<select class="form-control" name="fonction">
							<?php echo $this->optionFonction($data['fonctionPersonnel']);?>
						</select>
						</div>
						<div class="form-group has-feedback">
							<input type="text" class="form-control" placeholder="Contact" name="contact" value="<?php echo $data['contactPersonnel'];?>"/>
							<span class="glyphicon glyphicon-earphone form-control-feedback"></span>
						</div>
						<div class="form-group has-feedback">
							<input type="text" class="form-control" placeholder="Adresse" name="adresse" value="<?php echo $data['adressePersonnel'];?>"/>
							<span class="glyphicon glyphicon-map-marker form-control-feedback" ></span>
						</div>

						<div class="box-footer clearfix">
							<button class="pull-right btn btn-primary" id="sendEmail" name="<?php echo $name;?>">Valider <i class="fa fa-check-circle"></i></button>
						</div>
					</form>
				</div>
		</div>
			<?php echo $this->displayEmployees();?>
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->