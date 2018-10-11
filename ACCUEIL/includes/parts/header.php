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
              <!-- Messages:
              <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-success">5</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Vous avez des messages</li>
                  <li>
                    <!-- inner menu: contains the actual data 
                    <ul class="menu">
                      <li><!-- start message 
                        <a href="#">
                          <div class="pull-left">
                            <img src="../files/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
                          </div>
                          <h4>
                            Admin
                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                          </h4>
                          <p>Avez vous acheté le matériel</p>
                        </a>
                      </li><!-- end message 
                    </ul>
                  </li>
                  <li class="footer"><a href="#">Voir tout</a></li>
                </ul>
              </li> -->
              <!-- Notifications 
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">10</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Vous avez 10 notifications</li>
                  <li>
                     inner menu: contains the actual data 
                    <ul class="menu">
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">Voir Tout</a></li>
                </ul>
              </li>-->
              <!-- Tâches:
              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-danger">9</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Vous avez 9 taches</li>
                  <li>
                    <!-- inner menu: contains the actual data 
                    <ul class="menu">
                      <li><!-- Task item 
                        <a href="#">
                          <h3>
                            Tâches peu importantes
                            <small class="pull-right">40%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">40% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li><!-- end task item 
                    </ul>
                  </li>
                  <li class="footer">
                    <a href="#">Voir tout</a>
                  </li>
                </ul>
              </li> -->
              <!-- User Account: style can be found in dropdown.less -->
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