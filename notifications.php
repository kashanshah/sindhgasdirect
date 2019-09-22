<?php include("common.php"); ?>
<?php include("checkadminlogin.php");
//get_right(array(ROLE_ID_ADMIN, ROLE_ID_PLANT, ROLE_ID_SHOP));

$msg = '';
$sql = "SELECT ID, Name, Description, Status, UserID, RoleID, Link, DATE_FORMAT(DateAdded, '%D %b, %Y %h:%i:%p ') AS DateAdded, DATE_FORMAT(DateModified, '%D %b, %Y %h:%i:%p ') AS DateModified FROM notifications
WHERE UserID = " . (int)$_SESSION["ID"] . " AND ID<>0 ORDER BY Priority, ID DESC ";
$resource = mysql_query($sql) or die(mysql_error());
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new product from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITE_TITLE; ?>- Notifications</title>
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
    <style>
        .all_notification_wrap .notification-menu {
            margin: auto;
            padding: 0;
            box-shadow: 0 2px 4px 0 rgba(186, 202, 210, .2);
            -webkit-box-shadow: 0 2px 4px 0 rgba(186, 202, 210, .2);
            -moz-box-shadow: 0 2px 4px 0 rgba(186, 202, 210, .2);
            background: #fff;
            border-radius: 3px;
        }

        .notification-menu li {
            list-style: none;
            border-top: 1px solid #dcdcdc;
            position: relative;
            min-height: 57px;
            max-height: 100%;
            padding: 0;
        }

        .all_notification_wrap .notification-menu li:first-child {
            border-top: 0;
        }

        .all_notification_wrap .notification-menu li > a {
            white-space: normal;
            position: relative;
            padding: 12px 15px;
        }

        .all_notification_wrap .notification-menu li a {
            display: block;
        }

        .notification-menu li > a, .notification-menu li > a:hover {
            color: #b8c7ce;
        }

        .notification-menu li .noti-image {
            font-size: 16px;
        }

        .all_notification_wrap .notification-menu li .noti-content {
            position: static;
        }

        .notification-menu li .noti-content > .noti-para {
            font-size: 16px;
            color: #696969;
            line-height: 1;
            display: block;
            padding-right: 30px;
        }

        .notification-menu li .noti-content .noti-time {
            font-size: 11px;
            color: #b8c7ce;
            display: block;
            line-height: 12px;
            margin-top: 5px;
        }
    </style>
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
                Notifications
                <small><?php echo $NotifCount; ?> new notifications</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Cylinders</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- /.box -->
                    <?php if (isset($_SESSION["msg"]) && $_SESSION["msg"] != "") {
                        echo $_SESSION["msg"];
                        $_SESSION["msg"] = "";
                    } ?>
                    <div class="box">
                        <div class="box-body table-responsive">
                            <div class="all_notification_wrap row">
                                <ul class="notification-menu notification-list">
                                    <?php
                                    while ($row = mysql_fetch_array($resource)) {
                                        ?>
                                        <li class="read" <?php echo $row["Status"] == 0 ? 'style="background:#ecf0f2;"' : ''; ?>
                                            onclick='markReadAndAction(<?php echo $row["ID"]; ?>, "<?php echo $row["Link"]; ?>", true)'>
                                            <button class="close-notification hidden"
                                                    data-id="Ym8vZkFscllWR1JyS0JXZDBNWkhnUT09" data-condition="false"><i
                                                        class="fa fa-times-circle" aria-hidden="true"></i></button>
                                            <a class="">
                                                <div class="noti-content">
                                                    <span class="noti-para"><strong><?php echo $row["Name"]; ?></strong><br/><?php echo nl2br(dboutput($row["Description"])); ?></span>
                                                    <span class="noti-time"><?php echo $row["DateAdded"]; ?></span>
                                                </div>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div><!-- /.box-body -->
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
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
<script language="javascript">

    $(document).ready(function () {

        $(".checkUncheckAll").click(function () {

            $(".chkIds").prop("checked", $(this).prop("checked"));

        });

    });

    function doDelete() {
        if ($(".chkIds").is(":checked")) {
            if (confirm("Are you sure you want to delete")) {
                $("#frmPages").attr("action", "<?php echo $self; ?>");
                $("#frmPages").submit();
            }
        } else {
            alert("None of the list is selected");
        }
    }

    function printBarCodes() {
        if ($(".chkIds").is(":checked")) {
            $("#frmPages").attr("action", "printbarcodes.php");
            $("#frmPages").submit();
        } else {
            alert("Please select a cylinder!");
        }
    }

    function doSingleDelete(did) {

        if (confirm("Are you sure you want to delete")) {

            location.href = '<?php echo $self;?>?DID=' + did;
        }

    }
</script>
</body>
</html>
