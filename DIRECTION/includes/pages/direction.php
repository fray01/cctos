<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		 <?php echo DIRECTORY; ?>
	</h1>
</section>

<!-- Main content -->
<section class="content">
	<!-- Info boxes -->
<div class="row">
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-aqua"><i class="fa fa-hospital-o"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">SERVICES</span>
				<span class="info-box-number"><?php echo $this->countService(); ?><small></small></span>
			</div><!-- /.info-box-content -->
		</div><!-- /.info-box -->
	</div><!-- /.col -->
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-red"><i class="fa fa-stethoscope"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">ACTES POSEES</span>
				<span id="poser" class="info-box-number"><?php echo $this->countPoser(); ?></span>
			</div><!-- /.info-box-content -->
		</div><!-- /.info-box -->
	</div><!-- /.col -->

	<!-- fix for small devices only -->
	<div class="clearfix visible-sm-block"></div>

	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-green"><i class="fa fa-wheelchair"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">PATIENT</span>
				<span class="info-box-number"><?php echo $this->countPatient(); ?></span>
			</div><!-- /.info-box-content -->
		</div><!-- /.info-box -->
	</div><!-- /.col -->
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">PERSONNEL</span>
				<span class="info-box-number"><?php echo $this->countPersonnel(); ?></span>
			</div><!-- /.info-box-content -->
		</div><!-- /.info-box -->
	</div><!-- /.col -->
</div><!-- /.row -->
<section class="content">
<div class="row">
	<!-- Left col -->
	<div class="col-md-7">
			<!-- DONUT CHART -->
		<div class="box box-danger">
			<div class="box-header with-border">
				<h3 class="box-title">STATISTIQUES PAR SERVICE</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-7">
						<div class="chart-responsive">
							<canvas id="pieChartPie" height="250"></canvas>
						</div><!-- ./chart-responsive -->
					</div><!-- /.col -->
					<div class="col-md-4">
						<ul class="chart-legend clearfix">
						</ul>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.box-body -->
			<div class="box-footer clearfix">
				<div class="col-xs-6">
					<label for="deb">Début: </label>
					<input class="bRange" id="deb" type="date" value="<?php echo date("Y-m-01"); ?>">
				</div>
				<div class="col-xs-4">
					<label for="fin">Fin: </label>
					<input class="bRange" id="fin" type="date" value="<?php echo date("Y-m-d"); ?>">
				</div>
			</div><!-- /.box-footer -->
		</div><!-- /.box -->
		<div class ="displayTodayInOut">
			<?php echo $this->displayTodayInOut();?>
		</div>
	</div>
	<div>
			<div class="col-md-5">
			<div class="box box-success">
				<div class="box-header with-border">
					<h3 class="box-title">STATISTIQUES PAR PATIENT</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div class="chart barbar">
						<canvas id="barChart" height="250"></canvas>
					</div>
				</div><!-- /.box-body -->
		</div><!-- /.box -->
		</div>
	</div>

		<div class="displayPersonnelIn">
			<?php echo $this->displayPersonnelIn();?>
		</div>
	</div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->