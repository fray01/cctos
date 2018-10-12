<?php 
$data = null;
$idService = 0;
$numDossier = 0;
$lab = null;
	if (isset($_GET['detail']) && isset($_GET['id']) && isset($_GET['lab'])) {
		$numDossier = (int)$_GET['detail'];
		$data = $this->readPatientFolder($numDossier);
		$idService = (int)$_GET['id'];
		$lab = (string)$_GET['lab'];
	}
	?> 
 <div class="wrapper print">
      <!-- Main content -->
      <section class="invoice">
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
              <i class="fa fa-user-md"></i> CCTOS, CHU COCODY.
              <small class="pull-right">Date : <?php echo date('d-m-Y'); ?></small>
            </h2>
          </div><!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
		
            <h2>
			<div class="row">
				<div class="col-xs-11 pull-right"> <?php echo $lab ;?></div>
			<div>
            </h2>
          <div class="col-sm-4 invoice-col">
		  <strong>N° <?php echo $data['numDossier'] ; ?></strong>
            <address>
              <strong><?php echo $data['nomPatient'] .', '.$data['PrenomPatient'] ; ?></strong><br>
           <b>Date de naissance</b> :  <?php echo $data['DDNPatient'] ; ?><br>
           <b>Sexe</b> :  <?php echo $data['sexePatient'] ; ?><br>
            </address>
          </div><!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <address>
			<b>Contact</b> :  <?php echo $data['contactPatient'] ; ?> <br>
			<b>Profession</b> :  <?php echo $data['professionPatient'] ; ?><br/>
            <b>Adresse</b> : <?php echo $data['adressePatient'] ; ?><br/>
            </address>
          </div><!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <b>Père</b> : <?php echo $data['perePatient'] ; ?><br/>
            <b>Mère</b> : <?php echo $data['merePatient'] ; ?><br/>
            <b>Assuré</b> : <?php echo $data['assurancePatient'] ; ?><br/>
            <b>Antecedent</b> : <?php echo $data['antecedent'] ; ?><br/>
          </div><!-- /.col -->
        </div><!-- /.row -->

	<?php echo $this->displayPatientPrintFolder($idService, $numDossier); ?>
		

        <div class="row">
          <!-- accepted payments column -->
          <div class="col-xs-6">

          </div><!-- /.col -->
          <div class="col-xs-6">

          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->
    </div><!-- ./wrapper -->
    <!-- AdminLTE App -->
	<script>
window.print();
	</script>