<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
get_right(array(1));

	$msg='';
if(isset($_POST['dbimport']) && $_POST['dbimport']=='dbimport')
{
	if(!isset($_FILES["Import"]) || $_FILES["Import"]['name'] == "")
	{
		$msg='<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				Please choose a file to import.
			</div>';
	}
	else if($msg=="")
	{
		$filenamearray2=explode(".", $_FILES["Import"]['name']);
		$ext2=End($filenamearray2);

		if($ext2 != "sql" && $ext2 != "txt")
		{
			$msg='<div class="alert alert-danger alert-dismissable">
			<i class="fa fa-ban"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<b>Only sql file can be uploaded.</b>
			</div>';
		}
		else if($_FILES["Import"]['size'] > (MAX_IMAGE_SIZE*1024))
		{
			$msg='<div class="alert alert-danger alert-dismissable">
			<i class="fa fa-ban"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<b>File size must be ' . MAX_IMAGE_SIZE . ' KB or less.</b>
			</div>';
		}
	}
	if($msg=="")
	{
		if(isset($_FILES["Import"]) && $_FILES["Import"]['name'] != "")
		{
			$templine = "";
			$lines = file($_FILES["Import"]['tmp_name']);
			// Loop through each line
			foreach ($lines as $line)
			{
			// Skip it if it's a comment
			if (substr($line, 0, 2) == '--' || $line == '')
				continue;

			// Add this line to the current segment
			$templine .= $line;
			// If it has a semicolon at the end, it's the end of the query
			if (substr(trim($line), -1, 1) == ';')
			{
				// Perform the query
				mysql_query($templine) or ($msg='<div class="alert alert-danger alert-dismissable">
			<i class="fa fa-ban"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			' . $templine . '\': ' . mysql_error() . '</div>');
				// Reset temp variable to empty
				$templine = '';
			}
			}
					$msg='<div class="alert alert-success alert-dismissable">
		<i class="fa fa-check"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<b>Database has been uploaded.</b>
		</div>';

		}
	}	
}	

if(isset($_POST['backup']) && $_POST['backup']=='Back Up')
{
	backup_tables(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME,'*');
}

