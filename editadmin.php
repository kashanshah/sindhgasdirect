<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
get_right(array(1, 2));

	$msg='';
if(isset($_POST['editstd']) && $_POST['editstd']=='Update')
{
	$Email = $_REQUEST["Email"];					$Username = $_REQUEST["Username"];					$RoleID = $_REQUEST["RoleID"];
	$Name = $_REQUEST["Name"];						$FatherName = $_REQUEST["FatherName"];
	$NIC = $_REQUEST["NIC"];						$Number = $_REQUEST["Number"];						$Address = $_REQUEST["Address"];			
	$City = $_REQUEST["City"];						$Country = $_REQUEST["Country"];					
	$DOB = $_REQUEST["DOB"];						$Password = $_REQUEST["Password"];					$RepeatPassword = $_REQUEST["Password"];
	$BirthPlace = $_REQUEST["BirthPlace"];			$Gender = $_REQUEST["Gender"];
	$Religion = $_REQUEST["Religion"];				$Status = 1;
	$Remarks = $_REQUEST["Remarks"];				$ID = $_REQUEST["ID"];
	
		if(CAPTCHA_VERIFICATION == 1) { if(!isset($_POST["captcha"]) || $_POST["captcha"]=="" || $_SESSION["code"]!=$_POST["captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Incorrect Captcha Code</div>'; }
		else if($Name == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter Name</div>';
		else if($Password == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter A Password</div>';
		else if($RepeatPassword != $Password) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Password doesnot match.</div>';
//		else if(checkavailability('admins', 'Username', $Username) > 0) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Username not available choose another!</div>';
		else if(isset($_FILES["File"]) && $_FILES["File"]['name'] != "")
		{
			$filenamearray2=explode(".", $_FILES["File"]['name']);
			$ext2=End($filenamearray2);
		
			if(!in_array($ext2, $_IMAGE_ALLOWED_TYPES))
			{
				$msg='<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<b>Only '.implode(", ", $_IMAGE_ALLOWED_TYPES) . ' Images can be uploaded.
				</div>';
			}			
			else if($_FILES["File"]['size'] > (MAX_IMAGE_SIZE*1024))
			{
				$msg='<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				Image size must be ' . MAX_IMAGE_SIZE . ' KB or less.
				</div>';
			}
		}
		if($msg=="")
		{
			mysql_query("UPDATE admins SET DateModified= NOW(),
						RoleID='".(int)$RoleID."',
						Password='".dbinput($Password)."',
						Email='".dbinput($Email)."',
						Name='".dbinput($Name)."',
						FatherName='".dbinput($FatherName)."',
						NIC='".dbinput($NIC)."',
						Number='".dbinput($Number)."',
						Address='".dbinput($Address)."',
						City='".dbinput($City)."',
						Country='".dbinput($Country)."',
						DOB='".dbinput($DOB)."',
						BirthPlace='".dbinput($BirthPlace)."',
						Gender='".(int)$Gender."',
						Religion='".dbinput($Religion)."',
						AdmissionDate=NOW(),
						Remarks='".dbinput($Remark)."'
						WHERE ID=".(int)$ID."
						") or die(mysql_error());
			$msg='<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Admin details has been updated.
					</div>';
			if(isset($_FILES["File"]) && $_FILES["File"]['name'] != "")
			{
				if(is_file(DIR_USER_IMAGES . $StoreImage))
					unlink(DIR_USER_IMAGES . $StoreImage);
			
				ini_set('memory_limit', '-1');
				
				$tempName2 = $_FILES["File"]['tmp_name'];
				$realName2 = "S".$ID.".".$ext2;
				$StoreImage = $realName2; 
				$target2 = DIR_USER_IMAGES . $realName2;

				$moved2=move_uploaded_file($tempName2, $target2);
			
				if($moved2)
				{			
				
					$query2="UPDATE admins SET Image='" . dbinput($realName2) . "' WHERE  ID=" . (int)$ID;
					mysql_query($query2) or die(mysql_error());
				}
				else
				{
					$msg='<div class="alert alert-warning alert-dismissable">
						<i class="fa fa-ban"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<b>Admin details has been updated but Image can not be uploaded.</b>
						</div>';
				}
			}
			$_SESSION["msg"] = $msg;
			redirect("viewadmin.php?ID=".$ID);
		}
}
else
{
	if(isset($_REQUEST['ID'])) $ID=$_REQUEST['ID'];
	else
	{
		$_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<b>Invalide user ID</b>
				</div>';
		redirect("admins.php");
	}
	$sql="SELECT *, Date_FORMAT(DOB, '%Y-%m-%d') AS DOB FROM admins where ID=".$ID;
	$resource=mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($resource) > 0)
	{
		$row=mysql_fetch_array($resource);
		$Username = $row["Username"];			$Password = $row["Password"];				$Email = $row["Email"];
		$Image=$row["Image"];					$Name = $row["Name"];						$FatherName = $row["FatherName"];
		$NIC = $row["NIC"];						$Number = $row["Number"];					$Address = $row["Address"];			
		$RoleID = $row["ID"];							$City = $row["City"];						$Country = $row["Country"];
		$DOB = $row["DOB"];						$BirthPlace = $row["BirthPlace"];			$Gender = $row["Gender"];
		$Religion = $row["Religion"];			$Remarks = $row["Remarks"];					$RepeatPassword = $row["Password"];
		$DateAdded = $row["DateAdded"];			$DateModified = $row["DateModified"];
	}
	else
	{
		$_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<b>Invalide user ID</b>
				</div>';
		redirect("admins.php");
	}
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
    <title><?php echo SITE_TITLE; ?>- Edit Admin</title>
    <link rel="icon" href="<?php echo DIR_LOGO_IMAGE.SITE_LOGO; ?>" type="image/x-icon">
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
            Edit Admin
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="admins.php"><i class="fa fa-user"></i> Admins</a></li>
            <li class="active">Edit Admin</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <!-- /.box -->
				<form id="frmPages" action="<?php echo $self.'?ID='.$_REQUEST["ID"]; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
              <div class="box ">
                <div class="box-header">
                      <div class="btn-group-right">
                       <button style="float:right;" type="button" class="btn btn-group-vertical btn-danger" onClick="location.href='admins.php'" >Back</button>
                       <input style="float:right;margin-right:15px;" type="submit" name="editstd" class="btn btn-group-vertical btn-success" value="Update"></button>
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
							<input type="file" name="File" />
					  <?php if(isset($Image) && $Image!="") echo '<img style="max-width:100px;max-height:150px;" src="'.DIR_USER_IMAGES.$Image.'" />'; ?>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Username</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" readonly="" value="<?php echo $Username ;?>" placeholder="Enter Username" name="Username">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Role</label>
						<div class="col-md-6">
							<select class="form-control" name="Gender">
								<option value="1" <?php echo ($RoleID == ROLE_ID_ADMIN ? 'selected=""' : ''); ?> >Admin</option>
								<option value="2" <?php echo ($RoleID == ROLE_ID_DRIVER ? 'selected=""' : ''); ?> >Driver</option>
								<option value="3" <?php echo ($RoleID == ROLE_ID_SHOP ? 'selected=""' : ''); ?> >Shop</option>
							</select>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Name</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $Name ;?>" placeholder="Enter Name" name="Name">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Father Name</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $FatherName ;?>" placeholder="Enter Father Name" name="FatherName">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">NIC</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $NIC ;?>" placeholder="Enter NIC" name="NIC">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Date of Birth</label>
						<div class="col-md-6">
							<input type="date" class="form-control" id="example-text-input" value="<?php echo $DOB ;?>"  placeholder="Enter User Name" name="DOB">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Birth Place</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $BirthPlace ;?>" placeholder="Enter Birth Place" name="BirthPlace">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Gender</label>
						<div class="col-md-6">
							<select class="form-control" name="Gender">
								<option value="Male" <?php echo ($Gender == "Male" ? 'selected=""' : ''); ?> >Male</option>
								<option value="Female" <?php echo ($Gender == "Female" ? 'selected=""' : ''); ?> >Female</option>
							</select>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Religion</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $Religion ;?>" placeholder="Enter Religion" name="Religion">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Password</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $Password ;?>" placeholder="Enter Password" name="Password">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Repeat Password</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $RepeatPassword ;?>" placeholder="Repeat Password" name="RepeatPassword">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Remarks</label>
						<div class="col-md-6">
							<textarea class="form-control" name="Remarks"><?php echo $Remarks ;?></textarea>
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
							<input type="email" class="form-control" id="example-email-input" value="<?php echo $Email ;?>" placeholder="Enter Email" name="Email">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Contact Number</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $Number ;?>" placeholder="Enter Contact Number" name="Number">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Address</label>
						<div class="col-md-6">
							<textarea class="form-control" name="Address"><?php echo $Address ;?></textarea>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">City</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $City ;?>" placeholder="Enter City" name="City">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Country</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $Country ;?>" placeholder="Enter Country" name="Country">
						</div>
					</div>
                  </div><!-- /.box-body -->
                </div><!-- /.box-body -->
			<?php if(CAPTCHA_VERIFICATION == 1) { ?>
			  <div class="box box-default">
				<div class="box-header with-border">
				  <h3 class="box-title">Human Verification</h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div>
                <div class="box-body">
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Captcha</label>
						<div class="col-md-6">
							<img src="captcha.php" />
							<input type="text" class="form-control" id="example-text-input" placeholder="Enter the captcha" name="captcha">
						</div>
					</div>
                  </div><!-- /.box-body -->
                </div><!-- /.box-body -->
			<?php } ?></form>
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->

      <!-- Main Footer -->
      <?php include("footer.php"); ?>
      

      <!-- Control Sidebar -->
      <?php include("rightsidebar.php"); ?>
      <div class="control-sidebar-bg"></div>
      <!-- /.control-sidebar -->
      </div><!-- /.content-wrapper -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
    
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
    </script>
</body>
</html>
