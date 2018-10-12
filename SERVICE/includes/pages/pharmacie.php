<?php 
	$info=null;
    $produit = null;
	$formname = isset($_GET['id']) ? 'useProduit':'';
	$name = isset($_GET['id']) ? 'update' : '';
	$id = isset($_GET['id']) ? (int)$_GET['id'] : '';
	$cod = isset($_GET['cod']) ? (int)$_GET['cod'] : 0;
	if(isset($_GET['id']) && isset($_POST['update'])) {
	//	$info = $this->useProduit();
	}
	if(isset($_POST['use'])){	
	$info = $this->useProduct();
	}
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
	<?php 
	
        if(!empty($info)){
				echo '<div class="alert alert-'.$info["type"].' alert-dismissable"><i class="icon fa fa-info-circle"></i>'
					. '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
					.$info["info"].' </div>' ;
           }
?>
            <?php echo $this->displayOut(); ?>

</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div id="useProduct" class="white-popup mfp-hide">

    <p class="login-box-msg">Produits utilisés</p>

    <form action="./index.php?p=pharmacie" method="post" name="formname">
        <input type="hidden" name="formname" value="useProduct">
        <input type="hidden" name="idSortie" value="<?php echo $cod;?>">

        <div class="form-group has-feedback">
                <label>Quantité :</label>
                <input type="number" class="form-control" name="qte" value="" min="1"/>
                <span class="glyphicon glyphicon-notes form-control-feedback"></span>
        </div>
        <div class="row">
                <div class="col-xs-6">
                <button type="cancel" class="btn btn-block btn-flat">Annuler</button>
                </div>
              <div class="col-xs-6">
                 <button type="submit" class="btn btn-block btn-primary btn-flat" name="use">Valider</button>
              </div><!-- /.col -->
        </div> 
    </form>

  </div><!-- /.form-box -->
  

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

</script> 
<?php echo isset($_GET['cod']) ? '<script> jQuery(function($){ $("#bUseProduct").click() });</script>':'' ; ?>
