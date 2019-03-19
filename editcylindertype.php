<?php include("common.php"); ?>
<?php include("checkadminlogin.php");
get_right(array(ROLE_ID_ADMIN));

$msg='';
$ID = isset($_REQUEST["ID"]) ? $_REQUEST["ID"] : 0;
$Rate = 0;
$Capacity = 0;
$Commercial = 0;
$Name = "";
$MethodID = 0;
$DateAdded = "";
$DateModified = "";

if(isset($_POST['editstd']) && $_POST['editstd']=='Save'){
    foreach ($_REQUEST as $key=>$val)
        $$key = $val;

    if(CAPTCHA_VERIFICATION == 1) { if(!isset($_POST["captcha"]) || $_POST["captcha"]=="" || $_SESSION["code"]!=$_POST["captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Incorrect Captcha Code</div>'; }
    else if($Rate == 0 || $Rate == "") $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please enter correct rates.</div>';
    else if($Capacity == 0 || $Capacity == "") $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please enter correct capacity.</div>';
    if($msg=="")
    {
        mysql_query("UPDATE cylindertypes SET
						DateModified='".DATE_TIME_NOW."',
						Name='".dbinput($Name)."',
						Rate='".(float)($Rate/$Capacity)."',
						Capacity='".(float)$Capacity."',
						Commercial='".(int)$Commercial."',
						PerformedBy='".(int)$_SESSION["ID"]."'
						WHERE ID='".(int)$ID."'
						") or die(mysql_error());

        $_SESSION["msg"]='<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="fa fa-check"></i>Cylinder Type has been edited.
                </div>';
        redirect("cylindertypes.php");
    }
}
else{
    if(isset($_REQUEST['ID'])) $ID=$_REQUEST['ID'];
    else
    {
        $_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				Invalide cylinder type ID
				</div>';
        redirect("cylindertypes.php");
    }
    $sql="SELECT * FROM cylindertypes where ID=".(int)$ID;
    $resource=mysql_query($sql) or die(mysql_error());
    if(mysql_num_rows($resource) > 0)
    {
        $row=mysql_fetch_array($resource);
        foreach ($row as $key=>$val)
            $$key=$val;
    }
    else
    {
        $_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<b>Invalide cylinder type ID</b>
				</div>';
        redirect("cylindertypes.php");
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
    <link rel="icon" href="<?php echo DIR_LOGO_IMAGE.SITE_LOGO; ?>" type="image/x-icon">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITE_TITLE; ?>- Edit Cylinder Type</title>
    <link rel='shortcut icon' href='<?php echo DIR_LOGO_IMAGE.SITE_LOGO ?>' type='image/x-icon' >
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="dist/css/ionicons.min.css">
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
    <link

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
                Edit Cylinder Type
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="cylindertypes.php"><i class="fa fa-cube"></i> Cylinder Types</a></li>
                <li class="active">Edit Cylinder Type</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- /.box -->
                    <form id="frmPages" action="<?php echo $self; ?>?ID=<?php echo $ID; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="box ">
                            <div class="box-header">
                                <div class="btn-group-right">
                                    <a style="float:right;" class="btn btn-group-vertical btn-danger" href="cylindertypes.php" >Back</a>
                                    <input style="float:right;;margin-right:15px;" type="submit" name="editstd" class="btn btn-group-vertical btn-success" value="Save"></button>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($msg) && $msg != "")  { echo $msg; $msg=""; } ?>
                        <?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="Name">Name</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="Name" value="<?php echo $Name;?>" placeholder="Enter Name" name="Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="Rate">Rate (Rs.)</label>
                                    <div class="col-md-6">
                                        <input type="number" step="any" class="form-control" id="Rate" value="<?php echo financials($Rate*$Capacity); ?>" placeholder="Enter Rate" name="Rate">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="Capacity">Capacity (KG)</label>
                                    <div class="col-md-6">
                                        <input type="number" step="any" class="form-control" id="Capacity" value="<?php echo $Capacity;?>" placeholder="Enter Capacity" name="Capacity">
                                    </div>
                                </div>
                                <div class="form-group hidden">
                                    <label class="col-md-3 control-label" for="Commercial">Commercial?</label>
                                    <div class="col-md-6">
                                        <input type="radio" value="1"
                                               name="Commercial" <?php echo($Commercial == "1" ? 'checked=""' : '') ?>>
                                        Yes
                                        <input type="radio" value="0"
                                               name="Commercial" <?php echo($Commercial == "0" ? 'checked=""' : '') ?>>
                                        No
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
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
    });
</script>
</body>
</html>