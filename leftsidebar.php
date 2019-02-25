<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo($_SESSION["Image"] == "" ? 'dist/img/user2-160x160.jpg' : DIR_USER_IMAGES . $_SESSION["Image"]) ?>"
                     class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $_SESSION["Username"]; ?></p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> <?php echo getValue('roles', 'Name', 'ID', $_SESSION["RoleID"]); ?></a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Menu</li>
            <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "dashboard.php") ? 'active' : ''); ?>">
                <a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <!-- Optionally, you can add icons to the links -->
            <?php
            if ($_SESSION["RoleID"] == ROLE_ID_ADMIN) {
                ?>
                <li class="treeview <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "cylinders.php") ? 'active' : ''); ?> <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addcylinder.php") ? 'active' : ''); ?> <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editcylinder.php") ? 'active' : ''); ?>">
                    <a href="#"><i class="fa fa-cube"></i> <span>Cylinders</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "cylinders.php") ? 'active' : ''); ?>">
                            <a href="cylinders.php"><i class="fa fa-circle-o"></i>View All Cylinders</a></li>
                    </ul>
                </li>

                <li class="treeview <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "viewinventory.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "cylindertosales.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "returntoplant.php") ? 'active' : ''); ?>">
                    <a href="#"><i class="fa fa-cube"></i> <span>Inventory</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "viewinventory.php") ? 'active' : ''); ?>">
                            <a href="viewinventory.php"><i class="fa fa-circle-o"></i>View Current Inventory </a></li>
                        <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "cylindertosales.php") ? 'active' : ''); ?>">
                            <a href="cylindertosales.php"><i class="fa fa-circle-o"></i>Dispatch Cylinders (OUT) </a></li>
                        <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "returntoplant.php") ? 'active' : ''); ?>">
                            <a href="returntoplant.php"><i class="fa fa-circle-o"></i>Cylinder Returns (IN)</a></li>
                    </ul>
                </li>


                <li class="treeview <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "shopaccounts.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "useraccounts.php") ? 'active' : ''); ?>">
                    <a href="#"><i class="fa fa-cube"></i> <span>Accounts</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "shopaccounts.php") ? 'active' : ''); ?>">
                            <a href="shopaccounts.php"><i class="fa fa-circle-o"></i>Shop Accounts</a></li>
                        <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "useraccounts.php") ? 'active' : ''); ?>">
                            <a href="useraccounts.php"><i class="fa fa-circle-o"></i>User Accounts</a></li>
                    </ul>
                </li>

                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "plants.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addplant.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editplant.php") ? 'active' : ''); ?>"><a href="plants.php"><i class="fa fa-industry"></i>Plants</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "shops.php") ? 'active' : ''); ?> <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addshop.php") ? 'active' : ''); ?> <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editshop.php") ? 'active' : ''); ?>">
                    <a href="shops.php"><i class="fa fa-building"></i> <span>Shops</span></a>
                </li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "salesmans.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addsalesman.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editsalesman.php") ? 'active' : ''); ?>"><a href="salesmans.php"><i class="fa fa-user"></i>Salesmans</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "customers.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addcustomer.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editcustomer.php") ? 'active' : ''); ?>"><a href="customers.php"><i class="fa fa-users"></i>Customers</a></li>

                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "config.php") ? 'active' : ''); ?>">
                    <a href="config.php"><i class="fa fa-gear"></i> <span>Configurations</span></a>
                </li>


                <!--NEW MENU -->


                <?php
            }
            else if ($_SESSION["RoleID"] == ROLE_ID_DRIVER) {
                ?>
                <li class="treeview <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "viewinventory.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "returntoshop.php") ? 'active' : ''); ?>">
                    <a href="#"><i class="fa fa-cube"></i> <span>Inventory</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "viewinventory.php") ? 'active' : ''); ?>">
                            <a href="viewinventory.php"><i class="fa fa-circle-o"></i>View Current Inventory </a></li>
                    </ul>
                </li>

                <!--NEW MENU -->


                <?php
            }
            else if ($_SESSION["RoleID"] == ROLE_ID_SHOP) {
                ?>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "customers.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addcustomer.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editcustomer.php") ? 'active' : ''); ?>"><a href="customers.php"><i class="fa fa-users"></i>Customers</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "salesmans.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addsalesman.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editsalesman.php") ? 'active' : ''); ?>"><a href="salesmans.php"><i class="fa fa-user"></i>Salesmans</a></li>

                <li class="treeview <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "customers.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addcustomer.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editcustomer.php") ? 'active' : ''); ?>">
                    <a href="#"><i class="fa fa-group"></i> <span>Customers</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "customers.php") ? 'active' : ''); ?>">
                            <a href="customers.php"><i class="fa fa-circle-o"></i>View Customers</a></li>
                        <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addcustomer.php") ? 'active' : ''); ?>">
                            <a href="addcustomer.php"><i class="fa fa-circle-o"></i>Add New Customer</a></li>
                    </ul>
                </li>

                <li class="treeview <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "viewinventory.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "returntoshop.php") ? 'active' : ''); ?>">
                    <a href="#"><i class="fa fa-cube"></i> <span>Inventory</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "viewinventory.php") ? 'active' : ''); ?>">
                            <a href="viewinventory.php"><i class="fa fa-circle-o"></i>View Current Inventory </a></li>
                        <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "returntoshop.php") ? 'active' : ''); ?>">
                            <a href="returntoshop.php"><i class="fa fa-circle-o"></i>Cylinder Return from Customer </a></li>
                    </ul>
                </li>

                <li class="treeview <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "sales.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addsale.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "useraccounts.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "purchases.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addpurchase.php") ? 'active' : ''); ?>">
                    <a href="#"><i class="fa fa-cube"></i> <span>Accounts</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "sales.php") ? 'active' : ''); ?>">
                            <a href="sales.php"><i class="fa fa-circle-o"></i>Sales</a></li>
                        <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "purchases.php") ? 'active' : ''); ?>">
                            <a href="purchases.php"><i class="fa fa-circle-o"></i>Purchases</a></li>
                        <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "useraccounts.php") ? 'active' : ''); ?>">
                            <a href="useraccounts.php"><i class="fa fa-circle-o"></i>User Accounts</a></li>
                    </ul>
                </li>

                <li class="treeview <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "salesmans.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addsalesman.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editsalesman.php") ? 'active' : ''); ?>">
                    <a href="#"><i class="fa fa-group"></i> <span>User Management</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "salesmans.php") ? 'active' : ''); ?>">
                            <a href="salesmans.php"><i class="fa fa-circle-o"></i>Salesmans</a></li>
                    </ul>
                </li>


                <!--NEW MENU -->


                <?php
            }
            else if ($_SESSION["RoleID"] == ROLE_ID_SALES) {
                ?>

                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addsale.php") ? 'active' : ''); ?>">
                    <a href="addsale.php"><i class="fa fa-circle-o"></i> <span>Add Sale</span></a>
                </li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "returntoshop.php") ? 'active' : ''); ?>">
                    <a href="returntoshop.php"><i class="fa fa-circle-o"></i>Cylinder Return from Customer </a></li>
                </li>

                <!--NEW MENU -->


                <?php
            }
            else if ($_SESSION["RoleID"] == ROLE_ID_PLANTS) {
                ?>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "shops.php") ? 'active' : ''); ?> <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addshop.php") ? 'active' : ''); ?> <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editshop.php") ? 'active' : ''); ?>">
                    <a href="shops.php"><i class="fa fa-building"></i> <span>Shops</span></a>
                </li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "customers.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addcustomer.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editcustomer.php") ? 'active' : ''); ?>"><a href="customers.php"><i class="fa fa-users"></i>Customers</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "salesmans.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addsalesman.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editsalesman.php") ? 'active' : ''); ?>"><a href="salesmans.php"><i class="fa fa-user"></i>Salesmans</a></li>
                <!--NEW MENU -->


                <?php
            }
             else {
    ?>





<?php }
?>

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>