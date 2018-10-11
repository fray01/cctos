<?php
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
				<!-- quick email widget -->
						<div class="box box-info collapsed-box">
					<div class="box-header">
						<i class="fa fa-user-plus"></i>
						<h3 class="box-title">Ajouter Personnel</h3>
						<!-- tools box -->
						<div class="pull-right box-tools">
							<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa fa-plus"></i></button>
							<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
						</div><!-- /. tools -->
					</div>
					<div class="box-body">
							<div class="col-lg-3"></div>
						<form action="" method="post" class="col-lg-5" name="formname">
								<div class="form-group has-feedback">
									<input type="text" class="form-control" placeholder="Nom"/>
									<span class="glyphicon glyphicon-notes form-control-feedback" name="nom"></span>
								</div>
								<div class="form-group has-feedback">
									<input type="text" class="form-control" placeholder="Prénom"/>
									<span class="glyphicon glyphicon-notes form-control-feedback" name="prenom"></span>
								</div>
								<div class="form-group has-feedback">
									<label>Date de naissance</label>
									<input type="date" class="form-control"/>
									<span class="glyphicon glyphicon-calendar form-control-feedback" name="ddn"></span>
								</div>
								<div class="form-group has-feedback">
									<label>Sexe :</label>
									<div class="row">
										<div class="col-xs-4">
												<label>
													<input type="radio" name="sexe" id="H" value="H" checked />Homme
												</label>
										</div><!-- /.col -->
										<div class="col-xs-4">
												<label>
													<input type="radio" name="sexe" id="F" value="F">Femme
												</label>
										</div><!-- /.col -->
									</div>
								</div>
								<div class="form-group	has-feedback">
								<label>Fonction</label>
								<select class="form-control" name="fonction">
									<option value="">Praticien</option>
									<option value="">Etudiant</option>
									<option value="">Autre</option>
								</select>
								</div>
								<div class="form-group has-feedback">
										<input type="number" class="form-control" placeholder="Contact"/>
									<span class="glyphicon glyphicon-earphone form-control-feedback" name="contact"></span>
								</div>
								<div class="form-group has-feedback">
									<input type="text" class="form-control" placeholder="Adresse"/>
									<span class="glyphicon glyphicon-map-marker form-control-feedback" name="adresse"></span>
								</div>
								<div class="form-group	has-feedback">
								<label>Service</label>
								<select class="form-control" name="service">
									<option value="">PARO</option>
									<option value="">ODF</option>
									<option value="">PEDO</option>
								</select>
								</div>
						</form>
					</div>
					<div class="box-footer clearfix">
						<button class="pull-right btn btn-primary" id="sendEmail" name="">Valider <i class="fa fa-check-circle"></i></button>
					</div>
				</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<i class="fa fa-user-md"></i>
						<h3 class="box-title">Liste du personnel</h3>
						<!-- tools box -->
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
						</div><!-- /. tools -->
					</div><!-- /.box-header -->
					<div class="box-body">
						<table id="gridAffaire" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>id</th>
									<th>Nom</th>
									<th>Prénom</th>
									<th>Age</th>
									<th>Sexe</th>
									<th>Profession</th>
									<th>Contact</th>
									<th>Adresse</th>
									<th>Services</th>
									<th> </th>
								</tr>
							</thead>
							<tbody>
						 <?php 
						for ($i = 1; $i < 15; $i++) {
						 echo '
								<tr>
									<th>',$i,'</th>
									<td>Akissi</td>
									<td>Franceline</td>
									<td>36</td>
									<td>H</td>
									<td>Medecin</td>
									<td>08581942</td>
									<td>2 Plateaux</td>
									<td>ODF</td>
									<td><a href="#"><span class="label label-info">Affectation</span></a></td>
								</tr>';
							}
						 ?>
							</tbody>
							<tfoot>
								<tr>
									<th>id</th>
									<th>Nom</th>
									<th>Prénom</th>
									<th>Age</th>
									<th>Sexe</th>
									<th>Profession</th>
									<th>Contact</th>
									<th>Adresse</th>
									<th>Services</th>
									<th> </th>
								</tr>
							</tfoot>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->