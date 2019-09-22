<?php include("common.php"); ?>
<?php include("checkadminlogin.php");
get_right(array(ROLE_ID_ADMIN, ROLE_ID_PLANT, ROLE_ID_SHOP, ROLE_ID_SALES));

$DateAddedFrom = date('Y-m-d', ( time() - (60 * 60 * 1 * 24)));
$DateAddedTo = date('Y-m-d', ( time() - (60 * 60 * 0 * 24)));

foreach($_REQUEST as $key => $val)
    $$key = $val;

$msg='';
$sql="SELECT d.*, u.ID, u.Username, u.Name AS CustomerName, s.Name AS ShopName FROM deposites d LEFT JOIN users u ON u.ID=d.CustomerID LEFT JOIN users s ON s.ID = d.ShopID where 
".(($_SESSION["RoleID"] == ROLE_ID_PLANT || $_SESSION["RoleID"] == ROLE_ID_ADMIN) ? '' : " d.ShopID = ".$_SESSION["ID"]." AND ") ."  d.ID<>0
AND d.DateAdded > '".$DateAddedFrom." 00:00:00'
AND d.DateAdded < '".$DateAddedTo." 23:23:59'
";
$resource=mysql_query($sql) or die(mysql_error());

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
    <title><?php echo SITE_TITLE; ?>- Deposites Management</title>
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
                Deposites Management
                <small>View All Deposites</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Deposites</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- /.box -->
                    <?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
                    <div class="box">
                        <?php if($_SESSION["RoleID"] == ROLE_ID_ADMIN || $_SESSION["RoleID"] == ROLE_ID_SHOP || $_SESSION["RoleID"] == ROLE_ID_SALES){?>
                        <div class="box-header">
                            <div class="btn-group-right">
                                <a style="float:right;" type="button" class="btn btn-group-vertical btn-info" href="dashboard.php" >Back</a>
                                <a style="float:right;margin-right:15px;" type="button" class="btn btn-group-vertical btn-success" href="adddeposite.php" data-original-title="" title="">Add New</a>
                            </div>
                        </div><!-- /.box-header -->
                        <?php } ?>
                        <div class="box-body table-responsive">
                            <form id="frmPages" action="<?php echo $self; ?>" class="form-horizontal no-margin"
                                  method="get">

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
                                        <th>ID</th>
                                        <th>Customer</th>
                                        <?php if($_SESSION["RoleID"] == ROLE_ID_PLANT || $_SESSION["RoleID"] == ROLE_ID_ADMIN){ ?>
                                            <th>Shop</th>
                                        <?php } ?>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Date Added</th>
                                        <!--                                        <th></th>
                                        -->                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php while($row=mysql_fetch_array($resource))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo sprintf('%05u', $row["ID"]); ?></td>
                                            <td><?php echo $row["CustomerName"]; ?></td>
                                            <?php if($_SESSION["RoleID"] == ROLE_ID_PLANT || $_SESSION["RoleID"] == ROLE_ID_ADMIN){ ?>
                                                <td><?php echo getValue('users', 'Name', 'ID', $row["ShopID"]); ?></td>
                                            <?php } ?>
                                            <td><?php echo financials($row["Amount"]); ?></td>
                                            <td><?php echo $row["Description"]; ?></td>
                                            <td><?php echo $row["DateAdded"]; ?></td>
                                            <!--                                            <td>
                                            <div class="btn-group">
                                                <a class="btn btn-primary btn-xs" title="Edit" href="editcustomer.php?ID=<?php /*echo $row["ID"]; */?>"><i class="fa fa-pencil"></i></a>
                                                <a class="btn btn-info btn-xs" title="View" href="viewcustomer.php?ID=<?php /*echo $row["ID"]; */?>"><i class="fa fa-eye"></i></a>
                                                <a class="btn btn-danger btn-xs" title="Delete" href="javascript:;" onclick="doSingleDelete(<?php /*echo $row["ID"]; */?>)"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
-->                                        </tr>
                                    <?php }
                                    ?>
                                    </tbody>
                                </table>
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
                $("#frmPages").submit();
            }
        }
        else{
            alert("None of the list is selected");
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