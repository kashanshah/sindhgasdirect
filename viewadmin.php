<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
get_right(array(1, 2));

	$msg='';
	if(isset($_REQUEST['DID'])) $ID=$_REQUEST['DID'];
	else if(isset($_REQUEST['ID'])) $ID=$_REQUEST['ID'];
	else
	{
		$_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<b>Invalide user ID</b>
				</div>';
		redirect("users.php");
	}
	$sql="SELECT * FROM users where ID=".$ID;
	$resource=mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($resource) > 0)
	{
		$row=mysql_fetch_array($resource);
	}
	else
	{
		$_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<b>Invalide user ID</b>
				</div>';
		redirect("users.php");
	}

	if(isset($_REQUEST['DID']))
	{
			$query = "DELETE FROM users WHERE ID = ".$_REQUEST['DID']."";
			mysql_query($query);
			$_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Admin Deleted!</h4>
                  </div>';
			redirect("users.php");
	}
	
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITE_TITLE; ?>- View Admin</title>
	<link rel='shortcut icon' href='<?php echo DIR_LOGO_IMAGE.SITE_LOGO ?>' type='image/x-icon' >
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
      <?php include("header.php"); ?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php include("leftsidebar.php"); ?>
      

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Admin
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="users.php"><i class="fa fa-user"></i> users</a></li>
            <li class="active">View Admin</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <!-- /.box -->
				<form id="frmPages" action="<?php echo $self; ?>" class="form-horizontal" method="post">
              <div class="box ">
                <div class="box-header">
                      <div class="btn-group-right">
                       <button style="float:right;margin-right:15px;" type="button" class="btn btn-group-vertical btn-info" onClick="location.href='users.php'" >Back</button>
                       <button style="float:right;margin-right:15px;" type="button" class="btn btn-group-vertical btn-warning" onClick="location.href='editadmin.php?ID=<?php echo $ID; ?>'" >Edit</button>
                       <button style="float:right;margin-right:15px;" type="button" class="btn btn-group-vertical btn-danger" onClick="doSingleDelete(<?php echo $ID; ?>)" >Delete</button>
                       <button style="float:right;margin-right:15px;" type="button" class="btn btn-default " onClick="window.print()" ><i class="fa fa-print"></i> Print</button>
                      </div>
				</div>
			  </div>
<?php if(isset($msg) && $msg != "")  { echo $msg; $msg=""; } ?>
<?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
              <div class="box box-default">
				<div class="box-header with-border">
				  <h3 class="box-title">General Information</h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div>
                <div class="box-body">
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Image</label>
						<div class="col-md-6">
					  <?php if(isset($row["Image"]) && $row["Image"]!="") echo '<img style="width:130px;height:150px;" src="'.DIR_USER_IMAGES.$row["Image"].'" />'; ?>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Username</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $row["Username"] ;?>" readonly="" placeholder="Enter Name" name="Username">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Role</label>
						<div class="col-md-6">
							<select class="form-control" name="Gender" disabled="">
								<option value="1" <?php echo ($row["RoleID"] == ROLE_ID_ADMIN ? 'selected=""' : ''); ?> >Admin</option>
								<option value="2" <?php echo ($row["RoleID"] == ROLE_ID_DRIVER ? 'selected=""' : ''); ?> >Driver</option>
								<option value="3" <?php echo ($row["RoleID"] == ROLE_ID_SHOP ? 'selected=""' : ''); ?> >Shop</option>
							</select>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Name</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $row["Name"] ;?>" readonly="" placeholder="Enter Name" name="Name">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Password</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $row["Password"] ;?>" readonly="" placeholder="Enter Name" name="Password">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Remarks</label>
						<div class="col-md-6">
							<textarea class="form-control" name="Remarks"><?php echo $row["Remarks"] ;?></textarea>
						</div>
					</div>
                  </div><!-- /.box-body -->
                </div><!-- /.box-body -->
			<div class="box box-default">
				<div class="box-header with-border">
				  <h3 class="box-title">Contact Information</h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div>
                <div class="box-body">
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Email</label>
						<div class="col-md-6">
							<input type="email" class="form-control" id="example-email-input" value="<?php echo $row["Email"] ;?>" readonly="" placeholder="Enter Email" name="Email">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Contact Number</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $row["Number"] ;?>" readonly="" placeholder="Enter Contact Number" name="Number">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Address</label>
						<div class="col-md-6">
							<textarea class="form-control" name="Address"><?php echo $row["Address"] ;?></textarea>
						</div>
					</div>
                  
					</div>
                  </div><!-- /.box-body -->
                </div><!-- /.box-body -->
				  </form>
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <?php include("footer.php"); ?>
      

      <!-- Control Sidebar -->
      <?php include("rightsidebar.php"); ?>
      <!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
	<!-- Select2 -->
    <script src="plugins/select2/select2.full.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
<script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
      });
	function doSingleDelete(did)
	{		
		if(confirm("Are you sure you want to delete"))
		{		
			location.href='<?php echo $self;?>?DID='+did;
		}
		
	}
    </script>
</body>
</html>
