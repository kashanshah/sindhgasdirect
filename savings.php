<?php include("common.php"); ?>
<?php include("checkadminlogin.php");
get_right(array(ROLE_ID_ADMIN, ROLE_ID_PLANT));

$msg='';
$DateAddedFrom = date('Y-m-d', ( time() - (60 * 60 * 1 * 24)));
$DateAddedTo = date('Y-m-d', ( time() - (60 * 60 * 0 * 24)));

foreach($_REQUEST as $key => $val)
    $$key = $val;

$sql="SELECT cs.ID, cs.DateAdded, cs.SaleID, cs.PurchaseID, cs.UserID, cs.Wastage, c.PlantID AS Plant, c.BarCode, cs.Savings, r.Name AS UserRole, p.Name AS User FROM 
cylinder_savings cs LEFT JOIN 
users p ON p.ID=cs.UserID LEFT JOIN 
cylinders c ON c.ID=cs.CylinderID LEFT JOIN 
roles r ON r.ID=p.RoleID 
WHERE cs.ID<>0 
AND cs.DateAdded >= '".$DateAddedFrom." 00:00:00'
AND cs.DateAdded < '".$DateAddedTo." 23:23:59'
".(($_SESSION["RoleID"] == ROLE_ID_ADMIN) ? ' AND cs.PurchaseID = 0' :
        ($_SESSION["RoleID"] == ROLE_ID_PLANT ? " AND cs.PurchaseID = 0 AND p.PlantID='".$_SESSION["ID"]."'" :
            ($_SESSION["RoleID"] == ROLE_ID_SHOP ? " AND cs.PurchaseID = 0 AND p.ShopID='".$_SESSION["ID"]."'" :
                ' AND cs.UserID="'.(int)$_SESSION["ID"].'" '
            )
        )
    )
    ." order by ID DESC";
$resource=mysql_query($sql) or die(mysql_error());
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
    <title><?php echo SITE_TITLE; ?>- Cylinders</title>
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
                Cylinders
                <small>Manage Cylinders</small>
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
                    <?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
                    <div class="box">
                        <div class="box-body table-responsive">
                            <form id="frmPages" action="<?php echo $self; ?>" class="form-horizontal no-margin" method="get">

                                <div class="form-group">
                                    <label class="control-label col-md-1 col-sm-1 col-xs-6">From Date</label>
                                    <div class="col-md-3">
                                        <input name="DateAddedFrom" value="<?php echo $DateAddedFrom; ?>" id="DateAddedFrom" class="form-control col-md-7 col-xs-12" type="date">
                                    </div>
                                    <label class="control-label col-md-1 col-sm-1 col-xs-6">Till Date</label>
                                    <div class="col-md-3 col-sm-5 col-xs-6">
                                        <input name="DateAddedTo" value="<?php echo $DateAddedTo; ?>" id="DateAddedTo" class="form-control col-md-7 col-xs-12" type="date">
                                    </div>
                                    <div class="col-md-3 col-sm-5 col-xs-6">
                                        <input name="FilterResults" value="FILTER RESULT" id="FilterResults" class="form-control col-md-7 col-xs-12 btn btn-success" type="submit" />
                                    </div>
                                </div>

                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" class="no-margin checkUncheckAll"></th>
                                        <th>Cylinder ID</th>
                                        <?php if($_SESSION["RoleID"] == ROLE_ID_ADMIN){ ?>
                                            <th>Plant</th>
                                        <?php } ?>
                                        <th>Saved By</th>
                                        <th>Gas Returned</th>
                                        <th>Wastage</th>
                                        <th>Net Saving</th>
<!--                                        <th>Invoice #</th>-->
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $TotalGasSaved = 0;
                                    $TotalGas = 0;
                                    $TotalAdjusted = 0;
                                    $TotalWastage = 0;
                                    while($row=mysql_fetch_array($resource))
                                    {
                                        $CurSav = (float)$row["Savings"] + (float)$row["Wastage"];
                                        $TotalGas += ((float)$row["Savings"] + (float)$row["Wastage"]);
                                        $TotalAdjusted += isCommercialUser($row["UserID"]) ? $row["Savings"] : 0;
                                        $TotalWastage += (float)$row["Wastage"];
                                        $TotalGasSaved = $TotalGasSaved + $CurSav;
                                        ?>
                                        <tr>
                                            <td style="width:5%"><input type="checkbox" value="<?php echo $row["ID"]; ?>" name="ids[]" class="no-margin chkIds"></td>

                                            <td><?php echo $row["BarCode"]; ?></td>
                                            <?php if($_SESSION["RoleID"] == ROLE_ID_ADMIN){ ?>
                                                <td><?php echo getValue('users', 'Name', 'ID', $row["Plant"]); ?></td>
                                            <?php } ?>
                                            <td><?php echo $row["UserRole"]. ': ' . $row["User"]; ?></td>
                                            <td><?php echo financials($CurSav); ?> KG</td>
                                            <td><?php echo financials($row["Wastage"]); ?> KG</td>
                                            <td><?php echo financials($CurSav - $row["Wastage"]); ?> KG</td>
<!--                                            <td>--><?php //echo $row["PurchaseID"] == 0 ? '<a href="viewsale.php?ID='.$row["SaleID"].'">Sale#'.$row["SaleID"].'</a>' : '<a href="viewpurchase.php?ID='.$row["PurchaseID"].'">Purchase#'.$row["PurchaseID"].'</a>'; ?><!--</td>-->
                                            <td><?php echo $row["DateAdded"]; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <h3>Total Returned: <?php echo financials($TotalGas); ?> KG</h3>
                                <h3>Total Wastage: <?php echo financials($TotalWastage); ?> KG</h3>
                                <h3>Total Adjusted: <?php echo financials($TotalAdjusted); ?> KG</h3>
                                <h3>Total Recover: <?php echo financials($TotalGasSaved - $TotalWastage - $TotalAdjusted); ?> KG</h3>
                            </form>
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

    $(document).ready(function(){

        $(".checkUncheckAll").click(function() {

            $(".chkIds").prop("checked", $(this).prop("checked"));

        });

    });

    function doDelete()
    {
        if($(".chkIds").is(":checked"))
        {
            if(confirm("Are you sure you want to delete"))
            {
                $("#frmPages").attr("action", "<?php echo $self; ?>");
                $("#frmPages").submit();
            }
        }
        else{
            alert("None of the list is selected");
        }
    }
    function printBarCodes()
    {
        if($(".chkIds").is(":checked"))
        {
            $("#frmPages").attr("action", "printbarcodes.php");
            $("#frmPages").submit();
        }
        else{
            alert("Please select a cylinder!");
        }
    }
    function doSingleDelete(did)
    {

        if(confirm("Are you sure you want to delete"))
        {

            location.href='<?php echo $self;?>?DID='+did;
        }

    }
</script>
</body>
</html>