if(isset($_POST['editstd']) && $_POST['editstd']=='Update')
{
	$Email = $_REQUEST["Email"];		$GasRate = $_REQUEST["GasRate"];		$RetailGasRate = $_REQUEST["RetailGasRate"];
	$FullName = $_REQUEST["FullName"];						$CompanyName = $_REQUEST["CompanyName"];
	$SMTPUser = $_REQUEST["SMTPUser"];						$Number = $_REQUEST["Number"];						$Address = $_REQUEST["Address"];			
	$AlertReceiver = $_REQUEST["AlertReceiver"];							$SMTPHost = $_REQUEST["SMTPHost"];
	$SiteTitle = $_REQUEST["SiteTitle"];			$SMSUsername = $_REQUEST["SMSUsername"];
	$Domain = $_REQUEST["Domain"];			$SMSPassword = $_REQUEST["SMSPassword"];
	$DropboxEmail = $_REQUEST["DropboxEmail"];					$SMTPPassword = $_REQUEST["SMTPPassword"];
	$FaxNumber = $_REQUEST["FaxNumber"];		$Password = $_REQUEST["Password"];		$CaptchaVerification = $_REQUEST["CaptchaVerification"];
	$BarCodeLength = $_REQUEST["BarCodeLength"];
	
	if($FullName == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter FullName</div>';
		else if($CompanyName == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter Company Full Name</div>';
		else if($SiteTitle == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter Site Title</div>';
		else if($Email == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter an Email Address</div>';
		else if($GasRate == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please enter gas rate</div>';
		else if($RetailGasRate == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please enter retail gas rate</div>';
		else if($Address == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter Address</div>';
		else if(isset($_FILES["File"]) && $_FILES["File"]['name'] != "")
		{
			$filenamearray2=explode(".", $_FILES["File"]['name']);
			$ext2=End($filenamearray2);
		
			if(!in_array($ext2, $_IMAGE_ALLOWED_TYPES))
			{
				$msg='<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<b>Only '.implode(", ", $_IMAGE_ALLOWED_TYPES) . ' Images can be uploaded. </b>
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
			mysql_query("UPDATE configurations SET
						DateModified=NOW(),
						Email='".dbinput($Email)."',
						GasRate='".(float)$GasRate."',
						RetailGasRate='".(float)$RetailGasRate."',
						FullName='".dbinput($FullName)."',
						CompanyName='".dbinput($CompanyName)."',
						SMTPUser='".dbinput($SMTPUser)."',
						Number='".dbinput($Number)."',
						FaxNumber='".dbinput($FaxNumber)."',
						Address='".dbinput($Address)."',
						AlertReceiver='".dbinput($AlertReceiver)."',
						SMTPHost='".dbinput($SMTPHost)."',
						SiteTitle='".dbinput($SiteTitle)."',
						Domain='".dbinput($Domain)."',
						SMTPPassword='".dbinput($SMTPPassword)."',
						Password='".dbinput($Password)."',
						SMSUsername='".dbinput($SMSUsername)."',
						SMSPassword='".dbinput($SMSPassword)."',
						CaptchaVerification='".dbinput($CaptchaVerification)."',
						BarCodeLength='".(int)$BarCodeLength."',
						DropboxEmail='".dbinput($DropboxEmail)."'
						") or die(mysql_error());
			$msg='<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Software configurations updated.
					</div>';
			if(isset($_FILES["File"]) && $_FILES["File"]['name'] != "")
			{
				if(is_file(DIR_LOGO_IMAGE . $Logo))
					unlink(DIR_LOGO_IMAGE . $Logo);
			
				ini_set('memory_limit', '-1');
				
				$tempName2 = $_FILES["File"]['tmp_name'];
				$realName2 = "logo.".$ext2;
				$StoreImage = $realName2; 
				$target2 = DIR_LOGO_IMAGE . $realName2;

				$moved2=move_uploaded_file($tempName2, $target2);
			
				if($moved2)
				{			
				
					$query2="UPDATE configurations SET Logo='" . dbinput($realName2) . "'";
					mysql_query($query2) or die(mysql_error());
				}
				else
				{
					$msg='<div class="alert alert-warning alert-dismissable">
						<i class="fa fa-ban"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<b>Software configurations updated but Logo can not be uploaded.</b>
						</div>';
				}
			}
			$_SESSION["msg"] = $msg;
			redirect("config.php");
		}
}
else
{
	$sql="SELECT * FROM configurations";
	$resource=mysql_query($sql) or die(mysql_error());
		$row=mysql_fetch_array($resource);
		$Password = $row["Password"];				$Email = $row["Email"];				$RetailGasRate = $row["RetailGasRate"];	$GasRate = $row["GasRate"];
		$Logo=$row["Logo"];					$FullName = $row["FullName"];						$CompanyName = $row["CompanyName"];
		$SMTPUser = $row["SMTPUser"];						$Number = $row["Number"];					$Address = $row["Address"];			
		$RoleID = 2;							$AlertReceiver = $row["AlertReceiver"];						$SMTPHost = $row["SMTPHost"];
		$SiteTitle = $row["SiteTitle"];			$SMSUsername = $row["SMSUsername"];
		$Domain = $row["Domain"];		$SMSPassword = $row["SMSPassword"];
		$DropboxEmail = $row["DropboxEmail"];					$SMTPPassword = $row["SMTPPassword"];
		$FaxNumber = $row["FaxNumber"];		$DateModified = $row["DateModified"];
		$Logo = $row["Logo"];				$CaptchaVerification = $row["CaptchaVerification"];		$BarCodeLength = $row["BarCodeLength"];
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
    <title><?php echo SITE_TITLE; ?>- Edit Configuration</title>
    <link rel="icon" href="<?php echo DIR_LOGO_IMAGE.SITE_LOGO; ?>" type="image/x-icon">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- IoSMTPUserons -->
    <link rel="stylesheet" href="https://code.ioSMTPUserframework.com/ioSMTPUserons/2.0.1/css/ioSMTPUserons.min.css">
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
<script>
function imports()
{
	if(confirm('Uploading a new database will remove all the previous data and willl upload the new data! Are you sure to continue?'))
	{
		$("#importdbb").submit();
	}
}
</script>
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
            Edit Configurations
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Configurations</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <!-- /.box -->
				<form id="frmPages" action="<?php echo $self ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
              <div class="box ">
                <div class="box-header">
                      <div class="btn-group-right">
                       <button style="float:right;" type="button" class="btn btn-group-vertical btn-danger" onClick="location.href='dashboard.php'" >Back</button>
                       <input style="float:right;margin-right:15px;" type="submit" name="editstd" class="btn btn-group-vertical btn-success" value="Update"></button>
                      </div>
				</div>
			  </div>
<?php if(isset($msg) && $msg != "")  { echo $msg; $msg=""; } ?>
<?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
              <div class="box box-default">
				<div class="box-header with-border">
				  <h3 class="box-title">Software Configurations</h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div>
                <div class="box-body">
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Logo</label>
						<div class="col-md-6">
							<input type="file" name="File" />
					  <?php if(isset($Logo) && $Logo!="") echo '<img style="max-width:100px;max-height:150px;" src="'.DIR_LOGO_IMAGE.$Logo.'" />'; ?>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Full Name</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $FullName ;?>" placeholder="Enter FullName" name="FullName">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Company Name</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $CompanyName ;?>" placeholder="Enter Company Name" name="CompanyName">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Site Title</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $SiteTitle ;?>" placeholder="Enter Site Title" name="SiteTitle">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Domain</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $Domain ;?>" placeholder="Enter Domain" name="Domain">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Email</label>
						<div class="col-md-6">
							<input type="email" class="form-control" id="example-email-input" value="<?php echo $Email ;?>" placeholder="Enter Email" name="Email">
						</div>
					</div>
			                <div class="form-group">
						<label class="col-md-3 control-label" for="GasRate">Gas Rate per KG</label>
						<div class="col-md-6">
							<input type="number" step="any" class="form-control" id="GasRate" value="<?php echo $GasRate ;?>" placeholder="Enter Gas Rate per KG" name="GasRate">
						</div>
					</div>
			                <div class="form-group">
						<label class="col-md-3 control-label" for="RetailGasRate">Retail Gas Rate per KG</label>
						<div class="col-md-6">
							<input type="number" step="any" class="form-control" id="RetailGasRate" value="<?php echo $RetailGasRate ;?>" placeholder="Enter Retail Gas Rate per KG" name="RetailGasRate">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">DropBoxEmail</label>
						<div class="col-md-6">
							<textarea class="form-control" name="DropboxEmail"><?php echo $DropboxEmail ;?></textarea>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Number</label>
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
						<label class="col-md-3 control-label" for="example-text-input">AlertReceiver</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $AlertReceiver ;?>" placeholder="Enter Alert Receiver" name="AlertReceiver">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">SMTPHost</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $SMTPHost ;?>" placeholder="Enter SMTP Host" name="SMTPHost">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">SMTP User</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $SMTPUser ;?>" placeholder="Enter SMTP User" name="SMTPUser">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">SMTP Password</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $SMTPPassword ;?>" placeholder="Enter SMTP Password" name="SMTPPassword">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Fax Number</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $FaxNumber ;?>" placeholder="Enter FaxNumber" name="FaxNumber">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Password</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $Password ;?>" placeholder="Enter Password" name="Password">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">SMS Username</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $SMSUsername ;?>" placeholder="Enter Username for SMS API" name="SMSUsername">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">SMS Password</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $SMSPassword ;?>" placeholder="Enter Password for SMS API" name="SMSPassword">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">BarCode Length</label>
						<div class="col-md-6">
							<input type="number" class="form-control" id="example-text-input" value="<?php echo $BarCodeLength ;?>" placeholder="Enter BarCodeLength" name="BarCodeLength">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Captcha Verification</label>
						<div class="col-md-6">
							<input type="radio" value="1" name="CaptchaVerification" <?php echo ($CaptchaVerification == "1" ? 'checked=""' : '') ?>> Yes
							<input type="radio" value="0" name="CaptchaVerification" <?php echo ($CaptchaVerification == "0" ? 'checked=""' : '') ?>> No
						</div>
					</div>
				  </form>
					<div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Backup Your Database</label>
						<div class="col-md-6">
							<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
								<input type="hidden" value="dbbackup" name="dbbackup">
								<input type="submit" class="form-control btn btn-primary"  value="Back Up" name="backup">
							</form>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Upload Database From Your PC</label>
						<div class="col-md-6">
							<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" name="importdbb" id="importdbb" enctype="multipart/form-data">
								<input type="hidden" value="dbimport" name="dbimport">
								<input type="file" name="Import" id="import" accept=".txt, .sql">
								<button type="button" class="form-control btn btn-info" onclick="javascript:imports()" >Import</button>
							</form>
						</div>
					</div>
                  </div><!-- /.box-body -->
                </div><!-- /.box-body -->

              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->

      <!-- Main Footer -->
      <?php include("footer.php"); ?>
      
      </div><!-- /.content-wrapper -->

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
		});
    </script>
</body>
</html>
