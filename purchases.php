<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
get_right(array(ROLE_ID_ADMIN, ROLE_ID_SHOP, ROLE_ID_PLANT));

	$msg='';
if(isset($_REQUEST['DID']))
{
    if($_SESSION["RoleID"] == ROLE_ID_SHOP){
        mysql_query("UPDATE users SET Balance = Balance+" . (int)$_REQUEST['Balance'] . " WHERE ID = " . $_REQUEST['DID'] . "") or die('a'.mysql_error());
        mysql_query("DELETE FROM purchases WHERE ID = " . $_REQUEST['DID'] . "") or die('b'.mysql_error());
        mysql_query("DELETE FROM purchase_details WHERE PurchaseID = " . $_REQUEST['DID'] . "") or die('c'.mysql_error());
        mysql_query("DELETE FROM cylinderstatus WHERE InvoiceID = " . $_REQUEST['DID'] . "") or die('d'.mysql_error());
        $_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i> Purchase Deleted!
                  </div>';
        redirect($self);
    }else{
        $_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
			<i class="fa fa-ban"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<b>You donot have right to perform this action.</b>
			</div>';
        redirect("purchases.php");
    }
}
$sql="SELECT p.ID, p.Total, p.Balance, p.ShopID, s.Name AS Shop, pl.Name AS Plant, p.Paid, p.Unpaid, p.RefNum, p.Note, p.DateAdded, p.DateModified FROM purchases p 
LEFT JOIN users s ON p.ShopID=s.ID LEFT JOIN users pl ON s.PlantID=pl.ID WHERE p.ID <> 0 " .(($_SESSION["RoleID"] == ROLE_ID_PLANT || $_SESSION["RoleID"] == ROLE_ID_ADMIN) ? '' : ' AND p.ShopID='.$_SESSION["ID"]);
$resource=mysql_query($sql) or die(mysql_error());

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new purchase from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITE_TITLE; ?>- Purchases</title>
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
<script>
	function read($ID)
	{
		var a = $ID;
		//alert('invoiceid'+a);
		window.open(document.getElementById('invoiceid'+a).options[document.getElementById('invoiceid'+a).selectedIndex].value);
	}
</script>
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
            Purchases
            <small>Manage Purchases</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Purchases</li>
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
                       <button style="float:right;" type="button" class="btn btn-group-vertical btn-info" onClick="location.href='dashboard.php'" >Back</button>
					   <?php
						if($_SESSION["RoleID"] == ROLE_ID_SHOP){
						?>
                       <button style="float:right;margin-right:15px;" type="button" class="btn btn-group-vertical btn-success" onClick="location.href='addpurchase.php'" data-original-title="" title="">Add Purchase</button>
						<?php
						}
						?>
                      </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
				<form id="frmPages" action="<?php echo $self; ?>" class="form-horizontal no-margin" method="post">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="display:none;"><input type="checkbox" class="no-margin checkUncheckAll"></th>
                        <th>Invoice ID</th>
                          <?php if($_SESSION["RoleID"] == ROLE_ID_ADMIN){?>
                              <th>Plant</th>
                          <?php } ?>
                          <?php if($_SESSION["RoleID"] == ROLE_ID_PLANT || $_SESSION["RoleID"] == ROLE_ID_ADMIN){?>
                              <th>Shop</th>
                          <?php } ?>
                        <th>Total Price</th>
                        <th>Amount Paid</th>
                        <th>Remaining Payment</th>
                        <th>Date Added</th>
                        <th>Date Modified</th>
                        <th></th>
                      </tr>
                    </thead>
		<tbody>
<?php while($row=mysql_fetch_array($resource))
{
	?>
                      <tr>
                        <td style="display:none;width:5%"><input type="checkbox" value="<?php echo $row["ID"]; ?>" name="ids[]" class="no-margin chkIds"></td>
                        <td><?php echo sprintf('%04u', $row["ID"]); ?></td>
                          <?php if($_SESSION["RoleID"] == ROLE_ID_ADMIN){?>
                              <td><?php echo $row["Plant"]; ?></td>
                          <?php } ?>
                          <?php if($_SESSION["RoleID"] == ROLE_ID_PLANT || $_SESSION["RoleID"] == ROLE_ID_ADMIN){?>
                              <td><?php echo $row["Shop"]; ?></td>
                          <?php } ?>
                        <td><?php echo financials($row["Total"]); ?></td>
                        <td><?php echo financials($row["Paid"]); ?></td>
                        <td><?php echo financials($row["Unpaid"]); ?></td>
                        <td><?php echo $row["DateAdded"]; ?></td>
                        <td><?php echo $row["DateModified"]; ?></td>
                        <td class="text-center">
							<a class="btn btn-primary btn-xs" href="viewpurchase.php?ID=<?php echo $row["ID"]; ?>">View</a>
					   <?php
                       if($_SESSION["RoleID"] == ROLE_ID_SHOP) {
                           ?>
                           <?php
                           $inn1query = "SELECT pd.ID, c.BarCode, pd.CylinderID, pd.TierWeight, pd.TotalWeight, pd.Price, pd.ReturnStatus, pd.ReturnWeight, pd.ReturnDate, pd.GasRate, DATE_FORMAT(pd.DateAdded, '%D %b %Y %r') AS DateAdded FROM purchase_details pd LEFT JOIN cylinders c ON c.ID = pd.CylinderID WHERE pd.PurchaseID=" . (int)$row["ID"] . " AND pd.ReturnStatus=1";
                           $inn1numres = mysql_query($inn1query) or die(mysql_error());
                           $inn1numrow = mysql_num_rows($inn1numres);
                           if ($inn1numrow == 0 && false) {
                               ?>
                               <a class="btn btn-danger btn-xs"
                                  href="purchases.php?DID=<?php echo $row["ID"]; ?>&Balance=<?php echo $row["Balance"]; ?>&InvoiceID=<?php echo getCurrentHandedInvoiceID($row["CylinderID"]); ?>">Delete
                                  </a>
                               <?php
                           }
                       }
                           ?>
                           <?php
                           if ($_SESSION["RoleID"] == ROLE_ID_SHOP) {
                               ?>
                               <?php echo($row["Unpaid"] > 0 ? '<a class="btn btn-warning btn-xs" href="addpaymentpurchase.php?ID=' . $row["ID"] . '">Add Payment</a>' : ''); ?>
                               <?php
                           }
                            ?>
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
          //            "lengthChange": false,
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
