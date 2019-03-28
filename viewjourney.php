<?php include("common.php"); ?>
<?php include("checkadminlogin.php");
get_right(array(ROLE_ID_PLANT, ROLE_ID_ADMIN));

$msg = '';

if (isset($_REQUEST['ID'])) $ID = $_REQUEST['ID'];
else {
    $_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<b>Invalide cylinder ID</b>
				</div>';
    redirect("cylinders.php");
}
$sql = "SELECT * FROM cylinders where ID=" . $ID;
$resource = mysql_query($sql) or die(mysql_error());
if (mysql_num_rows($resource) > 0) {
    $row = mysql_fetch_array($resource);
    $CylinderID = $row["ID"];
    $BarCode = $row["BarCode"];
    $NewBarCode = $row["BarCode"];
    $Description = $row["Description"];
    $ShortDescription = $row["ShortDescription"];
    $TierWeight = $row["TierWeight"];
    $CylinderType = $row["CylinderType"];
    $ManufacturingDate = $row["ManufacturingDate"];
    $ExpiryDate = $row["ExpiryDate"];
} else {
    $_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<b>Invalide cylinder ID</b>
				</div>';
    redirect("cylinders.php");
}

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
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
                Cylinder Journey
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="cylinders.php"><i class="fa fa-cubes"></i> Cylinders</a></li>
                <li class="active">Cylinder Journey</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- /.box -->
                    <div class="box ">
                        <div class="box-header">
                            <div class="btn-group-right">
                                <button style="float:right;" type="button" class="btn btn-group-vertical btn-danger"
                                        onClick="location.href='cylinders.php'">Back
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php if (isset($msg) && $msg != "") {
                        echo $msg;
                        $msg = "";
                    } ?>
                    <?php if (isset($_SESSION["msg"]) && $_SESSION["msg"] != "") {
                        echo $_SESSION["msg"];
                        $_SESSION["msg"] = "";
                    } ?>
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cylinder # <?php echo $BarCode; ?></h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <?php
                                $sql = "SELECT cs.Weight, DATE_FORMAT(cs.DateAdded, '%D %M %Y, %i:%h %p') AS DateAdded, ht.Name AS HandedTo, ht.RoleID AS HandedToRole, htr.Name AS HandedToRoleName, hb.Name AS HandedBy FROM cylinderstatus cs LEFT JOIN users ht ON ht.ID=cs.HandedTo LEFT JOIN users hb ON hb.ID=cs.PerformedBy LEFT JOIN roles htr ON ht.RoleID=htr.ID WHERE cs.CylinderID = " . (int)$ID . " ORDER BY cs.ID DESC";
                                $res = mysql_query($sql) or die(mysql_error());
                                if (mysql_num_rows($res) == 0) {
                                    ?>
                                    <h2>No history found!</h2>
                                    <?php
                                } else { ?>
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Handed By</th>
                                            <th>Handed To</th>
                                            <th>Weight</th>
                                            <th>Time</th>
                                        </tr>
                                        <?php

                                        while ($row = mysql_fetch_array($res)) {
                                            ?>
                                            <tr class="
                                        <?php if ($row["HandedToRole"] == ROLE_ID_PLANT) echo 'bg bg-blue' ?>
                                        <?php if ($row["HandedToRole"] == ROLE_ID_DRIVER) echo 'callout callout-info' ?>
                                        <?php if ($row["HandedToRole"] == ROLE_ID_SALES) echo 'callout callout-warning' ?>
                                        <?php if ($row["HandedToRole"] == ROLE_ID_SHOP) echo 'callout callout-warning' ?>
                                        <?php if ($row["HandedToRole"] == ROLE_ID_CUSTOMER) echo 'callout callout-success' ?>
">
                                                <td><?php echo $row["HandedBy"]; ?></td>
                                                <td><?php echo $row["HandedTo"],' (' . $row["HandedToRoleName"] .')'; ?></td>
                                                <td><?php echo financials($row["Weight"]); ?>KG</td>
                                                <td><?php echo $row["DateAdded"]; ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>
                                    <?php
                                }
                                ?>
                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
    </div><!-- /.row -->
    <!-- Main Footer -->
    <?php include("footer.php"); ?>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->


<!-- Control Sidebar -->
<?php include("rightsidebar.php"); ?>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>

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
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITE_TITLE; ?>- Cylinder Journey</title>
    <link rel='shortcut icon' href='<?php echo DIR_LOGO_IMAGE . SITE_LOGO ?>' type='image/x-icon'>
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
</html>
