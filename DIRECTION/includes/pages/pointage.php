<?php
$back = '<a href="'.$this->previousPage().'"><i class="fa fa-arrow-circle-left"></i></a>';
?>
<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
			<?php echo $back;?>
				LISTE DE PRESENCE DU PERSONNEL
				<small>Aperçu</small>
			</h1>
		</section>

		<!-- Main content -->
		<section class="content">
		<?php echo $this->displayPersonnel();?>
		<?php echo $this->displayInOut();?>
		</section><!-- /.content -->
	</div><!-- /.content-wrapper -->
<!-- page script -->
