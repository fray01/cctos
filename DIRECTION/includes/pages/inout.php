<?php
$back = '<a href="'.$this->previousPage().'"><i class="fa fa-arrow-circle-left"></i></a>';
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
			<?php echo $back;?>
		GESTION DES STOCKS
		<small>Aperçu</small>
	</h1>
</section>

<!-- Main content -->
<section class="content">
	<?php echo $this->displayIn(); ?>
	<?php echo $this->displayOut(); ?>
</section><!-- /.content -->
</div><!-- /.content-wrapper -->