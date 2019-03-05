<?php include("common.php"); ?>
<?php include("checkadminlogin.php");
get_right(array(ROLE_ID_PLANT));

	$msg='';
if(isset($_POST['editstd']) && $_POST['editstd']=='Update')
{
	$BarCode = $_REQUEST["BarCode"];
	$NewBarCode = $_REQUEST["NewBarCode"];
    $Commercial = $_REQUEST["Commercial"];
	$ManufacturingDate = $_REQUEST["ManufacturingDate"];
	$Description = $_REQUEST["Description"];
	$ShortDescription = $_REQUEST["ShortDescription"];
	$TierWeight = $_REQUEST["TierWeight"];
	$ID = $_REQUEST["ID"];


	if(CAPTCHA_VERIFICATION == 1) { if(!isset($_POST["captcha"]) || $_POST["captcha"]=="" || $_SESSION["code"]!=$_POST["captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Incorrect Captcha Code</div>'; }
	else if($NewBarCode != $BarCode) { if(checkavailability('cylinders', 'BarCode', $NewBarCode) > 0 || $BarCode == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter a Unique Bar Code</div>'; }

	if($msg=="")
	{
		$ExpiryDate = date_create($ManufacturingDate);
		$date = date_add($ExpiryDate, date_interval_create_from_date_string('5 years'));
		$ExpiryDate = date_format($date, 'Y-m-d');
		mysql_query("UPDATE cylinders SET
			DateModified='".DATE_TIME_NOW."',
			BarCode='".dbinput($NewBarCode)."',
			ManufacturingDate='".dbinput($ManufacturingDate)."',
			ExpiryDate='".dbinput($ExpiryDate)."',
			Description='".dbinput($Description)."',
			Commercial='".(int)$Commercial."',
			ShortDescription='".dbinput($ShortDescription)."',
			TierWeight='".(float)$TierWeight."',
			PerformedBy = '".(int)$_SESSION["ID"]."'
			WHERE ID='".(int)$ID."'
		") or die(mysql_error());
		$msg='<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<i class="fa fa-check"></i>Cylinder has been updated.
			</div>';
		$username = SMS_USERNAME;
		$password = SMS_PASSWORD;
		$to = ALERT_RECEIVER;
		$from = COMPANY_NAME;
		$message = 'Cylinder - Cylinder '.$BarCode.' has been edited at '.date('h:iA d-m-Y').'. New '.($BarCode != $NewBarCode ? 'barcode is '. $NewBarCode .','  : '').' Manufacturing Date '.$ManufacturingDate.', Expiry Date '.$ExpiryDate.', T.W '.$TierWeight;
		$url = "http://api.m4sms.com/api/Sendsms?id=".$username."&pass=" .$password.
		"&mobile=" .$to. "&brandname=" .urlencode($from)."&msg=" .urlencode($message)."";
		//Curl Start

		$ch = curl_init();
		$timeout = 30;
		curl_setopt ($ch,CURLOPT_URL, $url) ;
		curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, $timeout) ;
		$response = curl_exec($ch) ;
		curl_close($ch) ; 

		$_SESSION["msg"] = $msg;
		redirect("editcylinder.php?ID=".(int)$ID);
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
				<b>Invalide cylinder ID</b>
				</div>';
		redirect("cylinders.php");
	}
	$sql="SELECT * FROM cylinders where ID=".$ID;
	$resource=mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($resource) > 0)
	{
		$row=mysql_fetch_array($resource);
		$CylinderID = $row["ID"];
		$BarCode = $row["BarCode"];
		$NewBarCode = $row["BarCode"];
		$Description = $row["Description"];
		$ShortDescription = $row["ShortDescription"];
		$TierWeight = $row["TierWeight"];
		$Commercial = $row["Commercial"];
		$ManufacturingDate = $row["ManufacturingDate"];
		$ExpiryDate = $row["ExpiryDate"];
	}
	else
	{
		$_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<b>Invalide cylinder ID</b>
				</div>';
		redirect("cylinders.php");
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
    <title><?php echo SITE_TITLE; ?>- Edit Cylinder</title>
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
            Edit Cylinder
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="cylinders.php"><i class="fa fa-cubes"></i> Cylinders</a></li>
            <li class="active">Edit Cylinder</li>
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
                       <button style="float:right;" type="button" class="btn btn-group-vertical btn-danger" onClick="location.href='cylinders.php'" >Back</button>
                       <input style="float:right;margin-right:15px;" type="submit" name="editstd" class="btn btn-group-vertical btn-success" value="Update"></button>
                      </div>
				</div>
			  </div>
<?php if(isset($msg) && $msg != "")  { echo $msg; $msg=""; } ?>
<?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
              <div class="box box-default">
				<div class="box-header with-border">
				  <h3 class="box-title">Edit Cylinder</h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div>
                <div class="box-body">
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Cylinder ID</label>
						<div class="col-md-6">
							<input readonly="" type="text" class="form-control" id="example-text-input" value="<?php echo $ID;?>" placeholder="" name="ID">
							<p>Auto-generated by the system</p>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Serial Number</label>
						<div class="col-md-3">
							<input type="hidden" value="<?php echo $BarCode;?>" name="BarCode" />
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $NewBarCode;?>" placeholder="Enter A Unique Barcode" name="NewBarCode" />
							<p><span>*</span>Bar Code must be unique</p>
						</div>
						<div class="col-md-3">
							<center><img src="<?php echo 'barcode.php?text='.$BarCode; ?>" height="50" width="150"><br/><?php echo $BarCode; ?></center>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Manufacturing Date *</label>
						<div class="col-md-6">
							<input type="date" class="form-control" id="example-text-input" value="<?php echo $ManufacturingDate;?>" name="ManufacturingDate" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Expiry Date *</label>
						<div class="col-md-6">
							<input type="date" class="form-control" id="example-text-input" value="<?php echo $ExpiryDate;?>" name="ExpiryDate" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Tier Weight *</label>
						<div class="col-md-6">
							<input type="number" step="any" class="form-control" id="example-text-input" value="<?php echo $TierWeight;?>" name="TierWeight">
						</div>
					</div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="Commercial">Commercial?</label>
                        <div class="col-md-6">
                            <input type="radio" value="1" name="Commercial" <?php echo ($Commercial== "1" ? 'checked=""' : '') ?>> Yes
                            <input type="radio" value="0" name="Commercial" <?php echo ($Commercial == "0" ? 'checked=""' : '') ?>> No
                        </div>
                    </div>

                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Short Description</label>
						<div class="col-md-6">
							<textarea class="form-control" name="ShortDescription"><?php echo $ShortDescription ;?></textarea>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Description</label>
						<div class="col-md-6">
							<textarea class="form-control" name="Description"><?php echo $Description ;?></textarea>
						</div>
					</div>
			
					
					<?php if(CAPTCHA_VERIFICATION == 1) { ?>
					<div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Captcha</label>
						<div class="col-md-6">
							<img src="captcha.php" />
							<input type="text" class="form-control" id="example-text-input" placeholder="Enter the captcha" name="captcha">
						</div>
					</div>
					<?php } ?>
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
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
<script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        CKEDITOR.replace('Description');
        //bootstrap WYSIHTML5 - text editor
        $(".Description").wysihtml5();
		
      });
    </script>
</body>
</html>
