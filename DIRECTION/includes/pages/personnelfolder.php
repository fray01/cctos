<?php 
$data = null;
$info = null;
$dataParent = null;
$formname = isset($_GET['parent']) ? 'updateNewMember':'addNewMember';
$name = isset($_GET['parent']) ? 'update' : 'submit';

	if (isset($_GET['detail'])) {
		$idPersonnel = $_GET['detail'];
		$data = $this->readEmployee($idPersonnel);
	}
	if (isset($_POST['submit'])){
		$info = $this->addPersonnelNewFamilyMember();
	}
	elseif (isset($_POST['update'])){
		$info = $this->updatePersonnelNewFamilyMember();
	}
	if (isset($_GET['detail']) && isset($_GET['parent'])) {
		$idParent = $_GET['parent'];
		$dataParent = $this->readAffiliation($idParent);
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
	<div class="box box-info">
		<div class="box-header">
				<i class="fa fa-user"></i>
				<h3 class="box-title">Informations du Personnel</h3>
				<!-- tools box -->
				<div class="pull-right box-tools">
					<a id="member" href="#addMember" class="btn btn-info btn-sm open-popup-link" data-toggle="tooltip"> Ajouter ayant droit</a>
					<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa fa-minus"></i></button>
					<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
				</div><!-- /. tools -->
		</div>
		<div class="box-body">
		<div class="col-xs-2">
			<div class="image">
				<img src="<?php echo '../'.$data["vignettePersonnel"];?>" class="img-circle" alt="User Image" height="128" width="128">
			</div>
		</div>
		<div class="col-xs-8">
			<div class="row">
					<div class="col-xs-6">
						<label> Matricule N° </label> <label> <?php echo $data['matriculePersonnel'];?> </label>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<label> Nom    : </label>
						<label> <?php echo $data['nomPersonnel'];?> </label>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<label> Prénoms   :</label>
						<label> <?php echo $data['PrenomPersonnel'];?> </label>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<label> Date de naissance:  <?php echo $data['DDNPersonnel'];?> </label>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<label> Adresse   :</label>	
						<label> <?php echo $data['adressePersonnel'];?> </label> 
					</div>
				</div>
				<div class="row">
				</div>
			</div>
		</div>
		</div>
		<?php 
			echo $this->displayEmployeesFamilyMembers($data['idPersonnel'], $data['matriculePersonnel'],$data['nomPersonnel'],$data['PrenomPersonnel']);
			echo $this->displayPersonnelActivities($data['idPersonnel'],$data['nomPersonnel'],$data['PrenomPersonnel']);
			echo $this->displayPersonnelStat($data['idPersonnel'], $data['nomPersonnel'],$data['PrenomPersonnel']);
		?>
		
	<!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div id="addMember" class="white-popup mfp-hide">
		<div class="register-box-body">
			<p class="login-box-msg">Ajout d'ayant droits</p>
			<form action="./index.php?p=personnelfolder&detail=<?php echo $_GET['detail'];?>" method="post" name="formname" enctype="multipart/form-data">
				<input type="hidden" name="formname" value="<?php echo $formname?>">
				<input type="hidden" name="idPersonnel" value="<?php echo $data['idPersonnel']?>">
				<input type="hidden" name="idParent" value="<?php echo $dataParent['idParent']?>">
				<div class="form-group">
				<label>Nom & Prénoms</label>
					<input type="text" class="form-control" placeholder="Nom & Prénoms" name="nomParent" value="<?php echo $dataParent['nomParent'];?>"/>
				</div>
				<div class="form-group has-feedback">
					<label> Image de profil</label>
					<input type="file" class="form-control" id="vignette" name="vignette"/>
					<input type="hidden" class="form-control" id="fileUpload" name="fileUpload" value="<?php echo $dataParent['vignetteParent'];?>"/>
				</div>
				<div class="form-group has-feedback">
					<label>Date de Naissance</label>
					<input type="date" class="form-control" name="DDNParent" value="<?php echo $dataParent['DDNParent'];?>"/>
				</div>
				<div class="form-group">
					<label>Ayant droits</label>
					<select id="type_affiliation" name="affiliation" class="form-control">
					<?php echo $this->optionAffiliation($dataParent['lienParent']);?>
					</select>
				</div>
		</div>
				<div class="row">
						<div class="col-xs-6">
						<button type="cancel" class="btn btn-block btn-flat">Annuler</button>
						</div>
					<div class="col-xs-6">
						<button type="submit" name="<?php echo $name ;?>" class="btn btn-primary btn-block btn-flat">Valider</button>
					</div><!-- /.col -->
				</div>
			</form>
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
		midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
		});
	$('.image-popup').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		image: {
			verticalFit: true
		}
		
	});
</script>
<?php echo isset($_GET['parent']) ? '<script> jQuery(function($){ $("#member").click() });</script>':'' ; ?>
