<aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo ($_SESSION["Image"] == "" ? 'dist/img/user2-160x160.jpg' : DIR_USER_IMAGES.$_SESSION["Image"]) ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo $_SESSION["Username"]; ?></p>
              <!-- Status -->
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

         

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">Menu</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="<?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/dashboard.php") ? 'active' : ''); ?>" ><a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
<?php
if($_SESSION["RoleID"] == 1 || $_SESSION["RoleID"] == 2)
{
	?>
            <li class="treeview <?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/students.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/users.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/customers.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/suppliers.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/staff.php") ? 'active' : ''); ?>">
              <a href="#"><i class="fa fa-group"></i> <span>User Management</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li class="<?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/users.php") ? 'active' : ''); ?>"><a href="users.php"><i class="fa fa-circle-o"></i>Users</a></li>
              </ul>
            </li>
<?php
}
?>

<?php
if($_SESSION["RoleID"] == 1 || $_SESSION["RoleID"] == 2 || $_SESSION["RoleID"] == 3)
{
?>
            <li class="treeview <?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/cylinders.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/addcylinder.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/editcylinder.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/cylindertosales.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/returntoshop.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/returntoplant.php") ? 'active' : ''); ?>">
				<a href="#"><i class="fa fa-cube"></i> <span>Cylinder Management</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
				<?php
				if($_SESSION["RoleID"] == 1 || $_SESSION["RoleID"] == 3)
				{
					?>
                <li class="<?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/cylinders.php") ? 'active' : ''); ?>"><a href="cylinders.php"><i class="fa fa-circle-o"></i>Cylinders</a></li>
			  <?php
				}
				?>
				<?php
				if($_SESSION["RoleID"] == 1)
				{
					?>
							<li class="<?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/cylindertosales.php") ? 'active' : ''); ?>">
							  <a href="cylindertosales.php"><i class="fa fa-circle-o"></i>Dispatch Cylinders</a>
							</li>
				<?php
				}
				?>
				<?php
				if($_SESSION["RoleID"] == 2)
				{
					?>
							<li class="<?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/cylindertoshop.php") ? 'active' : ''); ?>">
							  <a href="cylindertoshop.php"><i class="fa fa-circle-o"></i>Deliver Cylinders</a>
							</li>
				<?php
				}
				?>
				<?php
				if($_SESSION["RoleID"] == 3)
				{
					?>
							<li class="<?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/returntoshop.php") ? 'active' : ''); ?>"><a href="returntoshop.php"><i class="fa fa-circle-o"></i>Cylinder Returns</a></li>
				<?php
				}
				?>
				<?php
				if($_SESSION["RoleID"] == 1 || $_SESSION["RoleID"] == 2)
				{
					?>
							<li class="<?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/returntoplant.php") ? 'active' : ''); ?>"><a href="returntoplant.php"><i class="fa fa-circle-o"></i>Cylinder Returns</a></li>
				<?php
				}
				?>
              </ul>
            </li>
<?php
}
?>
<?php
if($_SESSION["RoleID"] == 1 || $_SESSION["RoleID"] == 3)
{
?>
            <li class="treeview <?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/purchases.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/addpurchase.php") ? 'active' : ''); ?>">
				<a href="#"><i class="fa fa-cube"></i> <span>Purchase Management</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li class="<?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/purchases.php") ? 'active' : ''); ?>"><a href="purchases.php"><i class="fa fa-circle-o"></i>Purchases</a></li>
				<?php
				if($_SESSION["RoleID"] == 3)
				{
				?>
                <li class="<?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/addpurchase.php") ? 'active' : ''); ?>"><a href="addpurchase.php"><i class="fa fa-circle-o"></i>Add Purchase</a></li>
				<?php
				}
				?>
			  </ul>
            </li>
<?php
}
?>
<?php
if($_SESSION["RoleID"] == 1 || $_SESSION["RoleID"] == 3)
{
?>
            <li class="treeview <?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/sales.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/addsale.php") ? 'active' : ''); ?>">
				<a href="#"><i class="fa fa-cube"></i> <span>Sale Management</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li class="<?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/sales.php") ? 'active' : ''); ?>"><a href="sales.php"><i class="fa fa-circle-o"></i>Sales</a></li>
				<?php
				if($_SESSION["RoleID"] == 3)
				{
				?>
                <li class="<?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/addsale.php") ? 'active' : ''); ?>"><a href="addsale.php"><i class="fa fa-circle-o"></i>Add Sale</a></li>
				<?php
				}
				?>
			  </ul>
            </li>
<?php
}
?>
<?php
if($_SESSION["RoleID"] == 1 || $_SESSION["RoleID"] == 2)
{
	?>
            <li class="treeview <?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/students.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/admins.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/customers.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/suppliers.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/staff.php") ? 'active' : ''); ?>">
              <a href="#"><i class="fa fa-group"></i> <span>Shop Management</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
            
              </ul>
            </li>
<?php
}
?>
<?php
if($_SESSION["RoleID"] == 1 || $_SESSION["RoleID"] == 2)
{
	?>
            <li class="treeview <?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/students.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/admins.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/customers.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/suppliers.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/staff.php") ? 'active' : ''); ?>">
              <a href="#"><i class="fa fa-group"></i> <span>Accounts</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
            
              </ul>
            </li>
<?php
}
?>
<?php
if($_SESSION["RoleID"] == 1 || $_SESSION["RoleID"] == 2)
{
	?>
            <li class="treeview <?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/students.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/admins.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/customers.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/suppliers.php") ? 'active' : ''); ?><?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/staff.php") ? 'active' : ''); ?>">
              <a href="#"><i class="fa fa-group"></i> <span>Reports</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
            
              </ul>
            </li>
<?php
}
?>
<?php
if($_SESSION["RoleID"] == 1)
{
	?>
            <li class="<?php echo (($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/config.php") ? 'active' : ''); ?>">
              <a href="config.php"><i class="fa fa-gear"></i> <span>Configurations</span></a>
            </li>
<?php
}
?>
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>