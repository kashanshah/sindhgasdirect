<div class="loading-overlay">
    <div class="spin-loader"></div>
</div>
<style>
    <?php
    if($_SESSION["RoleID"] == ROLE_ID_ADMIN){
        $bgColor = '#dd4b39';
        $color = '#FFFFFF';
    }
    else if($_SESSION["RoleID"] == ROLE_ID_DRIVER){
        $bgColor = '#0073b7';
        $color = '#FFFFFF';
    }//d
    else if($_SESSION["RoleID"] == ROLE_ID_SHOP){
        $bgColor = '#00a65a';
        $color = '#FFFFFF';
    }
    else if($_SESSION["RoleID"] == ROLE_ID_SALES){
        $bgColor = '#605ca8';
        $color = '#FFFFFF';
    }
    else if($_SESSION["RoleID"] == ROLE_ID_CUSTOMER){
        $bgColor = '#FF0000';
        $color = '#FFFFFF';
    }
    else if($_SESSION["RoleID"] == ROLE_ID_PLANT){
        $bgColor = '#F39C12';
        $color = '#FFFFFF';
    }
    else{
        $bgColor = '#FF0000';
        $color = '#FFFFFF';
    }
?>
    .skin-blue .main-header li.user-header,
    .skin-blue .main-header .navbar,
    .skin-blue .main-header .navbar .nav > li > a:hover, .skin-blue .main-header .navbar .nav > li > a:active, .skin-blue .main-header .navbar .nav > li > a:focus, .skin-blue .main-header .navbar .nav .open > a, .skin-blue .main-header .navbar .nav .open > a:hover, .skin-blue .main-header .navbar .nav .open > a:focus, .skin-blue .main-header .navbar .nav > .active > a, .skin-blue .main-header .navbar .sidebar-toggle:hover, .skin-blue .main-header .logo, .skin-blue .main-header .logo:hover, .skin-blue .sidebar-menu > li:hover > a, .skin-blue .sidebar-menu > li.active > a {
        background-color: <?php echo $bgColor; ?>;
        color: <?php echo $color; ?>;
    }

    .btn-box-tool {
        color: <?php echo $bgColor; ?>;
    }

    .box-header.with-border,
    .box {
        border-color: <?php echo $bgColor; ?>;
        border-bottom-color: #f4f4f4;
    }
    .skin-blue .sidebar-menu > li > a{
        padding:5px 5px 7px 15px;
    }
    .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #fff;
        opacity: 0.6;
        z-index: 1040;
    }

    .spin-loader {
        height: 100%;
        background: url("assets/images/loader.gif") no-repeat center center transparent;
        position: relative;
        top: 25%;
    }

</style>
<header class="main-header">

    <!-- Logo -->
    <a href="index.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><?php echo COMPANY_NAME ?></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><?php echo COMPANY_NAME; ?></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <!--  Menu toggle button -->
                <li class="dropdown messages-menu">
                    <!-- inner menu: contains the messages --
                    <ul class="menu">
                      <li><!-- start message --
                        <a href="#">
                          <div class="pull-left">
                            <!-- User Image --
                            <img src="<?php // echo ($_SESSION["Image"] == "" ? 'dist/img/user2-160x160.jpg' : DIR_USER_IMAGES.$_SESSION["Image"]) ?>" class="img-circle" alt="User Image">
                          </div>
                          <!-- Message title and timestamp --
                          <h4>
                            Support Team
                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                          </h4>
                          <!-- The message --
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li><!-- end message --
                    </ul><!-- /.menu --
                  </li>
                  <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
              </li><!-- /.messages-menu -->

                    <!-- Notifications Menu -->
                <?php
                $NotifCount = getNotificationCount($_SESSION["ID"], $_SESSION["RoleID"]);
                ?>
                    <li class="dropdown notifications-menu">
                      <!-- Menu toggle button -->
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                          <?php echo ($NotifCount == 0 ? '' : '<span class="label label-danger">'.$NotifCount.'</span>'); ?>
                      </a>
                      <ul class="dropdown-menu">
                        <li class="header">You have <?php echo $NotifCount; ?> new notifications</li>
                        <li>
                          <ul class="menu">
                              <?php
                              $hQuer = "SELECT ID, Name, Description, Status, UserID, RoleID, Link, DATE_FORMAT(DateAdded, '%D %b, %Y %h:%i:%p ') AS DateAdded, DATE_FORMAT(DateModified, '%D %b, %Y %h:%i:%p ') AS DateModified FROM notifications
WHERE Status=0 AND UserID = " . (int)$_SESSION["ID"] . " AND  ID<>0 ORDER BY Priority, ID DESC ";
                              $hQuerRes = mysql_query($hQuer) or die(mysql_error());
                              while($hNotif = mysql_fetch_assoc($hQuerRes)){
                                  ?>
                              <li>
                                  <a href="#" onclick='markReadAndAction(<?php echo $hNotif["ID"]; ?>, "<?php echo $hNotif["Link"]; ?>")'>
                                      <span style="font-weight:bold;"><?php echo $hNotif["Name"]; ?><small class="pull-right"><?php echo $hNotif["DateAdded"]; ?></small></span>
                                      <br/><?php echo $hNotif["Description"]; ?>
                                  </a>
                              </li>
                              <?php

                              }

                              ?>
                          </ul>
                        </li>
                        <li class="footer"><a href="notifications.php">View all</a></li>
                      </ul>
                    </li>
                    <!--              <li class="dropdown tasks-menu">
                                    <!-- Menu Toggle Button --
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                      <i class="fa fa-flag-o"></i>
                                      <span class="label label-danger">9</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                      <li class="header">You have 9 tasks</li>
                                      <li>
                                        <!-- Inner menu: contains the tasks --
                                        <ul class="menu">
                                          <li><!-- Task item --
                                            <a href="#">
                                              <!-- Task title and progress text --
                                              <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                              </h3>
                                              <!-- The progress bar --
                                              <div class="progress xs">
                                                <!-- Change the css width attribute to simulate progress --
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                  <span class="sr-only">20% Complete</span>
                                                </div>
                                              </div>
                                            </a>
                                          </li><!-- end task item --
                                        </ul>
                                      </li>
                                      <li class="footer">
                                        <a href="#">View all tasks</a>
                                      </li>
                                    </ul>
                                  </li> -->
                    <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="<?php echo($_SESSION["Image"] == "" ? 'dist/img/user2-160x160.jpg' : DIR_USER_IMAGES . $_SESSION["Image"]) ?>"
                             class="user-image" alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs"><?php echo $_SESSION["Username"]; ?></span>

                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="<?php echo($_SESSION["Image"] == "" ? 'dist/img/user2-160x160.jpg' : DIR_USER_IMAGES . $_SESSION["Image"]) ?>"
                                 class="img-circle" alt="User Image">
                            <p>
                                <span style="color:black; font-weight: bold"><?php echo $_SESSION["Name"]; ?></span>
                                <small>Last Login at:<br/> <?php echo $_SESSION["LastLogin"]; ?></small>
                            </p>
                        </li>

                        <!-- Menu Body -->
                        <li class="user-body">
                            <!--                    <div class="col-xs-4 text-center">
                                                  <a href="#">Followers</a>
                                                </div>
                                                <div class="col-xs-4 text-center">
                                                  <a href="#">Sales</a>
                                                </div>
                                                <div class="col-xs-4 text-center">
                                                  <a href="#">Friends</a>
                                                </div> -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="profile.php"
                                   class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="text-right">
                                <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button
                <li>
                  <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
                -->
            </ul>
        </div>
    </nav>
</header>