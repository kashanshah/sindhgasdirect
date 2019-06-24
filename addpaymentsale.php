<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
get_right(array(ROLE_ID_ADMIN, ROLE_ID_SHOP));

	$msg='';
	$ID = $_REQUEST["ID"];

	// FOR PRODUCT 
	$NewOldProduct = 0;
	$BarCode = "";
	$OldBarCode = "";
	$CategoryID="";
	$ProductID = 0;
	$ProductName = "";
	$ShortDescription = "";
	$Description = "";
	$WholePrice = 0;
	$RetailPrice = 0;
	$CurrentStock = 0;
	$Stock = 0;
	$PImage="";
	$DateAdded = "";
	$DateModified = "";
    $NewPayment = 0;

// FOR SUPPLIER
	$NewOldSupplier = 0;
	$SupplierName = "";
	$SupplierID=0;
	$SImage = "user.jpg";
	$NIC = "";
	$Number = "";
	$Address = "";
	$Remarks = "";
	$Email = "";

// FOR Amount
	$Paid = 0;
	$Discount = 0;
	$TotalAmount = 0;
	$Note = '';

	
	$query="SELECT s.ID, u.Name, s.ShopID, s.GasRate, s.Balance, s.Total, s.Paid, s.Unpaid, s.Note, s.DateAdded, s.DateModified FROM sales s LEFT JOIN users u ON u.ID = s.CustomerID WHERE s.ID <> 0 " . ($_SESSION["RoleID"] == ROLE_ID_ADMIN ? '' : ' AND s.ShopID = '.(int)$_SESSION["ID"]) . ' AND s.ID = '.(int)$ID;
	$res = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($res);
	foreach($row as $key => $value)
	{
		$$key=$value;
	}
