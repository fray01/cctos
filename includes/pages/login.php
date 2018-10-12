<?php
	$data = null;
	$login = null;
	$formname = 'login';
	if(isset($_POST['submit'])) {
    print_r ($_POST);
    $data = $this->login();
		$login = isset($_POST['name']) ? $_POST['name'] : '';
	}
?>  
<body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b>CCTOS </b>Administration</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Connectez Vous</p>
        <?php 
        if(!empty($data)){
            if ($data["error"]) {
                echo ' <div class="alert alert-'.$data["type"].' alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                    . '<h4><i class="icon fa fa-warning"></i> Désolé!</h4>'
                    . ''.$data["info"].' </div>';
            }
            else {
                echo ' <div class="alert alert-'.$data["type"].' alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                    . '<h4><i class="icon fa fa-success"></i>Félicitation!</h4>'
                    . ''.$data["info"].' </div>';
            }
           }
        ?>
        <form action="./index.php?p=login" method="post">
          <div class="form-group has-feedback">
            <input type="hidden" name="formname" value="<?php echo $formname; ?>"/>
            <input type="text" class="form-control" placeholder="login" name="name" value="<?php echo $login; ?>"/>
            <span class="glyphicon glyphicon-open form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
              <input type="password" class="form-control" placeholder="Mot de passe" name="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Se souvenir de moi
                </label>
              </div>                        
            </div><!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat" value="submit" name="submit">Entrer </button> 
            </div><!-- /.col -->
          </div>
        </form>	
        <!--<a href="#">Mot de passe oublié</a><br>-->
      <!--<a href="index.php?p=register" class="text-center">Créer un compte</a>-->

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->