<?php include("common.php"); ?>
<?php include("checkadminlogin.php");
get_right(array(ROLE_ID_PLANT));

$msg='';
$ID = "";
$Name = "";
$Details = "";
$RegistrationNo = "";
$DateAdded = "";
$DateModified = "";


if(isset($_POST['addstd']) && $_POST['addstd']=='Save')
{
    if(isset($_POST['Name'])) 					$Name = trim($_POST['Name']);

    if(isset($_POST['Details']))				$Details = trim($_POST['Details']);
    if(isset($_POST['RegistrationNo']))				$RegistrationNo = trim($_POST['RegistrationNo']);

    if(CAPTCHA_VERIFICATION == 1) { if(!isset($_POST["captcha"]) || $_POST["captcha"]=="" || $_SESSION["code"]!=$_POST["captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Incorrect Captcha Code</div>'; }
    else if(trim($Name) == "") $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-ban"></i> Please enter name</div>';
    else if(trim($RegistrationNo) == "") $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-ban"></i> Please enter weight</div>';

    if($msg=="")
    {
        mysql_query("INSERT into vehicles SET
						DateAdded='".DATE_TIME_NOW."',
						DateModified='".DATE_TIME_NOW."',
						Name='".dbinput($Name)."',
						Details='".dbinput($Details)."',
						RegistrationNo='".dbinput($RegistrationNo)."',
						PlantID='".(int)$_SESSION["ID"]."',
						PerformedBy = '".(int)$_SESSION["ID"]."'") or die(mysql_error());

        $VehicleID = mysql_insert_id();
        $msg='<div class="alert alert-success alert-dismissable">
					<i class="fa fa-check"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					Vehicle has been added.
				</div>';
        $_SESSION["msg"] = $msg;
        redirect("addvehicle.php");
    }
}

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new vehicle from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITE_TITLE; ?>- Add Vehicle</title>
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
                Add Vehicle
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="vehicles.php"><i class="fa fa-truck"></i> Vehicles</a></li>
                <li class="active">Add Vehicle</li>
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
                                    <button style="float:right;" type="button" class="btn btn-group-vertical btn-danger" onClick="location.href='vehicles.php'" >Back</button>
                                    <input style="float:right;margin-right:15px;" type="submit" name="addstd" class="btn btn-group-vertical btn-success" value="Save"></button>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($msg) && $msg != "")  { echo $msg; $msg=""; } ?>
                        <?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Add Vehicle</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="example-text-input">Name *</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="Name" value="<?php echo $Name;?>" placeholder="" name="Name" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="RegistrationNo">Registration No*</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="RegistrationNo" value="<?php echo $RegistrationNo;?>" placeholder="Enter Registration No" name="RegistrationNo" required>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="Details">Details</label>
                                    <div class="col-md-6">
                                        <textarea class="form-control" id="Details" placeholder="Enter Details" name="Details"><?php echo $Details;?></textarea>
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

        CKEDITOR.replace('Details');
        //bootstrap WYSIHTML5 - text editor
        $(".Details").wysihtml5();

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    });
</script>
</body>
</html>
