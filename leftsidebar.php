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
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "cylinders.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addcylinder.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editcylinder.php") ? 'active' : ''); ?>"><a href="cylinders.php"><i class="fa fa-cubes"></i>Cylinders</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "cylindertypes.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addcylindertype.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editcylindertype.php") ? 'active' : ''); ?>"><a href="cylindertypes.php"><i class="fa fa-cube"></i>Cylinder Types</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "viewinventory.php") ? 'active' : ''); ?>"><a href="viewinventory.php"><i class="fa fa-cubes"></i>Inventory</a></li>

                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "users.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "users.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "edituser.php") ? 'active' : ''); ?>"><a href="users.php"><i class="fa fa-users"></i>Users</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "plants.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addplant.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editplant.php") ? 'active' : ''); ?>"><a href="plants.php"><i class="fa fa-industry"></i>Plants</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "shops.php") ? 'active' : ''); ?> <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addshop.php") ? 'active' : ''); ?> <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editshop.php") ? 'active' : ''); ?>"><a href="shops.php"><i class="fa fa-building"></i> <span>Shops</span></a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "salesmans.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addsalesman.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editsalesman.php") ? 'active' : ''); ?>"><a href="salesmans.php"><i class="fa fa-user"></i>Salesmans</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "customers.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addcustomer.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editcustomer.php") ? 'active' : ''); ?>"><a href="customers.php"><i class="fa fa-users"></i>Customers</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "drivers.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "adddriver.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editdriver.php") ? 'active' : ''); ?>"><a href="drivers.php"><i class="fa fa-truck"></i>Drivers</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "vehicles.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addvehicle.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editvehicle.php") ? 'active' : ''); ?>"><a href="vehicles.php"><i class="fa fa-truck"></i>Vehicles</a></li>

                <li class="header"></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "savings.php") ? 'active' : ''); ?>"><a href="savings.php"><i class="fa fa-star"></i>Savings & Wastages</a></li>
                <li class="header"></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "paymentmethods.php") ? 'active' : ''); ?>"><a href="paymentmethods.php"><i class="fa fa-money"></i>Payment Methods</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "payments.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addpayment.php") ? 'active' : ''); ?>"><a href="payments.php"><i class="fa fa-dollar"></i>Payments</a></li>

                <li class="header"></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "sales.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addsale.php") ? 'active' : ''); ?>"><a href="sales.php"><i class="fa fa-cart-plus"></i>Sales</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "purchases.php") ? 'active' : ''); ?>"><a href="purchases.php"><i class="fa fa-cart-arrow-down"></i>Purchases</a></li>

                <li class="header"></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "reports.php") ? 'active' : ''); ?>">
                    <a href="reports.php"><i class="fa fa-newspaper-o"></i> <span>Reports</span></a>
                </li>
                <li class="header"></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "config.php") ? 'active' : ''); ?>">
                    <a href="config.php"><i class="fa fa-gear"></i> <span>Configurations</span></a>
                </li>
                <!--NEW MENU -->


                <?php
            }
            else if ($_SESSION["RoleID"] == ROLE_ID_DRIVER) {
                ?>
                <li class="treeview <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "viewinventory.php") ? 'active' : ''); ?>">
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
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "viewinventory.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addpurchase.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "returntoshop.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "cylindershoptodriver.php") ? 'active' : ''); ?>"><a href="viewinventory.php"><i class="fa fa-building"></i>Inventory</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "sales.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addsale.php") ? 'active' : ''); ?>"><a href="sales.php"><i class="fa fa-cart-plus"></i>Sales</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "purchases.php") ? 'active' : ''); ?>"><a href="purchases.php"><i class="fa fa-cart-arrow-down"></i>Purchases</a></li>
                <li class="header"></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "savings.php") ? 'active' : ''); ?>"><a href="savings.php"><i class="fa fa-star"></i>Savings & Wastages</a></li>
                <li class="header"></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "paymentmethods.php") ? 'active' : ''); ?>"><a href="paymentmethods.php"><i class="fa fa-money"></i>Payment Methods</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "payments.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addpayment.php") ? 'active' : ''); ?>"><a href="payments.php"><i class="fa fa-dollar"></i>Payments</a></li>
                <li class="header"></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "reports.php") ? 'active' : ''); ?>">
                    <a href="reports.php"><i class="fa fa-newspaper-o"></i> <span>Reports</span></a>
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
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "cylindershoptodriver.php") ? 'active' : ''); ?>">
                    <a href="cylindershoptodriver.php"><i class="fa fa-circle-o"></i>Cylinder Return to Driver</a></li>
                </li>

                <!--NEW MENU -->


                <?php
            }
            else if ($_SESSION["RoleID"] == ROLE_ID_PLANT) {
                ?>
                <li class="header"></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "cylinders.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addcylinder.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editcylinder.php") ? 'active' : ''); ?>"><a href="cylinders.php"><i class="fa fa-cubes"></i>Cylinders</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "cylindertypes.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addcylindertype.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editcylindertype.php") ? 'active' : ''); ?>"><a href="cylindertypes.php"><i class="fa fa-cube"></i>Cylinder Types</a></li>
                <li class="header"></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "purchases.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addpurchase.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "viewpurchase.php") ? 'active' : ''); ?>"><a href="purchases.php"><i class="fa fa-cart-arrow-down"></i>Purchases</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "sales.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addsale.php") ? 'active' : ''); ?>"><a href="sales.php"><i class="fa fa-cart-plus"></i>Sales</a></li>
                
                <li class="header"></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "shops.php") ? 'active' : ''); ?> <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addshop.php") ? 'active' : ''); ?> <?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editshop.php") ? 'active' : ''); ?>">
                    <a href="shops.php"><i class="fa fa-building"></i> <span>Shops</span></a>
                </li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "customers.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addcustomer.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editcustomer.php") ? 'active' : ''); ?>"><a href="customers.php"><i class="fa fa-users"></i>Customers</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "salesmans.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addsalesman.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editsalesman.php") ? 'active' : ''); ?>"><a href="salesmans.php"><i class="fa fa-user"></i>Salesmans</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "drivers.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "adddriver.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editdriver.php") ? 'active' : ''); ?>"><a href="drivers.php"><i class="fa fa-truck"></i>Drivers</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "vehicles.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addvehicle.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editvehicle.php") ? 'active' : ''); ?>"><a href="vehicles.php"><i class="fa fa-truck"></i>Vehicles</a></li>
                <li class="header"></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "cylindertostore.php") ? 'active' : ''); ?>"><a href="cylindertostore.php"><i class="fa fa-industry"></i>Fill Cylinders</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "viewinventory.php") ? 'active' : ''); ?>"><a href="viewinventory.php"><i class="fa fa-cube"></i>Inventory</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "cylindertosales.php") ? 'active' : ''); ?>"><a href="cylindertosales.php"><i class="fa fa-truck"></i>Dispatch Cylinders (OUT) </a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "returntoplant.php") ? 'active' : ''); ?>"><a href="returntoplant.php"><i class="fa fa-truck"></i>Return Cylinders (IN) </a></li>
                <li class="header"></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "savings.php") ? 'active' : ''); ?>"><a href="savings.php"><i class="fa fa-star"></i>Savings & Wastages</a></li>
                <li class="header"></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "paymentmethods.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addpaymentmethod.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "editpaymentmethod.php") ? 'active' : ''); ?>"><a href="paymentmethods.php"><i class="fa fa-money"></i>Payment Methods</a></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "payments.php") ? 'active' : ''); ?><?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "addpayment.php") ? 'active' : ''); ?>"><a href="payments.php"><i class="fa fa-dollar"></i>Payments</a></li>
                <li class="header"></li>
                <li class="<?php echo(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF']) . "reports.php") ? 'active' : ''); ?>">
                    <a href="reports.php"><i class="fa fa-newspaper-o"></i> <span>Reports</span></a>
                </li>


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