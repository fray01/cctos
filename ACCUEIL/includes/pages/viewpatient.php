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
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		GESTION DES PATIENTS
		<small>Aperçu</small>
	</h1>
</section>

<!-- Main content -->
<section class="content">
			<?php echo $info;?>
			<!-- quick email widget -->
					<div class="box box-info  <?php echo isset($_GET['id']) ? '':'collapsed-box'; ?>">
				<div class="box-header">
					<i class="fa fa-user-plus"></i>
					<h3 class="box-title">Ajouter un Patient</h3>
					<!-- tools box -->
					<div class="pull-right box-tools">
						<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa <?php echo isset($_GET['id']) ? 'fa-minus':'fa-plus'; ?>"></i></button>
						<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
					</div><!-- /. tools -->
				</div>
				<div class="box-body">
						<div class="col-lg-3">
						</div>
							<form action="./index.php?p=viewpatient" method="post" class="col-lg-5" name="formname" id="target">
							<div class="form-group has-feedback">
							<input type="hidden" name="formname" value="<?php echo $formname;?>">
							<input type="hidden" name="numDossier" value="<?php echo $data['numDossier'];?>">
							<input type="hidden" name="dossierPatient" value="<?php echo $data['dossierPatient'];?>">
							<div class="form-group has-feedback">
							<label>Centre</label>
							<select id="centre" class="form-control" name="centre" >
							<?php $this->optionCentre();?>
							</select>
							</div>
							<label>Catégorie du Patient</label>
							<?php if (isset($_GET['id'])) {
								echo '<input type="hidden" name="idTypePatient" value="',$data['idTypePatient'],'">';
							}
							else
								echo'<select id="categorie" name="idTypePatient" class="form-control" disabled="disabled">', $this->optionTypePatient($data['idTypePatient']),'</select>';
							?>
							</div>
							<div class="form-group has-feedback">
								<input type="text" class="form-control" placeholder="Nom" name="nom" value="<?php echo $data['nomPatient'];?>" disabled/>
								<span class="glyphicon glyphicon-notes form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="text" class="form-control" placeholder="Prénom" name="prenom" value="<?php echo $data['PrenomPatient'];?>" disabled/>
								<span class="glyphicon glyphicon-notes form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<label>Date de naissance</label>
								<input type="date" placeholder="aaaa-mm-jj" class="form-control" name="ddn" value="<?php echo $data['DDNPatient'];?>" disabled/>
								<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<label>Sexe :</label>
								<div class="row">
									<div class="col-xs-4">
											<label>
											<input class="radio" type="radio" name="sexe" id="H" <?php if (!isset($_GET['id'])) echo "checked";?>  
												<?php if (isset($_GET['id']) && $data['sexePatient']=="H") echo "checked";?> value="H" disabled/>Homme
												</label>
									</div><!-- /.col -->
									<div class="col-xs-4">
											<label>
												<input class="radio" type="radio" name="sexe" id="F"
												<?php if (isset($_GET['id']) && $data['sexePatient']=="F") echo "checked";?> value="F" disabled/>Femme
											</label>
									</div><!-- /.col -->
								</div>
							</div>
							<div class="form-group has-feedback">
								<input type="text" class="form-control" placeholder="Profession" name="profession" value="<?php echo $data['professionPatient'];?>" disabled/>
								<span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
									<input type="number" class="form-control" placeholder="Contact" name="contact" value="<?php echo $data['contactPatient'];?>" disabled/>
								<span class="glyphicon glyphicon-earphone form-control-feedback" ></span>
							</div>
							<div class="form-group has-feedback">
								<input type="text" class="form-control" placeholder="Adresse" name="adresse" value="<?php echo $data['adressePatient'];?>" disabled/>
								<span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="text" class="form-control" placeholder="Nom du père" name="pere" value="<?php echo $data['perePatient'];?>" disabled/>
								<span class="glyphicon glyphicon-user form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="text" class="form-control" placeholder="Nom de la mère" name="mere" value="<?php echo $data['merePatient'];?>" disabled/>
								<span class="glyphicon glyphicon-woman form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<label>Assuré?</label>
								<div class="row">
									<div class="col-xs-4">
											<label>
												<input class="radio" type="radio" name="assurance" id="oui" 
												<?php if (isset($_GET['id']) && $data['assurancePatient']=="oui") echo "checked";?> value="oui" checked disabled/>Oui
											</label>
									</div><!-- /.col -->
									<div class="col-xs-4">
											<label>
												<input class="radio" type="radio" name="assurance" id="non" 
												<?php if (isset($_GET['id']) && $data['assurancePatient']=="non") echo "checked";?> value="non" disabled/>Non
											</label>
									</div><!-- /.col -->
								</div>
							</div>
				<div class="box-footer clearfix">
					<button class="pull-right btn btn-primary" id="sendEmail" name="<?php echo $name;?>">Valider <i class="fa fa-check-circle"></i></button>
				</div>
					</form>
				</div>
			</div>
				<?php echo $this->displayPatient(0);?>
</section><!-- /.content -->
</div><!-- /.content-wrapper -->