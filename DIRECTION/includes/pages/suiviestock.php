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
        <div class="row">
            <div class="col-xs-1"></div>
            <div class="col-xs-10">
                    <div class="box">
                            <div class="box-header">
                                    <i class="fa fa-cart-arrow-down"></i>
                                    <h3 class="box-title">Etat d'utilisation des produits</h3>
                                    <div class="box-tools pull-right">
                                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" title="Afficher/Masquer"></i></button>
                                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div><!-- /. tools -->
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                    <?php echo $this->displayStockUse(); ?>
                            </div><!-- /.box-body -->
                    </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->