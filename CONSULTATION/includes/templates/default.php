<!DOCTYPE html>
<html>
<!--------------Head--------------->
<?php include 'includes/parts/head.php';  ?>
  <body class="skin-blue sidebar-collapse sidebar-mini">
    <div class="wrapper">
<!--------------Header--------------->
<?php include 'includes/parts/header.php';  ?>

<!--------------Menu--------------->
<?php include 'includes/parts/menu.php';  ?>

<!--------------Content--------------->
<?php $this->includePage();?>

<!--------------Footer--------------->
<?php include 'includes/parts/footer.php';  ?>

    </div><!-- ./wrapper -->

<!--------------Others / plugin Script /--------------->
<?php include 'includes/parts/otherscript.php';  ?>
  </body>
</html>
