<?php include("common.php"); ?>
<?php include("checkadminlogin.php");

$emailto = "";
$subject = "";
$message = "";
$msg = "";

$colorName = array("red", "green", "yellow", "aqua", "light-blue", "gray", "navy");
if (isset($_POST["mail"]) && $_POST["mail"] == "quickmail") {
    if (isset($_POST['emailto'])) $emailto = trim($_POST['emailto']);
    if (isset($_POST['subject'])) $subject = trim($_POST['subject']);
    if (isset($_POST['message'])) $message = trim($_POST['message']);

    if (!isset($_POST["captcha"]) || $_POST["captcha"] == "" || $_SESSION["code"] != $_POST["captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Incorrect Captcha Code</div>';
    else if ($emailto == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter Valid Email Address</div>';
    else if ($subject == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter Email Subject</div>';
    else if ($message == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter Email Body</div>';

    else if ($msg == "") {

        $to = $emailto;
        $from = COMPANY_NAME . " <" . EMAIL_ADDRESS . ">";
        $message = $message;
        $headers = "From: " . $from;
        $headers .= "Return-Path: " . COMPANY_NAME . " <" . EMAIL_ADDRESS . ">" . "\r\n";
        $headers .= "X-Mailer: PHP5\n";
        $headers .= 'MIME-Version: 1.0' . "\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $mail = @mail($to, $subject, $message, $headers);
        if ($mail) {
            mysql_query("INSERT INTO mails SET DateAdded='".DATE_TIME_NOW."',
			SentFrom = '" . $from . "',
			SentTo = '" . $to . "',
			Subject = '" . $subject . "',
			Body = '" . $message . "',
			Readed = 1,
			SentBy = " . $_SESSION["ID"]) or die(mysql_error());
            $msg = '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Email sent to ' . $to . '</div>';
            $emailto = "";
            $subject = "";
            $message = "";
        } else if (!$mail) {
            $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Email could not be sent to ' . $to . '</div>';
        }
    }

}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITE_TITLE; ?>- Dashboard</title>
    <link rel='shortcut icon' href='<?php echo DIR_LOGO_IMAGE . SITE_LOGO ?>' type='image/x-icon'>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.print.css" media="print">
    <!-- Morris chart -->
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Daterange picker ->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

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
            <h3>
                <?php echo FULL_NAME; ?>
                <!---      <small><?php echo COMPANY_NAME; ?></small>--->
                <small> WBSA -V1.0</small>
            </h3>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <?php if (isset($_SESSION["msg"]) && $_SESSION["msg"] != "") {
                    echo $_SESSION["msg"];
                    $_SESSION["msg"] = "";
                } ?>
                <section class="connectedSortable">
                    <!-- quick email widget -->
                    <div class="">
                        <section class="content">
                            <div class="row">
                                <?php if($_SESSION["RoleID"] == ROLE_ID_ADMIN){ ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-yellow"><i class="fa  fa-cubes"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Total Gas Dispatched Today</span>
                                                <span class="info-box-number"><?php echo @(int)mysql_result(mysql_query("SELECT SUM(CompanyTotalWeight)-SUM(TierWeight) AS TotalGasDispatched FROM purchase_details WHERE DATE_FORMAT(DateAdded, '%Y-%m-%d') >= '" . date('Y-m-01') . "' "), 0); ?>KGs</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-blue"><i class="fa fa-star"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Total Gas Savings Today</span>
                                                <span class="info-box-number"><?php echo @(int)mysql_result(mysql_query("SELECT SUM(Savings) AS Savings FROM cylinder_savings WHERE DATE_FORMAT(DateAdded, '%Y-%m-%d') >= '" . date('Y-m-01') . "' "), 0); ?>KGs</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                else if($_SESSION["RoleID"] == ROLE_ID_PLANT){ ?>
<!--                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-yellow"><i class="fa  fa-cubes"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Total Gas Dispatched Today</span>
                                                <span class="info-box-number"><?php /*echo @mysql_result(mysql_query("SELECT SUM(CompanyTotalWeight)-SUM(TierWeight) AS TotalGasDispatched FROM purchase_details WHERE DATE_FORMAT(DateAdded, '%Y-%m-%d') >= '" . date('Y-m-01') . "' "), 0); */?>KGs</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-blue"><i class="fa fa-star"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Total Gas Savings Today</span>
                                                <span class="info-box-number"><?php /*echo @mysql_result(mysql_query("SELECT SUM(Savings) AS Savings FROM cylinder_savings WHERE DATE_FORMAT(DateAdded, '%Y-%m-%d') >= '" . date('Y-m-01') . "' "), 0); */?>KGs</span>
                                            </div>
                                        </div>
                                    </div>
-->                                <?php }?>
                            </div>

                            <!-- small box -->
                            <!--    <div class="small-box bg-green">
                                      <div class="inner">
                                        <h3>POINT OF SALES</h3>
                                        <p>&nbsp;</p>
                                      </div>
                                      <div class="icon">
                                        <i class="fa fa-shopping-cart"></i>
                                      </div>
                                      <a href="addsale.php" class="small-box-footer">Continue to Point of Sales <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                  </div>--->

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Monthly Sales Report</h3>

                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                            class="fa fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                            class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p class="text-center">
                                                        <strong>Sales: <?php echo date('M, Y', strtotime("-11 months")); ?>
                                                            - <?php echo date("M, Y"); ?></strong>
                                                    </p>

                                                    <div class="chart">
                                                        <!-- Sales Chart Canvas -->
                                                        <canvas id="salesChart1" style="height: 180px;"></canvas>
                                                    </div>
                                                    <!-- /.chart-responsive -->
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->
                                        </div>
                                        <!-- ./box-body -->
                                        <div class="box-footer">
                                            <div class="row">
                                                <div class="col-md-6 text-center">
                                                    <div class="description-block border-right">
                                                        <!--                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>-->
                                                        <h5 class="description-header">Rs. <span id="Revenue">0</span>
                                                        </h5>
                                                        <span class="description-text">TOTAL REVENUE</span>
                                                    </div>
                                                    <!-- /.description-block -->
                                                </div>
                                                <div class="col-md-6 text-center">
                                                    <div class="description-block border-right">
                                                        <!--                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>-->
                                                        <h5 class="description-header">Rs. <span
                                                                    id="MonthRevenue">0</span></h5>
                                                        <span class="description-text">THIS MONTH REVENUE</span>
                                                    </div>
                                                    <!-- /.description-block -->
                                                </div>
                                            </div>
                                            <!-- /.row -->
                                        </div>
                                        <!-- /.box-footer -->
                                    </div>
                                    <!-- /.box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Orders: <?php echo date('M Y'); ?></h3>

                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                            class="fa fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                            class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="chart-responsive">
                                                        <canvas id="pieChart" height="150"></canvas>
                                                    </div>
                                                    <!-- ./chart-responsive -->
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-md-12">
                                                    <ul class="chart-legend clearfix">
                                                        <li><i class="fa fa-circle-o text-red"></i>&nbsp;&nbsp;&nbsp;
                                                            <strong class="pull-right">sa</strong></li>
                                                    </ul>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                </div>
                            </div>


                        </section><!-- /.Left col -->

                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
    </div>
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
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);

    $(function () {

    });
</script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker ->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="plugins/chartjs/Chart.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<!-- Calendar -->
<script src="plugins/fullcalendar/fullcalendar.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<script>
    $(window).load(function () {
        $(".afterloadreemoveActive").removeClass("active");
    });
</script>
</body>
</html>

