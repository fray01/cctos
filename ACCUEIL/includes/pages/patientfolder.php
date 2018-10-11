<?php 
$data = null;
$info = null;
	if (isset($_GET['detail'])) {
		$numDossier = $_GET['detail'];
		$data = $this->readPatientFolder($numDossier);
	}
	if (isset($_POST['submit'])){
// 		var_dump($_POST);
		$info = $this->addPatientNewActe();
	}
	elseif (isset($_POST['setbackward'])){
		$info = $this->setBackward();
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
<section class="content">
			<?php echo $info;?>
			<div class="box box-info">
		<div class="box-header">
			<i class="fa fa-user"></i>
			<h3 class="box-title">Information du Patient</h3>
			<!-- tools box -->
			<div class="pull-right box-tools">
			<?php
				if($data['etatPatient']==0){
					echo '<a href="#addFolder" class="btn btn-info btn-sm open-popup-link"data-toggle="tooltip"> Créer un Dossier</a>';
				}
			?>
			<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa fa-minus"></i></button>
			<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
			</div><!-- /. tools -->
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-xs-4">
			<!-- 	<label> Dossier N° </label> <label> <?php //echo $data['dossierPatient'];?> </label>-->	
					<label> Dossier N° </label> <label> <?php echo $data['numDossier'];?> </label>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<label> Nom    : </label>		<label> <?php echo $data['nomPatient'];?> </label>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<label> Prénoms   :</label>		<label> <?php echo $data['PrenomPatient'];?> </label>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<label> Date de naissance   :</label>		<label> 
					<?php 
						$date = new DateTime($data['DDNPatient']);
						echo $date->format('d-m-Y');
					?>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<label> Sexe   :</label>		<label> <?php echo $data['sexePatient'];?> </label>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4"> 
						<label> Téléphone : </label>		<label> <?php echo $data['contactPatient'];?> </label> 
				</div> 
			</div>
			<div class="row">
				<div class="col-xs-4"> 
						<label> Employeur : </label>		<label> <?php echo $data['professionPatient'];?> </label> 
				</div> 
			</div>
			<div class="row">
				<div class="col-xs-4"> 
						<label> Téléphone : </label>		<label> <?php echo $data['contactPatient'];?> </label> 
				</div> 
			</div>
			<div class="row">
				<div class="col-xs-4">
					<label> Adresse   :</label>		<label> <?php echo $data['adressePatient'];?> </label> 
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<label> Antécédent   :</label>		<label> <?php echo $data['antecedent'];?> </label> 
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<label> Assuré   :</label>		<label> <?php echo $data['assurancePatient'];?> </label> 
				</div>
			</div>
		</div>
		</div>
		<?php echo $this->displayPatientFolderByServices($data['numDossier'], $data['nomPatient'], $data['PrenomPatient']);?>
		<!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div id="patientActe" class="white-popup mfp-hide">
	<div class="register-box-body">
	<p class="login-box-msg">Enregistrer un acte</p>
	<form class="form" action="./index.php?p=patientfolder&detail=<?php echo $_GET['detail'];?>" method="post" name="formname">
		<input type="hidden" name="formname" value="addActe">
		<input type="hidden" name="numDossier" value="<?php echo $data['numDossier']?>">
		<div class="form-group">
		<label>Actes</label>
			<select id="acte" name="acte" class="form-control">
			</select>
		</div>
		<div class="form-group has-feedback">
			<label >Règlement(en FCFA)</label>
			<input id="reglement" type="text" min="0" class="form-control" placeholder="Entrez le montant reçu" name="versement" value="0"/>
		</div>
		<div class="form-group has-feedback">
			<label>Montant à régler :</label>
			<div id="facturation"></div>
		</div>
		<div class="row">
			<div class="col-xs-6">
			<button type="cancel" class="btn btn-block btn-flat">Annuler</button>
			</div>
		<div class="col-xs-6">
			<button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Valider</button>
		</div><!-- /.col -->
		</div>
		
	</form>

	</div><!-- /.form-box -->
</div>
</div>

<div id="addFolder" class="white-popup mfp-hide">
	<div class="register-box-body">
	<p class="login-box-msg">Création de dossier</p>
	<form class="form" action="./index.php?p=patientfolder&detail=<?php echo $_GET['detail'];?>" method="post" name="formname">
		<input type="hidden" name="formname" value="addNewFolder">
		<input type="hidden" name="numDossier" value="<?php echo $data['numDossier']?>">
		<div class="form-group">
		<label>Service</label>
		<select name="service" class="form-control service">
<!-- 			<option value="">-- Services --</option> -->
		</select>
		</div>
		<div class="form-group">
		<label>Actes</label>
		<select id="acte" name="acte" class="form-control">
		</select>
		</div>
		<div class="form-group has-feedback">
			<label>Règlement</label>
			<input  id="reglement" type="number" min="0" class="form-control" placeholder="Entrez le montant reçu" name="versement" value="0"/>
		</div>
<!-- 		<div class="form-group has-feedback"> -->
<!-- 		<label>Observation</label> -->
<!-- 		<input type="text" class="form-control" name="observation" placeholder="Entrez une observation"/> -->
<!-- 		</div> -->
		<div class="form-group has-feedback">
		<label>Coût :</label>
		<div id="facturation"></div>
		</div>
		<div class="row">
			<div class="col-xs-6">
			<button type="cancel" class="btn btn-block btn-flat">Annuler</button>
			</div>
		<div class="col-xs-6">
			<button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Valider</button>
		</div><!-- /.col -->
		</div>
		
	</form>
	</div><!-- /.form-box -->
</div>
</div>
<style>
.white-popup {
position: relative;
background: #FFF;
padding: 20px;
width: auto;
max-width: 500px;
margin: 20px auto;
}
</style>
<script> 
//jQuery.noConflict();
	$('.open-popup-link').magnificPopup({
		type:'inline',
		midClick: true,
		showCloseBtn:false,
		closeOnBgClick:false, // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
		});
		
</script>