if(isset($_POST['addsale']) && $_POST['addsale']=='Save')
{
	$msg = "";
	foreach($_POST as $key => $value)
	{
		$$key=$value;
	}

	if(CAPTCHA_VERIFICATION == 1) { if(!isset($_POST["captcha"]) || $_POST["captcha"]=="" || $_SESSION["code"]!=$_POST["captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-ban"></i>Incorrect Captcha Code</div>'; }
	else if($NewPayment == 0 || $NewPayment == "") { $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-ban"></i>Please Enter Correct new payment</div>'; }
	

	
	if($msg == "")
	{
		$query3 = "UPDATE sales SET DateModified = '".DATE_TIME_NOW."',
				Paid=PAID+".(float)financials($NewPayment).",
				Unpaid=Unpaid-".(float)financials($NewPayment).",
				Note='".dbinput($Note)."'
				WHERE ID=".$ID."
				";
		mysql_query($query3) or die('a'.mysql_error());
		
		$query3 = "INSERT INTO sales_amount SET DateAdded='".DATE_TIME_NOW."', DateModified='".DATE_TIME_NOW."',
				PerformedBy = '".(int)$_SESSION["ID"]."',
				Paid='".(float)financials($NewPayment)."',
				Unpaid='".(float)financials($TotalAmount - ($Paid + $Adjustment + $NewPayment))."',
				SaleID=".$ID.",
				Note = '".dbinput($Note)."'
				";
		mysql_query($query3) or die('b'.mysql_error());
		
		$_SESSION["msg"]='<div class="alert alert-success alert-dismissable">
			<i class="fa fa-check"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			Sale payment has been added!
			</div>';
        redirect("viewsale.php?ID=".$ID);
	}
		$_SESSION["msg"] = $msg;
}

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
    <title><?php echo SITE_TITLE; ?>- Add Sale</title>
    <link rel="icon" href="<?php echo DIR_LOGO_IMAGE.SITE_LOGO; ?>" type="image/x-icon">
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
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
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
            Add Sale
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="sales.php"><i class="fa fa-cart-arrow-down"></i> Sales</a></li>
            <li class="active">Add Sale</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <!-- /.box -->
				<form id="frmPages" action="<?php echo $self.'?ID='.$ID; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
              <div class="box ">
                <div class="box-header">
                      <div class="btn-group-right">
                       <button style="float:right;margin-right:15px;" type="button" onClick="location.href='addsale.php'" class="btn btn-group-vertical btn-info">Reset</button>
                       <button style="float:right;margin-right:15px;" type="button" class="btn btn-group-vertical btn-danger" onClick="location.href='sales.php'" >Back</button>
                      </div>
				</div>
			  </div>
			</div>
            <div class="col-md-12">
<?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
            </div>
            <div class="col-md-9">
              <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Sale Information</h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div>
                <div class="box-body">
					<h3><b>Customer Name: </b><?php echo $row["Name"]; ?></h3>
					<h3><b>Sale ID: </b><?php echo $ID; ?></h3>
					<h3><b>Date: </b><?php echo date('D, M d, Y h:i a', strtotime($row["DateAdded"])); ?></h3>
					<h3><b>Gas Rate: </b><?php $GasRate = $row["GasRate"]; echo financials($GasRate); ?></h3>
					<h3><b>Invoices: </b>
						<select id="invoiceid<?php echo $row["ID"]; ?>">
							<?php
								$r = mysql_query("SELECT ID FROM sales_amount WHERE SaleID = '".(int)$row["ID"]."'") or die(mysql_error());
								$n = mysql_num_rows($r);
								while($Rs = mysql_fetch_assoc($r)) { 
								?>
								<option value="printsaleslip.php?ID=<?php echo $Rs['ID']; ?>">PaymentID - <?php echo sprintf('%04u', $Rs['ID']); ?></option>
							<?php }
							?>
						</select>
						<input type="button" value="View" style="align:right" onClick="read(<?php echo $row["ID"]; ?>)"/>
					</h3>
					<h3><b>Sale Details:</b></h3>
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th>SNo.</th>
								<th>Cylinder Code</th>
								<th>Tier Weight (KG)</th>
								<th>Cylinder Weight (KG)</th>
								<th>Gas Weight (KG)</th>
								<th>Price (Rs.)</th>
							</tr>
<?php
$query="SELECT pd.ID, c.BarCode, pd.CylinderID, pd.TierWeight, pd.TotalWeight, pd.Price, DATE_FORMAT(pd.DateAdded, '%D %b %Y %r') AS DateAdded FROM sale_details pd LEFT JOIN cylinders c ON c.ID = pd.CylinderID WHERE pd.SaleID=".(int)$ID;
$resource=mysql_query($query) or die(mysql_error());
$num = mysql_num_rows($resource);
$cou2 = 0;
$__totalGasWeight = 0;
$__totalPrice = 0;
while($data = mysql_fetch_array($resource)){
	$cou2++;
	$__totalGasWeight += ($data["TotalWeight"] - $data["TierWeight"]);
	$__totalPrice += ($data["Price"]);
?>
							<tr>
								<td><?php echo $cou2; ?></td>
								<td><?php echo $data["BarCode"]; ?></td>
								<td><?php echo financials($data["TierWeight"]); ?>KG</td>
								<td><?php echo financials($data["TotalWeight"]); ?>KG</td>
								<td><?php echo financials($data["TotalWeight"] - $data["TierWeight"]); ?>KG</td>
								<td>Rs. <?php echo financials($data["Price"]); ?>/-</td>
							</tr>
<?php
}
?>					
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><?php echo financials($__totalGasWeight); ?>KG</td>
								<td>Rs. <?php echo financials($__totalPrice); ?>/-</td>
							</tr>
						</table><!-- /.box-body -->
					</div><!-- /.box-body -->
                </div><!-- /.box-body -->
              </div><!-- /.box-body -->
              </div><!-- /.box-body -->
              <div class="col-md-3">
			  <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Payment Information</h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div>
                <div class="box-body">
                    <div class="form-group">
						<label class="col-md-12" for="example-text-input">Total Amount</label>
						<div class="col-md-12">
							<input type="number" step="any" class="form-control" placeholder="Enter the Total Amount" readonly="" name="TotalAmount" value="<?php echo financials($row["Total"]); ?>" id="TotalAmount">
						</div>
					</div>
                    <div class="form-group">
                        <label class="col-md-12" for="example-text-input">Amount Adjustment</label>
                        <div class="col-md-12">
                            <input type="number" step="any" class="form-control" placeholder="Amount Adjusted with Balanced KGs" value="<?php echo financials($row["Balance"] * $row["GasRate"]); ?>" name="Adjustment" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="example-text-input">Amount Paid</label>
                        <div class="col-md-12">
                            <input type="number" step="any" class="form-control" placeholder="Enter the Amount Paid" value="<?php echo financials($row["Paid"]); ?>" name="Paid" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
						<label class="col-md-12" for="example-text-input">Amount Remaining</label>
						<div class="col-md-12">
							<input type="number" step="any" class="form-control" placeholder="Enter the Amount Unpaid" value="<?php echo financials($row["Unpaid"]); ?>" name="Unpaid" readonly="">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-12" for="example-text-input">New Payment</label>
						<div class="col-md-12">
							<input type="number" step="any" class="form-control" placeholder="Enter the amount paying" value="<?php echo financials($NewPayment); ?>" max="<?php echo financials($Unpaid); ?>" name="NewPayment">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-12" for="example-text-input">Note</label>
						<div class="col-md-12">
							<textarea class="form-control" name="Note"><?php echo $Note.($_SESSION["RoleID"] == ROLE_ID_ADMIN ? '

By '.$_SESSION["Username"] : '');?></textarea>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-12" for="example-text-input">&nbsp;</label>
						<div class="col-md-12 text-right">
						   <input type="submit" name="addsale" class="btn btn-group-vertical btn-success" value="Save" />
						</div>
					</div>
              <?php if(CAPTCHA_VERIFICATION == 1) { ?>
                    <div class="form-group">
						<label class="col-md-12" for="example-text-input">Captcha</label>
						<div class="col-md-12">
							<img src="captcha.php" />
							<input type="text" class="form-control" placeholder="Enter the captcha" name="captcha">
						</div>
					</div>
			  <?php } ?>
                  </div><!-- /.box-body -->
                </div><!-- /.box-body --> 
              </div><!-- /.box -->
				</form>
              </div><!-- /.box -->
            </div><!-- /.col -->
      <!-- Main Footer -->
      <?php include("footer.php"); ?>
          </div><!-- /.row -->
        </section><!-- /.content -->

      

      <!-- Control Sidebar -->
      <?php include("rightsidebar.php"); ?>
      <!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
      </div><!-- /.content-wrapper -->

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
	function read($ID)
	{
		var a = $ID;
		//alert('invoiceid'+a);
		window.open(document.getElementById('invoiceid'+a).options[document.getElementById('invoiceid'+a).selectedIndex].value);
	}
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

 //       CKEDITOR.replace('Description');
        //bootstrap WYSIHTML5 - text editor
//        $(".Description").wysihtml5();
		});

		
    </script>
</body>
</html>
