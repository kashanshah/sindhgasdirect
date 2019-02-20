<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
get_right(array(1, 2));

	$msg='';
	$Title = "";
	$StartDate = "";
	$EndDate = "";
	$Details = "";
	$DateAdded = "";
	$DateModified = "";
if(isset($_POST['editstd']) && $_POST['editstd']=='Update')
{
	$ID = $_REQUEST["ID"];
	$Title = $_REQUEST["Title"];
	$StartDate = $_REQUEST["StartDate"];
	$EndDate = $_REQUEST["EndDate"];
	$Details = $_REQUEST["Details"];
	if(!isset($_POST["captcha"]) || $_POST["captcha"]=="" || $_SESSION["code"]!=$_POST["captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Incorrect Captcha Code</div>';
	else if($Title == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter The Event Title</div>';
	else if($StartDate == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter The Start Date</div>';
	else if($EndDate == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter The End Date</div>';
	if($msg=="")
	{
		mysql_query("UPDATE events SET
					Title='".$Title."',
					StartDate='".$StartDate."',
					EndDate='".$EndDate."',
					Details='".$Details."'
					WHERE ID=".$ID."
					") or die(mysql_error());

		$txt = "\n".date('r').": \nEVENT EDITED by ".$_SESSION["Username"].": \nEvent ID='".$ID."', Title='".$Title."', StartDate='".$StartDate."', EndDate='".$EndDate."', Details='".$Details."'\n";
		$txt .= file_get_contents(WEB_LOG_FILE);
		file_put_contents(WEB_LOG_FILE, $txt);
				
		$_SESSION["msg"]='<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					Event details has been updated.
				</div>';
		redirect("events.php");
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
				<b>Invalide event ID</b>
				</div>';
		redirect("classes.php");
	}
	$sql="SELECT Title, DATE_FORMAT(StartDate, '%Y-%m-%d') AS StartDate, DATE_FORMAT(EndDate, '%Y-%m-%d') AS EndDate, Details FROM events where ID=".$ID;
	$resource=mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($resource) > 0)
	{
		$row=mysql_fetch_array($resource);
		$Title = $row["Title"];
		$StartDate = $row["StartDate"];
		$EndDate = $row["EndDate"];
		$Details = $row["Details"];
	}
	else
	{
		$_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<b>Invalide event ID</b>
				</div>';
		redirect("events.php");
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
    <title><?php echo SITE_TITLE; ?>- Edit Event</title>
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
            Edit Event
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="events.php"><i class="fa fa-folder-open"></i> Events</a></li>
            <li class="active">Edit Event</li>
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
                       <button style="float:right;" type="button" class="btn btn-group-vertical btn-danger" onClick="location.href='events.php'" >Back</button>
                       <input style="float:right;;margin-right:15px;" type="submit" name="editstd" class="btn btn-group-vertical btn-success" value="Update"></button>
                      </div>
				</div>
			  </div>
<?php if(isset($msg) && $msg != "")  { echo $msg; $msg=""; } ?>
<?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
              <div class="box box-default">
				<div class="box-header with-border">
				  <h3 class="box-title">Class Information</h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div>
                <div class="box-body">
                    <div class="form-group">
						<label class="col-md-3 control-label" for="eventple-text-input">Event Title</label>
						<div class="col-md-6"> 
							<input type="text" class="form-control" id="eventple-text-input" value="<?php echo $Title ;?>" placeholder="Enter Title" name="Title">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="eventple-text-input">Start Date</label>
						<div class="col-md-6"> 
							<input type="date" class="form-control" id="eventple-text-input" value="<?php echo $StartDate ;?>" placeholder="Enter Title" name="StartDate">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="eventple-text-input">End Date</label>
						<div class="col-md-6"> 
							<input type="date" class="form-control" id="eventple-text-input" value="<?php echo $EndDate ;?>" placeholder="Enter Title" name="EndDate">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="eventple-text-input">Details</label>
						<div class="col-md-6">
							<textarea class="form-control" name="Details"><?php echo $Details ;?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="eventple-text-input">Captcha</label>
						<div class="col-md-6">
							<img src="captcha.php" />
							<input type="text" class="form-control" id="eventple-text-input" placeholder="Enter the captcha" name="captcha">
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
    </script>
</body>
</html>
