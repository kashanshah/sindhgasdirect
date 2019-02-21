<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
get_right(array(1, 2));

	$msg='';				$RepeatPassword = "";
	$UserName = "";			$Password = "";			$Email = "";			$Image="";
	$Name = "";				$FatherName = "";		$NIC = "";				$Number = "";
	$Address = "";			$RoleID = 1;			$City = "";				$Country = "";
	$DOB = "";				$BirthPlace = "";		$Gender = "";			$Religion = "";
	$AdmissionDate = "";	$Status = "";			$Remarks = "";			$AdmissionFee = "";
	$ClassID = "";			$FathersJob = "";		$Designation = "";		$OfficeAddress = "";
	$FatherSalary = "";		$FeeDiscount = "";		$DateAdded = ""; 		$DateModified = "";
	$SecurityDeposit = "";

	if(isset($_POST['addstd']) && $_POST['addstd']=='Save')
	{
		if(isset($_POST['RoleID']))						$RoleID = trim($_POST['RoleID']);
		if(isset($_POST['UserName']))					$UserName = trim($_POST['UserName']);
		if(isset($_POST['Password']))					$Password = trim($_POST['Password']);
		if(isset($_POST['RepeatPassword']))				$RepeatPassword = trim($_POST['RepeatPassword']);
		if(isset($_POST['Email']))						$Email = trim($_POST['Email']);
		if(isset($_POST['Name'])) 						$Name = trim($_POST['Name']);
		if(isset($_POST['FatherName']))					$FatherName = trim($_POST['FatherName']);
		if(isset($_POST['NIC']))						$NIC = trim($_POST['NIC']);
		if(isset($_POST['Number']))						$Number = trim($_POST['Number']);
		if(isset($_POST['Address']))					$Address = trim($_POST['Address']);
		if(isset($_POST['City']))						$City = trim($_POST['City']);
		if(isset($_POST['Country']))					$Country = trim($_POST['Country']);
		if(isset($_POST['DOB']))						$DOB = trim($_POST['DOB']);
		if(isset($_POST['BirthPlace']))					$BirthPlace = trim($_POST['BirthPlace']);
		if(isset($_POST['Gender']))						$Gender = trim($_POST['Gender']);
		if(isset($_POST['Religion']))					$Religion = trim($_POST['Religion']);
		if(isset($_POST['Status']))						$Status = trim($_POST['Status']);
		if(isset($_POST['Remarks']))					$Remarks = trim($_POST['Remarks']);
		
		if(CAPTCHA_VERIFICATION == 1) { if(!isset($_POST["captcha"]) || $_POST["captcha"]=="" || $_SESSION["code"]!=$_POST["captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Incorrect Captcha Code</div>'; }
		else if($Name == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter Name</div>';
		else if($Password == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter A Password</div>';
		else if($RepeatPassword != $Password) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Password doesnot match.</div>';
		else if(checkavailability('admins', 'UserName', $UserName) > 0) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>UserName not available choose another!</div>';
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
				<b>Image size must be ' . MAX_IMAGE_SIZE . ' KB or less.
				</div>';
			}
		}
		if($msg=="")
		{
			
			mysql_query("INSERT into admins SET
						Status=1, DateAdded=NOW(),
						RoleID='".(int)$RoleID."',
						UserName='".dbinput($UserName)."',
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
						PerformedBy = '".(int)$_SESSION["ID"]."',
						AdmissionDate=NOW(),
						Remarks='".dbinput($Remarks)."'
						") or die(mysql_error());
			$UserID = mysql_insert_id();
			$msg='<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Admin has been added.
					</div>';
			if(isset($_FILES["File"]) && $_FILES["File"]['name'] != "")
			{
				if(is_file(DIR_USER_IMAGES . $StoreImage))
					unlink(DIR_USER_IMAGES . $StoreImage);
			
				ini_set('memory_limit', '-1');
				
				$tempName2 = $_FILES["File"]['tmp_name'];
				$realName2 = "S".$UserID.".".$ext2;
				$StoreImage = $realName2; 
				$target2 = DIR_USER_IMAGES . $realName2;

				$moved2=move_uploaded_file($tempName2, $target2);
			
				if($moved2)
				{			
				
					$query2="UPDATE admins SET Image='" . dbinput($realName2) . "' WHERE  ID=" . (int)$UserID;
					mysql_query($query2) or die(mysql_error());
					$_SESSION["msg"] = $msg;
					redirect("viewadmin.php?ID=".$UserID);
				}
				else
				{
					$msg='<div class="alert alert-warning alert-dismissable">
						<i class="fa fa-ban"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<b>Admin has been added but Image can not be uploaded.</b>
						</div>';
				}
			}
			else
			{
				redirect("viewadmin.php?ID=".$UserID);
			}
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
    <title><?php echo SITE_TITLE; ?>- Add Admin</title>
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
            Add Admin
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="admins.php"><i class="fa fa-dashboard"></i> Admins</a></li>
            <li class="active">Add Admin</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <!-- /.box -->
				<form id="frmPages" action="<?php echo $self; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
              <div class="box ">
                <div class="box-header">
                      <div class="btn-group-right">
                       <button style="float:right;" type="button" class="btn btn-group-vertical btn-danger" onClick="location.href='admins.php'" >Back</button>
                       <input style="float:right;;margin-right:15px;" type="submit" name="addstd" class="btn btn-group-vertical btn-success" value="Save"></button>
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
							<input type="file" name="File">
					  <?php if(isset($Image) && $Image!="") echo '<img style="width:100px;height:150px;" src="'.DIR_USER_IMAGES.$Image.'" />'; ?>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">UserName</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $UserName;?>" name="UserName">
							<p class="help-block">Choose A Unique Username</p>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Role</label>
						<div class="col-md-6">
							<select class="form-control" name="RoleID">
								<option value="1" <?php echo ($RoleID == ROLE_ID_ADMIN ? 'selected=""' : ''); ?> >Admin</option>
								<option value="2" <?php echo ($RoleID == ROLE_ID_DRIVER ? 'selected=""' : ''); ?> >Driver</option>
								<option value="3" <?php echo ($RoleID == ROLE_ID_SHOP ? 'selected=""' : ''); ?> >Shop</option>
							</select>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Password</label>
						<div class="col-md-6">
							<input type="password" class="form-control" id="example-text-input" value="<?php echo $Password;?>" name="Password">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Repeat Password</label>
						<div class="col-md-6">
							<input type="password" class="form-control" id="example-text-input" value="<?php echo $RepeatPassword;?>" name="RepeatPassword">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Name</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $Name;?>" placeholder="Enter Name" name="Name">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Father Name</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $FatherName;?>" placeholder="Enter Father Name" name="FatherName">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">NIC</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $NIC;?>" placeholder="Enter Father's NIC" name="NIC">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Date of Birth</label>
						<div class="col-md-6">
							<input type="date" class="form-control" id="example-text-input" value="<?php echo $BirthPlace;?>" name="DOB">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Birth Place</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $BirthPlace;?>" placeholder="Enter Birth Place" name="BirthPlace">
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
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $Religion;?>" placeholder="Enter Religion" name="Religion">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Remarks</label>
						<div class="col-md-6">
							<textarea class="form-control" name="Remarks"><?php echo $Remarks;?></textarea>
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
							<input type="email" class="form-control" id="example-email-input" value="<?php echo $Email;?>" placeholder="Enter Email" name="Email">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Contact Number</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $Number;?>" placeholder="Enter Contact Number" name="Number">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Address</label>
						<div class="col-md-6">
							<textarea class="form-control" name="Address"><?php echo $Address;?></textarea>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">City</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $City;?>" placeholder="Enter City" name="City">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Country</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $Country;?>" placeholder="Enter Country" name="Country">
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
			<?php } ?>
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
    </script>
</body>
</html>
