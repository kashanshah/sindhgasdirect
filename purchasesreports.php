<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
get_right(array(1));
$DateAddedFrom = "";
$DateAddedTo = "";
$HeadID = array();
$Headings="";
$HeadID=array();
$SortBy="s.ID";

foreach($_POST AS $key => $val)
	$$key = $val;

if(isset($_REQUEST["Headings"]))
{
	$Headings=implode(',', $_REQUEST['Headings']);
	$HeadID=$_REQUEST['Headings'];
}

$sql="SELECT p.Name AS ProductName, s.Quantity, p.Stock, p.WholePrice, p.RetailPrice, s.ID, u.Name, u.NIC, u.Number, u.Address, u.Email, u.Remarks, s.Total, s.Discount, s.Paid, s.Unpaid, s.Note, s.DateAdded, s.DateModified, a.Username AS PerformedBy FROM purchases s LEFT JOIN users u ON u.ID = s.SupplierID LEFT JOIN admins a ON a.ID = s.PerformedBy LEFT JOIN products p ON s.ProductID = p.ID WHERE s.ID <>0 AND (s.DateAdded BETWEEN '".$DateAddedFrom."' AND '".$DateAddedTo."') "." ORDER BY ".$SortBy." ASC";
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
            Purchases Reports
            <small>View Purchases Reports</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Purchases Reports</li>
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
					</div>
					<label class="control-label col-md-1 col-sm-1 col-xs-6">Headers</label>
					<div class="col-md-3 col-sm-5 col-xs-6">
						 <div class="selectBox" onclick="showCheckboxes()">
							<select class="form-control col-md-7 col-xs-12">
								<option>Select Headings</option>
							</select>
							<div class="overSelect"></div>
						</div>
						<div id="checkboxes" style="height:250px; overflow:scroll;">
							<label><input <?php echo (in_array("Name", $HeadID) ? "checked = checked" : "") ?> type="checkbox" name="Headings[]" value="Name" /> Supplier Name</label>
							<label><input <?php echo (in_array("ProductName", $HeadID) ? "checked = checked" : "") ?> type="checkbox" name="Headings[]" value="ProductName" /> Product Name</label>
							<label><input <?php echo (in_array("RetailPrice", $HeadID) ? "checked = checked" : "") ?> type="checkbox" name="Headings[]" value="RetailPrice" /> Retail Price</label>
							<label><input <?php echo (in_array("Stock", $HeadID) ? "checked = checked" : "") ?> type="checkbox" name="Headings[]" value="Stock" /> Stock</label>
							<label><input <?php echo (in_array("Quantity", $HeadID) ? "checked = checked" : "") ?> type="checkbox" name="Headings[]" value="Quantity" /> Quantity</label>
							<label><input <?php echo (in_array("WholePrice", $HeadID) ? "checked = checked" : "") ?> type="checkbox" name="Headings[]" value="WholePrice" /> Whole Sale Price</label>
							<label><input <?php echo (in_array("Discount", $HeadID) ? "checked = checked" : "") ?> type="checkbox" name="Headings[]" value="Discount" /> Discount</label>
							<label><input <?php echo (in_array("Total", $HeadID) ? "checked = checked" : "") ?> type="checkbox" name="Headings[]" value="Total" /> Total</label>
							<label><input <?php echo (in_array("Paid", $HeadID) ? "checked = checked" : "") ?> type="checkbox" name="Headings[]" value="Paid" /> Paid</label>
							<label><input <?php echo (in_array("Unpaid", $HeadID) ? "checked = checked" : "") ?> type="checkbox" name="Headings[]" value="Unpaid" /> Unpaid</label>
							<label><input <?php echo (in_array("Note", $HeadID) ? "checked = checked" : "") ?> type="checkbox" name="Headings[]" value="Note" /> Note</label>
							<label><input <?php echo (in_array("DateAdded", $HeadID) ? "checked = checked" : "") ?> type="checkbox" name="Headings[]" value="DateAdded" /> Purchases Date</label>
							<label><input <?php echo (in_array("NIC", $HeadID) ? "checked = checked" : "") ?> type="checkbox" name="Headings[]" value="NIC" /> Supplier NIC</label>
							<label><input <?php echo (in_array("Number", $HeadID) ? "checked = checked" : "") ?> type="checkbox" name="Headings[]" value="Number" /> Supplier Number</label>
							<label><input <?php echo (in_array("Address", $HeadID) ? "checked = checked" : "") ?> type="checkbox" name="Headings[]" value="Address" /> Supplier Address</label>
							<label><input <?php echo (in_array("Email", $HeadID) ? "checked = checked" : "") ?> type="checkbox" name="Headings[]" value="Email" /> Supplier Email</label>
							<label><input <?php echo (in_array("PerformedBy", $HeadID) ? "checked = checked" : "") ?> type="checkbox" name="Headings[]" value="PerformedBy" /> Purchaseman Username</label>
								<?php
								// $query = "SHOW FIELDS FROM records";
								// $res = mysql_query($query);
								// while($row = mysql_fetch_array($res))
								// {
								// echo '<label>&emsp;<input '.(in_array($row['Field'], $HeadID) ? "checked = checked" : "").' type="checkbox" name="Headings[]" value="'.$row['Field'].'"/> '.$row['Field'].'</label>';
								// }
								// ?>
						</div>
					</div>
					<div class="col-md-12">
					<div class="col-md-offset-9 col-md-3">
					  <input name="FilterResults" value="FILTER RESULT" id="FilterResults" class="form-control col-md-7 col-xs-12 btn btn-success" type="submit">
					</div>
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
                        <th>S No.</th>
					  <?php
						foreach($HeadID AS $Heads)
						{
						echo '<th>'.$Heads.'</th>';
						}
					  ?>
                      </tr>
                    </thead>
		<tbody>
<?php $i = 1;
while($row=mysql_fetch_array($resource))
{
	?>
                      <tr>
                      <td><?php echo $i; ?></td>
					  <?php
						foreach($HeadID AS $Heads)
						{
							echo '<td>'.dboutput($row[$Heads]).'</td>';
						}
					  ?>
                      </tr>
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
