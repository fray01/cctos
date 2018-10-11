<?php  
$name = isset($_SESSION['CREDIALS'])?  $_SESSION['CREDIALS']['name'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : $name;
if(empty($name)){header('location:../');}
session_unset();

?>
  <body class="lockscreen">
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
      <div class="lockscreen-logo">
        <a href="#"><b>CCTOS </b>Administration</a>
      </div>
      <!-- User name -->
      <div class="lockscreen-name"><?php echo $name ?></div>

      <!-- START LOCK SCREEN ITEM -->
      <div class="lockscreen-item">
        <!-- lockscreen image -->
        <div class="lockscreen-image">
          <img src="../files/dist/img/lock.png" alt="Lock"/>
        </div>
        <!-- /.lockscreen-image -->

        <!-- lockscreen credentials (contains the form) -->
        <form class="lockscreen-credentials" action="../index.php?p=login" method="post">
            <input type="hidden" name="formname" value="login"/>
            <input type="hidden" class="form-control" name="name" value="<?php echo $name ?>" />
          <div class="input-group">
            <input type="password" class="form-control" placeholder="Mot de passe" name="password" />
            <div class="input-group-btn">
              <button type="submit" class="btn" name="submit"><i class="fa fa-arrow-right text-muted"></i></button>
            </div>
          </div>
        </form><!-- /.lockscreen credentials -->

      </div><!-- /.lockscreen-item -->
      <div class="help-block text-center">
        Entrer votre mot de passe pour dévérouiller
      </div>
    </div><!-- /.center -->