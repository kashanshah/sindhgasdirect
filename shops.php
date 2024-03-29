<?php include("common.php"); ?>
<?php include("checkadminlogin.php");
get_right(array(ROLE_ID_PLANT, ROLE_ID_ADMIN));
$msg='';
if(isset($_REQUEST['ids']) && is_array($_REQUEST['ids']))
{
    foreach($_REQUEST['ids'] as $CID)
    {
        //echo $CID;exit();
        $query = "DELETE FROM users WHERE ID = ".$CID."";
        mysql_query($query);
        $_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i> Shop(s) Deleted!
                  </div>';
    }
}
if(isset($_REQUEST['DID']))
{
    $query = "DELETE FROM users WHERE ID = ".$_REQUEST['DID']."";
    mysql_query($query);
    $_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i>Shop Deleted!
                  </div>';
    redirect($self);
}

$sql="SELECT u.ID, u.Username, u.Password, u.Balance, u.Credit, u.Remarks, u.LastActivity, u.LastLogin, u.SendSMS, u.PlantID, r.Name AS Role, u.Address, u.Number, u.Name FROM users u LEFT JOIN roles r ON r.ID = u.RoleID where u.ID<>0 AND u.RoleID = ".(int)ROLE_ID_SHOP;
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
    <title><?php echo SITE_TITLE; ?>- Shops Management</title>
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
                Shops
                <small>View Shops</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Shops</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- /.box -->
                    <?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
                    <div class="box">
                        <div class="box-header">
                            <div class="btn-group-right">
                                <?php if($_SESSION["RoleID"] == ROLE_ID_PLANT || $_SESSION["RoleID"] == ROLE_ID_ADMIN){?>
                                <a style="float:right;" type="button" class="btn btn-group-vertical btn-info" href="dashboard.php" >Back</a>
                                <a style="float:right;margin-right:15px;" type="button" class="btn btn-group-vertical btn-success" href="addshop.php" data-original-title="" title="">Add New</a>
                                <button style="float:right;margin-right:15px;" type="button" onClick="doDelete()" class="btn btn-group-vertical btn-danger" data-original-title="" title="">Delete</button>
                                <?php } ?>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <form id="frmPages" action="<?php echo $self; ?>" class="form-horizontal no-margin" method="post">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <?php if($_SESSION["RoleID"] == ROLE_ID_ADMIN || $_SESSION["RoleID"] == ROLE_ID_PLANT){ ?>
                                        <th><input type="checkbox" class="no-margin checkUncheckAll"></th>
                                        <?php } ?>
                                        <th>Username</th>
                                        <?php if($_SESSION["RoleID"] == ROLE_ID_ADMIN){ ?>
                                            <th>Password</th>
                                        <?php } ?>
                                        <th>Name</th>
                                        <?php if($_SESSION["RoleID"] == ROLE_ID_ADMIN){ ?>
                                            <th>Plant</th>
                                        <?php } ?>
                                        <th>Unpaid</th>
                                        <th>Unpaid Invoices</th>
                                        <th>Gas Balance</th>
                                        <th>Amount Credit</th>
                                        <th>Contact Number</th>
                                        <th class="hidden">Remarks</th>
                                        <th>Last Activity At</th>
                                        <th>Last Login At</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php while($row=mysql_fetch_array($resource))
                                    {
                                        ?>
                                        <tr>
                                            <?php if($_SESSION["RoleID"] == ROLE_ID_ADMIN || $_SESSION["RoleID"] == ROLE_ID_PLANT){ ?>
                                            <td style="width:5%"><input type="checkbox" value="<?php echo $row["ID"]; ?>" name="ids[]" class="no-margin chkIds"></td>
                                            <?php } ?>
                                            <td><?php echo $row["Username"]; ?></td>
                                            <?php if($_SESSION["RoleID"] == ROLE_ID_ADMIN){ ?>
                                                <td><?php echo $row["Password"]; ?></td>
                                            <?php } ?>
                                            <td><?php echo $row["Name"]; ?></td>
                                            <?php if($_SESSION["RoleID"] == ROLE_ID_ADMIN){ ?>
                                                <td><?php echo getValue('users', 'Name', 'ID', $row["PlantID"]); ?></td>
                                            <?php } ?>
                                            <td>
                                                Rs. <?php $Bal = getUserBalance($row["ID"], false); echo financials(abs($Bal)); ?>/-
                                            </td>
                                            <td>
                                                <?php
                                                if($Bal < 0){
                                                    $osisql="SELECT p.ID, p.Total, p.Paid, p.Unpaid, p.Note, p.DateAdded, p.DateModified FROM purchases p WHERE p.ShopID = ".$row["ID"]." AND p.Unpaid > 0 ";
                                                    $osiresource=mysql_query($osisql) or die(mysql_error());
                                                    ?>
                                                    <div style="max-height:100px;overflow:auto;">
                                                        <?php
                                                        if(mysql_num_rows($osiresource) > 0){
                                                        ?>
                                                        <a onClick='slideToggle("#invoices<?php echo $row["ID"]; ?>")'>View Invoices</a>
                                                        <div id="invoices<?php echo $row["ID"]; ?>" style="display:none;">
                                                        <?php
                                                        }
                                                        while($oisrow = mysql_fetch_array($osiresource)){
                                                            ?>
                                                            <div>
                                                                <a href="viewpurchase.php?ID=<?php echo $oisrow["ID"]; ?>" target="_blank">Invoice # <?php echo sprintf('%04u', $oisrow["ID"]); ?></a>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }else{
                                                    echo 'No unpaid invoice.';
                                                }
                                                    ?>
                                            </td>
                                            <td><?php echo financials($row["Balance"]); ?>KG Gas</td>
                                            <td>
                                                Rs. <?php echo financials($row["Credit"]); ?>/-
                                            </td>
                                            <td><?php echo $row["Number"]; ?></td>
                                            <td class="hidden"><?php echo $row["Remarks"]; ?></td>
                                            <td><?php echo $row["LastActivity"]; ?></td>
                                            <td><?php echo $row["LastLogin"]; ?></td>
                                            <td>
                                                <a class="btn btn-primary btn-xs" title="Edit" href="editshop.php?ID=<?php echo $row["ID"]; ?>"><i class="fa fa-pencil"></i></a>
                                                <a class="btn btn-danger btn-xs" title="Delete" href="javascript:;" onclick="doSingleDelete(<?php echo $row["ID"]; ?>)"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
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
