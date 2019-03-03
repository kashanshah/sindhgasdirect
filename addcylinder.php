<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
get_right(array(ROLE_ID_PLANT));

	$msg='';
	$ID = "";
	$BarCode = "";
	$Description = "";
	$ShortDescription = "";
	$TierWeight = "";
	$Image="";
	$ManufacturingDate=date('Y-m-d');
	$ExpiryDate="";
	$DateAdded = "";
	$DateModified = "";
	
	
	if(isset($_POST['addstd']) && $_POST['addstd']=='Save')
	{
		if(isset($_POST['BarCode'])) 					$BarCode = trim($_POST['BarCode']);
		
		if(isset($_POST['Description']))				$Description = trim($_POST['Description']);
		if(isset($_POST['ShortDescription']))			$ShortDescription = trim($_POST['ShortDescription']);
		if(isset($_POST['TierWeight']))				$TierWeight = trim($_POST['TierWeight']);
		if(isset($_POST['Image']))						$Image = trim($_POST['Image']);
		
		if(isset($_POST['ManufacturingDate']))						$ManufacturingDate = trim($_POST['ManufacturingDate']);
		
		if(CAPTCHA_VERIFICATION == 1) { if(!isset($_POST["captcha"]) || $_POST["captcha"]=="" || $_SESSION["code"]!=$_POST["captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Incorrect Captcha Code</div>'; }
		else if(checkavailability('cylinders', 'BarCode', $BarCode) > 0 || $BarCode == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter a Unique Bar Code</div>';
		else if(trim($ManufacturingDate) == "") $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-ban"></i> Please enter Manufacturing Date</div>';
		else if(trim($TierWeight) == "") $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-ban"></i> Please enter weight</div>';
		
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
			$ExpiryDate = date_create($ManufacturingDate);
			$date = date_add($ExpiryDate, date_interval_create_from_date_string('5 years'));
			$ExpiryDate = date_format($date, 'Y-m-d');
			mysql_query("INSERT into cylinders SET
						DateAdded=NOW(),
						DateModified=NOW(),
						Status=0,
						BarCode='".dbinput($BarCode)."',
						ManufacturingDate='".dbinput($ManufacturingDate)."',
						ExpiryDate='".dbinput($ExpiryDate)."',
						Description='".dbinput($Description)."',
						ShortDescription='".dbinput($ShortDescription)."',
						TierWeight='".(float)$TierWeight."',
						PlantID='".(int)$_SESSION["ID"]."',
						PerformedBy = '".(int)$_SESSION["ID"]."'") or die(mysql_error());
						
			$CylinderID = mysql_insert_id();
			$msg='<div class="alert alert-success alert-dismissable">
					<i class="fa fa-check"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					Cylinder has been added.
				</div>';
			$username = SMS_USERNAME;
			$password = SMS_PASSWORD;
			$to = ALERT_RECEIVER;
		$from = 'SindhGasDIR';
			$message = 'Cylinder - New Cylinder with Barcode '.$BarCode.', Manufacturing Date '.$ManufacturingDate.', Expiry Date '.$ExpiryDate.' having T.W '.$TierWeight.'  has been added at '.date('h:i:sA d-m-Y');
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
			redirect("addcylinder.php");
		}
	}
	
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new cylinder from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITE_TITLE; ?>- Add Cylinder</title>
    <link rel="icon" href="<?php echo '../'.DIR_LOGO_IMAGE.SITE_LOGO; ?>" type="image/x-icon">
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
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
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
            Add Cylinder
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="cylinders.php"><i class="fa fa-cubes"></i> Cylinders</a></li>
            <li class="active">Add Cylinder</li>
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
                       <button style="float:right;" type="button" class="btn btn-group-vertical btn-danger" onClick="location.href='cylinders.php'" >Back</button>
                       <input style="float:right;margin-right:15px;" type="submit" name="addstd" class="btn btn-group-vertical btn-success" value="Save"></button>
                      </div>
				</div>
			  </div>
<?php if(isset($msg) && $msg != "")  { echo $msg; $msg=""; } ?>
<?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
              <div class="box box-default">
				<div class="box-header with-border">
				  <h3 class="box-title">Add Cylinder</h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div>
                <div class="box-body">
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Cylinder ID</label>
						<div class="col-md-6">
							<input readonly="" type="text" class="form-control" id="example-text-input" value="<?php $i = mysql_fetch_array(mysql_query("SELECT MAX(ID) AS MA FROM cylinders")); echo $i["MA"]+1;?>" placeholder="" name="CylinderID">
							<p>Auto-generated by the system</p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Manufacturing Date *</label>
						<div class="col-md-6">
							<input type="date" class="form-control" id="example-text-input" value="<?php echo $ManufacturingDate;?>" name="ManufacturingDate" required>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Bar Code</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="example-text-input" value="<?php $i = mysql_fetch_array(mysql_query("SELECT MAX(ID) AS MA FROM cylinders")); echo $i["MA"]+1;?>" placeholder="" name="BarCode">
							<p><span>*</span>Bar Code must be unique</p>
						</div>
					</div>
                
                      <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Tier Weight(KG) *</label>
						<div class="col-md-6">
							<input type="number" class="form-control" id="example-text-input" value="<?php echo $TierWeight;?>" placeholder="Enter Tier Weight in KG's" step="any"  name="TierWeight" required>
						
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="ShortDescription">Short Description</label>
						<div class="col-md-6">
							<textarea class="form-control" id="ShortDescription" placeholder="Enter Short Description" name="ShortDescription"><?php echo $ShortDescription;?></textarea>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="Description">Description</label>
						<div class="col-md-6">
							<textarea class="form-control" id="Description" placeholder="Enter Description" name="Description"><?php echo $Description;?></textarea>
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
		
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
      });
    </script>
</body>
</html>
