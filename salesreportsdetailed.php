<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
get_right(array(1, 2));
$DateAddedFrom = date('Y-m-d');
$DateAddedTo = date('Y-m-d');
$Headings="";
$HeadID=array();
$SortBy="p.ID";

foreach($_POST AS $key => $val)
	$$key = $val;

if(isset($_REQUEST["Headings"]))
{
	$Headings=implode(',', $_REQUEST['Headings']);
	$HeadID=$_REQUEST['Headings'];
}

$sql = "SELECT p.ID, u.Name AS CustomerName, u.ID AS CustomerID, u.Number AS CustomerMobile, p.Total, p.Balance, p.Paid, p.Unpaid, p.Note, p.DateAdded, p.DateModified FROM sales p LEFT JOIN users u ON u.ID = p.CustomerID WHERE p.ID <> 0 " .  ($_SESSION["RoleID"] == ROLE_ID_ADMIN ? "" : ($_SESSION["RoleID"] == ROLE_ID_PLANT ? " AND u.PlantID='".(int)$_SESSION["ID"]."'" : " AND p.ShopID = '".(int)$_SESSION["ID"]."'") ) . " ORDER BY " . $SortBy;
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
    <title><?php echo SITE_TITLE; ?>- Reports Management</title>
	<link rel='shortcut icon' href='<?php echo DIR_LOGO_IMAGE.SITE_LOGO ?>' type='image/x-icon' >
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="dist/css/ionicons.min.css">
    <!-- DataTables -- >
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
.multiselect {
/*	width: auto;*/
}
.selectBox {
	position: relative;
}
.selectBox select {
	/* width: 100%; */
}
.overSelect {
	position: absolute;
	left: 0; right: 0; top: 0; bottom: 0;
}
#checkboxes {
	display: none;
	border: 1px #dadada solid;
}
#checkboxes label {
	display: block;
}
#checkboxes label:hover {
	background-color: #1e90ff;
}
  </style>
	<script>
    var expanded = false;
    function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");
        if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
        } else {
            checkboxes.style.display = "none";
            expanded = false;
        }
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
  <body class="hold-transition skin-blue sidebar-collapse">
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
            Sales Reports
            <small>View Sales Reports</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Sales Reports</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <!-- /.box -->
<?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
              <div class="box">
                <div class="box-body">
				<form id="frmPages" action="<?php echo $self; ?>" class="form-horizontal no-margin" method="post">
				  <div class="form-group">
					<label class="control-label col-md-1 col-sm-1 col-xs-6">From Date</label>
					<div class="col-md-3">
					  <input name="DateAddedFrom" value="<?php echo $DateAddedFrom; ?>" id="DateAddedFrom" class="form-control col-md-7 col-xs-12" type="date">
					</div>
					<label class="control-label col-md-1 col-sm-1 col-xs-6">Till Date</label>
					<div class="col-md-3 col-sm-5 col-xs-6">
					  <input name="DateAddedTo" value="<?php echo $DateAddedTo; ?>" id="DateAddedTo" class="form-control col-md-7 col-xs-12" type="date">
						<input type="hidden" name="Headings[]" value="Total" />
						<input type="hidden" name="Headings[]" value="Discount" />
						<input type="hidden" name="Headings[]" value="Paid" />
						<input type="hidden" name="Headings[]" value="Unpaid" />
						<input type="hidden" name="Headings[]" value="Note" />
						<input type="hidden" name="Headings[]" value="DateAdded" />
						<input type="hidden" name="Headings[]" value="Name" />
						<input type="hidden" name="Headings[]" value="NIC" />
						<input type="hidden" name="Headings[]" value="Number" />
						<input type="hidden" name="Headings[]" value="Address" />
						<input type="hidden" name="Headings[]" value="Email" />
						<input type="hidden" name="Headings[]" value="PerformedBy" />
					</div>
					<div class="col-md-3">
					  <input name="FilterResults" value="FILTER RESULT" id="FilterResults" class="form-control col-md-7 col-xs-12 btn btn-success" type="submit">
					</div>
				  </div>
				</form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              <div class="box">
                <div class="box-body table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
<!--
                        <th>S No.</th>
-->
						<th>Sale ID</th>
						<th>Sales Date</th>
						<th>Product</th>
						<th>Price</th>
						<th>Discount</th>
						<th>Qty.</th>
						<th>Total Amount</th>
						<th>Note</th>
						<th>Customer Name</th>
						<th>NIC</th>
						<th>Number</th>
						<th>Address</th>
						<th>Email</th>
						<th>Salesman</th>
                      </tr>
                    </thead>
		<tbody>
<?php $i = 1;
while($row=mysql_fetch_array($resource))
{
	?>
						<?php 
						$sql = "SELECT * FROM sale_details sa LEFT JOIN cylinders p ON sa.CylinderID=p.ID WHERE sa.SaleID='".$row["ID"]."'";
						$res = mysql_query($sql) or die(mysql_error());
						while($row2 = mysql_fetch_array($res))
						{
						?>
                      <tr style="background-color: <?php echo $i%2 == 0 ? '#eee' : '#ccc'; ?>">
<!--
						  <td><?php echo $i; ?></td>
-->
<!--
						  <td>
							<table class="example2 table table-bordered">
								<thead>
									<tr>
										<th>ID</th>
									</tr>
								</thead>
								<tr>
									<td><?php echo $row2["ID"]; ?></td>
								</tr>
							</table>
						  </td>
	-->
						  <td><?php echo $row["ID"]; ?></td>
						  <td><?php echo $row["DateAdded"]; ?></td>
						  <td><?php echo $row2["Name"]; ?></td>
						  <td><?php echo $row2["Price"]; ?></td>
						  <td><?php echo $row2["Discount"]; ?></td>
						  <td><?php echo $row2["Quantity"]; ?></td>
						  <td><?php echo $row2["Total"] - ($row2["Discount"] * $row2["Quantity"]); ?></td>
						  <td><?php echo $row["Note"]; ?></td>
						  <td><?php echo $row["Name"]; ?></td>
						  <td><?php echo $row["NIC"]; ?></td>
						  <td><?php echo $row["Number"]; ?></td>
						  <td><?php echo $row["Address"]; ?></td>
						  <td><?php echo $row["Email"]; ?></td>
						  <td><?php echo $row["PerformedBy"]; ?></td>
                      </tr>
						<?php
						}
						?>
<?php
				$i++;

}
	?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
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
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <link rel="stylesheet" href="dist/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="dist/css/buttons.dataTables.min.css">
    <script src="dist/js/dataTables.buttons.min.js"></script>
    <script src="dist/js/buttons.flash.min.js"></script>
    <script src="dist/js/pdfmake.min.js"></script>
    <script src="dist/js/vfs_fonts.js"></script>
    <script src="dist/js/buttons.html5.min.js"></script>
    <script src="dist/js/buttons.print.min.js"></script>
    <!-- page script -->
    <script>
      $(function () {
        $("#example1").DataTable({
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'print',
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                alignment: 'center',
                pageSize: 'LEGAL'
            }
			],
          "lengthChange": false,
		});
        // $('.example2').DataTable({
          // "paging": false,
          // "lengthChange": false,
          // "searching": false,
          // "ordering": true,
          // "info": false,
          // "autoWidth": true
		// });
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
