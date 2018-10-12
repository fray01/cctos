      <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>CCTOS</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>CCTOS</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Affichage Menu</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <!-- Notifications -->
				<li class="dropdown notifications-menu displayNotification">
					<?php // $this->displayNotification(); ?>
				</li>
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!--<img src="../files/dist/img/user2-160x160.jpg" class="user-image" alt="User Image"/>-->
                  <span class="hidden-xs"> <?php echo $_SESSION["CREDIALS"]["name"]; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <!--<img src="../files/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />-->
                    <p>
                      <?php echo $_SESSION["CREDIALS"]["name"]; ?>
                      <small> <?php echo DIRECTORY; ?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <!--<div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profil</a>
                    </div> -->
                    <div class="pull-left">
                      <a href="index.php?p=lockscreen" class="btn btn-default btn-flat">Vérrouiller</a>
                    </div>
                    <div class="pull-right">
                      <a href="index.php?logout=1" class="btn btn-default btn-flat">Déconnexion</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>