<?php 
	$data = null;
	$formname = 'register';
	$name = 'submit';
	$bname = 'Créer';
	$title ='Créer un compte';
	$champ = '<input type="text" name="name" class="form-control" placeholder="Login"/>';
	$hideCombo ='';
	$about = '';
	$label ='';
	$logo = 'glyphicon-user';
	if(isset($_GET['id']) && isset($_GET['is']) ){
		$title ='Modifier le compte  ';
		$about = '<input type="hidden" name="uid" value="'.$_GET['id'].'"/>'.'<input type="hidden" name="name" value="'.$_GET['is'].'"/>';
		$formname = 'updateUser';
		$name = 'update';
		$bname = 'Modifier';
		$champ = '<input type="password" name="old_password" class="form-control" placeholder="Ancien mot de passe"/>';
		$hideCombo ='hide';
		$label = '<label for="service"> "'.$_GET['is'].'"</label>';
		$logo = 'glyphicon-lock';
	}
	
	if(isset($_POST['submit'])) {
		$data = $this->storeUser();
	}
	if(isset($_POST['update'])) {
		$data = $this->updateUser();
	}
$back = '<a href="'.$this->previousPage().'"><i class="fa fa-arrow-circle-left"></i></a>';
?> 
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo $back;?>
			 GESTION DES COMPTES
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">

        <?php
        if(!empty($data)){
            if ($data["error"]) {
                echo ' <div class="alert alert-'.$data["type"].' alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                    .$data["info"].' </div>';
            }
            else {
                echo ' <div class="alert alert-'.$data["type"].' alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                    .$data["info"].' </div>';
            }
           }
        
        ?>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
	  
	<div class="box box-danger">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo $title;?>  <?php echo $label;?></h3>
		</div>
		<div class="box-body">
        <form action="index.php?p=register" method="post">
			<div class="form-group <?php echo $hideCombo;?>">
					<label for="service">SERVICE</label>
					<select class="form-control" name="idService">
							<?php echo $this->optionServices(1);?>
					</select>
			</div>
          <div class="form-group has-feedback">
			
              <input type="hidden" name="formname" value="<?php echo $formname; ?>"/>
			<?php echo $about; ?>
			<?php echo $champ;?>
            
            <span class="glyphicon <?php echo $logo;?> form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Mot de passe"/>
            <span class="glyphicon  glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
              <div class="col-xs-6">
                    <a href="./index.php?p=register" class="btn btn-block btn-flat bg-purple">Terminer</a>
              </div>
            <div class="col-xs-6">
              <button type="submit" class="btn btn-primary btn-block btn-flat" name="<?php echo $name; ?>"><?php echo $bname; ?></button>
            </div><!-- /.col -->
          </div>
        </form>        
		</div>
       </div>
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->
	<?php echo $this->displayAccount();?>
	</section>
</div>