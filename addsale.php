<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
get_right(array(3));

	$ID = "";
	$msg = "";
	
// FOR PRODUCT 
		// foreach($_POST as $key => $value)
		// {
			// $_SESSION["cart_customer"][$$key]=$value;
		// }
	$BarCode = "";
	$OldBarCode = "";
	$CategoryID="";
	$CylinderID = 0;
	$HandedTo = $_SESSION["ID"];
	$CylinderName = "";
	$ShortDescription = "";
	$Description = "";
	$Price = 0;
	$CurrentStock = 0;
	$Quantity = 1;
	$PImage="";
	$DateAdded = "";
	$DateModified = "";

// FOR CUSTOMER
	$NewOldCustomer = 0;
	$CustomerName = "Anonymous";
	$CustomerID=0;
	$SImage = "user.jpg";
	$Number = "";
	$Address = "";
	$Remarks = "";
	$Email = "";

// FOR Amount
	$SaleAmountID = 0;
	$Paid = 0;
	$TotalAmount = 0;
	$Balance = 0;
	$Note = "";
	$CylinderWeight = array();
		
	$Print = ((isset($_COOKIE["PrintSlipsByDefault"]) && ctype_digit($_COOKIE["PrintSlipsByDefault"])) ? 1 : 0);

	
if(isset($_POST['addsale']) && $_POST['addsale']=='Save changes')
{
	$msg = "";
	foreach($_POST as $key => $value)
	{
		$$key=$value;
	}
	setcookie("PrintSlipsByDefault", $Print);
//	if(!isset($_POST["CustomerID"])) $NewOldCustomer = 0;
	if(CAPTCHA_VERIFICATION == 1) { if(!isset($_POST["captcha"]) || $_POST["captcha"]=="" || $_SESSION["code"]!=$_POST["captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Incorrect Captcha Code</div>'; }
	else if(!isset($CylinderID) && empty($CylinderID)) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Select a cylinder to sale.</div>';
	else if(!isset($TotalAmount)) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter Correct Total Amount</div>';
	else if((isset($_POST["CustomerName"]) && $_POST["CustomerName"] == "") && (isset($_POST["CustomerID"]) && ($_POST["CustomerID"] == "" || $_POST["CustomerID"] == "0"))) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Select a Customer</div>';
	else if(!isset($CylinderID) && empty($CylinderID)) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please select a cylinder to sale.</div>';
	
	if($msg == "")
	{
		$query2 = ($NewOldCustomer == "1" ? 'INSERT INTO ' : 'UPDATE ').' users SET DateModified=NOW(),
				'.($NewOldCustomer == "1" ? 'Name ="'.($CustomerName == '' ? 'Anonymous' : $CustomerName).'", DateAdded="NOW", ' : '').'
				Username = "'.time().'",
				Password = "'.generate_refno(rand()).generate_refno(time()).'",
				RoleID = "'.ROLE_ID_CUSTOEMR.'",
				Number = "'.dbinput($Number).'",
				Email = "'.dbinput($Email).'",
				Address = "'.dbinput($Address).'",
				Remarks = "'.dbinput($Remarks).'",
				Status = "0",
				PerformedBy = "'.(int)$_SESSION["ID"].'"
				'.($NewOldCustomer == "0" ? ' WHERE ID='.$CustomerID : ' ');
		mysql_query($query2) or die (mysql_error());
		if(mysql_insert_id() != 0){
			$CustomerID = mysql_insert_id();
		}
		mysql_query("INSERT INTO invoices SET DateAdded = NOW(),
			PerformedBy = '".(int)$_SESSION["ID"]."',
			IssuedTo = '".(int)$CustomerID."',
			Note = '".dbinput($Note)."'") or die(mysql_error());
		$InvoiceID = mysql_insert_id();

		mysql_query("UPDATE users SET Balance=Balance-'".(int)$Balance."' WHERE ID=".$CustomerID);

		if($NewOldCustomer == 1)
		{
			if(isset($_FILES["SFile"]) && $_FILES["SFile"]['name'] != "")
			{
				$tempName2 = $_FILES["SFile"]['tmp_name'];
				$realName2 = $CustomerID.".".$ext2;
				$StoreImage = $realName2; 
				$target2 = DIR_USER_IMAGES . $realName2;

				if(is_file(DIR_USER_IMAGES . $StoreImage))
					unlink(DIR_USER_IMAGES . $StoreImage);
			
				ini_set('memory_limit', '-1');
				
				$moved2=move_uploaded_file($tempName2, $target2);
			
				if($moved2)
				{
					$query2="UPDATE users SET Image='" . dbinput($realName2) . "' WHERE  ID=" . (int)$CID;
					mysql_query($query2) or die(mysql_error());
					$_SESSION["msg"]='<div class="alert alert-danger alert-dismissable">
						<i class="fa fa-ban"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Customer added, but sale record could not be added.
						</div>';
				}
			}
		}
		$query3 = "INSERT INTO sales SET DateAdded = NOW(),
			ShopID='".(int)($_SESSION["ID"])."',
			CustomerID='".(int)($CustomerID)."',
			GasRate='".(float)GAS_RATE."',
			Total='".(float)($TotalAmount)."',
			Balance='".(float)($Balance)."',
			Paid='".(float)$Paid."',
			Unpaid='".(float)($TotalAmount - $Balance - $Paid)."',
			PerformedBy = '".(int)$_SESSION["ID"]."',
			Note='".dbinput($Note)."'
			";
		mysql_query($query3) or die(mysql_error());
		$SaleID = mysql_insert_id();

		$query4 = "INSERT INTO sales_amount SET DateAdded=NOW(),
				PerformedBy = '".(int)$_SESSION["ID"]."',
				SaleID=".$SaleID.",
				Paid='".(float)$Paid."',
				Unpaid='".(float)($TotalAmount - $Balance - $Paid)."',
				Note = '".dbinput($Note)."'";
		mysql_query($query4) or die(mysql_error());
		$SaleAmountID = mysql_insert_id();

		$i = 0;
		foreach($CylinderID as $CID){
			$query4 = "INSERT INTO sale_details SET DateAdded = NOW(),
				SaleID='".(int)$SaleID."',
				CylinderID='".(int)$CID."',
				TierWeight='".(float)$CylinderWeight[$i]."',
				TotalWeight='".(float)$CurrentCylinderWeight[$i]."',
				Price='".(float)$SalePrice[$i]."',
				GasRate='".(float)($SalePrice[$i] / ($CurrentCylinderWeight[$i] - $CylinderWeight[$i]))."',
				PerformedBy = '".(int)$_SESSION["ID"]."'
				";
			mysql_query($query4) or die(mysql_error());
			$query2 = "INSERT INTO cylinderstatus SET DateAdded = NOW(),
				InvoiceID='".(int)$SaleID."',
				CylinderID='".(int)$CID."',
				HandedTo='".(int)$CustomerID."',
				Weight='".(float)$CurrentCylinderWeight[$i]."',
				PerformedBy = '".(int)$_SESSION["ID"]."'
			";
			mysql_query($query2) or die(mysql_error());
			$i++;
		}
		
		$_SESSION["msg"]='<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<i class="fa fa-check"></i>
			Sale has been added!
			</div>';
		if($Print == "1")
		{
			echo '<script>window.open("printsaleslip.php?ID='.$SaleAmountID.'", "_blank"); window.location.href=window.location.href;</script>';
		}
		else{
			redirect("addsale.php");
		}
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
    <title><?php echo SITE_TITLE; ?></title>
    <link rel="icon" href="<?php echo DIR_LOGO_IMAGE.SITE_LOGO; ?>" type="image/x-icon">
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
            Sale Cylinders
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="cylinders.php"><i class="fa fa-circloe-o"></i> Cylinders Management</a></li>
            <li class="active">Sale Cylinders</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="">
              <!-- /.box -->
              <div class="col-md-12">
				  <div class="box ">
					<div class="box-header text-right">
						  <div class="btn-group-right">
						   <button type="button" class="checkout-button btn btn-primary btn-lg">
								Confirm
							</button>
						  </div>
					</div>
				  </div>
			  </div>
<!--
				<form id="cart_update" action="cart_update.php" class="form-horizontal" method="post" enctype="multipart/form-data"> -->
				<div class="col-md-12">
<?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
</div>
              <div class="col-md-3">
              <div class="box ">
				<div class="box-header with-border">
				  <h3 class="box-title">Select Cylinder</h3>
				  <div class="box-tools pull-right">
<!--					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> -->
				  </div>
				</div>
                <div class="box-body">
                    <div class="form-group row">
						<label class="col-md-12 control-label" for="example-text-input">Bar Code</label>
						<div class="col-md-12">
							<form id="barcodesubmit">
							<input autofocus type="text" class="form-control" value="<?php echo $BarCode; ?>" name="BarCode" id="BarCode">
							</form>
						</div>
					</div>
				 <div class="form-group row">
					<label class="col-md-12 control-label" for="example-text-input">Cylinder</label>
						<div class="col-md-12">
							<select name="CylinderID" id="CylinderID" class="form-control">
								<?php
									$r = mysql_query("SELECT ID, BarCode, TierWeight FROM cylinders WHERE ExpiryDate > '".date('Y-m-d h:i:s')."'") or die(mysql_error());
									$n = mysql_num_rows($r);
									if($n == 0)
									{
										echo '<option value="0">No Cylinder Added</option>';
									}
									else
									{
										while($Rs = mysql_fetch_assoc($r)) { 
											if(getCurrentStatus($Rs["ID"]) == 3 && getCurrentHandedTo($Rs["ID"]) == $_SESSION["ID"]){
										?>
										<option data-tierweight="<?php echo $Rs["TierWeight"]; ?>" data-weight="<?php echo getCurrentPurchaseWeight($Rs["ID"]); ?>" data-price="<?php echo getRetailPrice($Rs["ID"]); ?>" BarCode="<?php echo $Rs["BarCode"]; ?>" value="<?php echo $Rs['ID']; ?>" <?php if($CylinderID==$Rs['ID']) { echo 'selected=""'; } ?>><?php echo $Rs['BarCode']; ?> - <?php echo $Rs['TierWeight'] ?>kg</option>
										<?php 
											}
										}
									}
							?>
							</select>
						</div>
					</div>
                    <div class="form-group row">
						<label class="col-md-3 control-label" for="example-text-input"></label>
						<div class="col-md-12">
							<input type="hidden" name="return_url" value="<?php echo $current_url; ?>" />
							<input type="button" id="AddItemButton" class="btn btn-group-vertical form-control btn-success" value="Add" />
							<input type="hidden" name="type" value="Add" id="AddToCart"/>
						</div>
					</div>
<!--
				</form>
-->
				</div>
			  </div>
				</div><!-- /.box-body -->
				<form id="mainForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="form-horizontal cart-form" method="post" enctype="multipart/form-data">
              <div class="col-md-9">
              <!-- SPACE FOR CART -->
              <div class="box ">
				<div class="box-header with-border">
				  <h3 class="box-title">Cylinder Information</h3>
				</div>
                <div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
						  <tr>
							<th>S No.</th>
							<th>Name</th>
							<th>Tier Weight</th>
							<th>Full Weight</th>
							<th>Gas Weight</th>
							<th>Current Full Weight</th>
							<th>Current Gas Weight</th>
							<th>Gas Rate</th>
							<th>Price</th>
							<th><a class="btn btn-danger dropdown-toggle" href="<?php echo $_SERVER["REQUEST_URI"]; ?>">Clear All</a></th>
						  </tr>
						</thead>
						<tbody class="cart_table">
						</tbody>
					  </table>
                  </div><!-- /.box-body -->
                </div><!-- /.box-body -->	
              </div><!-- /.box-body -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<br/>
			<h4 class="modal-title" id="myModalLabel">Confirm?</h4>
		  </div>
		<div class="modal-body">
					<div class="box box-body">
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Total Amount</label>
							<div class="col-md-8">
								<input type="number" class="form-control" placeholder="Enter the Total Payable Amount" readonly="" name="TotalAmount" value="<?php echo $TotalAmount; ?>" id="TotalAmount">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Balance</label>
							<div class="col-md-8">
								<input type="number" class="form-control" placeholder="" readonly="" name="Balance" value="<?php echo $Balance; ?>" id="Balance" data-balance="0">
								<p class="help">Account balance: <?php echo $Balance; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Amount Payable</label>
							<div class="col-md-8">
								<input type="number" class="form-control" placeholder="Enter the payable amount" readonly="" name="Unpaid" value="<?php echo $Unpaid; ?>" id="Unpaid" disabled>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Amount Paying</label>
							<div class="col-md-8">
								<input type="number" class="form-control" placeholder="Enter the Amount Paying" name="Paid" value="<?php echo $Paid; ?>" id="Paid">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Note</label>
							<div class="col-md-8">
								<textarea class="form-control" name="Note"><?php echo stripcslashes($Note);?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input"></label>
							<div class="col-md-8">
								<input type="checkbox" value="1" id="NewOldCustomer" <?php echo ($NewOldCustomer == "1") ? 'checked=""' : '' ;?> name="NewOldCustomer"><label> New Customer</label>
							</div>
						</div>
						<div class="form-group" id="CustomerName">
							<label class="col-md-3 control-label" for="example-text-input">Name</label>
							<div class="col-md-8">
								<input type="text" class="form-control" value="<?php echo $CustomerName;?>" placeholder="Enter Customer Name" name="CustomerName">
							</div>
						</div>
						<div class="form-group" id="CustomerID">
						<label class="col-md-3 control-label" for="example-text-input">Customer</label>
							<div class="col-md-8">
								<select class="form-control select2" data-placeholder="Select The Customer" name="CustomerID" style="width: 100%;">
									<?php
										$r = mysql_query("SELECT ID, Name FROM users WHERE RoleID=".ROLE_ID_CUSTOEMR) or die(mysql_error());
										$n = mysql_num_rows($r);
										if($n == 0)
										{
											echo '<option value="0">No User Added</option>';
										}
										else
										{
											while($Rs = mysql_fetch_assoc($r)) { ?>
											<option value="<?php echo $Rs['ID']; ?>" <?php if($CustomerID==$Rs['ID']) { echo 'Selected=""'; } ?>><?php echo $Rs['Name']; ?></option>
											<?php }
										}
								?>
								</select>
								<div id="SImage"></div>
							</div>
						</div>
						<div class="form-group" id="SFile">
							<label class="col-md-3 control-label" for="example-text-input">Image</label>
							<div class="col-md-8">
								<input type="file" name="SFile">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Number</label>
							<div class="col-md-8">
								<input type="text" class="form-control" value="<?php echo $Number;?>" placeholder="Enter Number" name="Number">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Address</label>
							<div class="col-md-8">
								<textarea class="form-control" name="Address"><?php echo $Address;?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Email</label>
							<div class="col-md-8">
								<input type="email" class="form-control" value="<?php echo $Email;?>" placeholder="Enter Email" name="Email">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Remarks</label>
							<div class="col-md-8">
								<textarea class="form-control" name="Remarks"><?php echo stripcslashes($Remarks);?></textarea>
							</div>
						</div>
				<?php if(CAPTCHA_VERIFICATION == 1) { ?>
				  <div class="col-md-6">
				  <div class="box box-default">
					<div class="box-header with-border">
					  <h3 class="box-title">Human Verification</h3>
					  <div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					  </div>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Captcha</label>
							<div class="col-md-8">
								<img src="captcha.php" />
								<input type="text" class="form-control" placeholder="Enter the captcha" name="captcha">
							</div>
						</div>
					  </div><!-- /.box-body -->
					</div><!-- /.box-body --> 
				  </div><!-- /.box -->
				  <?php } ?>
			</div><!-- /.box-body -->
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input type="submit" name="addsale" value="Save changes" class="btn btn-primary" />
		  </div>
		</div>
	  </div>
	</div>
	</div>
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

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
	<!-- Select2 -->
    <script src="plugins/select2/select2.full.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <script src="plugins/jquery-validation/dist/jquery.validate.min.js"></script>
    <!-- page script -->
<script>
	var i =0;
	
	function calculateWeights()
	{
		var gt =0;
		$('.CylinderWeight').each(function(){
			var cWeight = parseFloat($(this).val());
			var cTierWeight = parseFloat($("#CylinderTierWeight"+$(this).data("id")).text());
			$("#CylinderGasWeight"+$(this).data("id")).text((cWeight - cTierWeight).toFixed(2));
			gt = gt + (parseFloat($(this).val()));
		});
	}
	function gettotal()
	{
		var gt = 0;
		$('.SalePrice').each(function(){
			gt = gt + parseFloat($(this).val());
		});
		$("#TotalAmount").val(gt);
		$("#Unpaid").val(gt);
		if(parseFloat($("#Balance").attr("data-balance")) > parseFloat($("#TotalAmount").val())){
			$("#Balance").val($("#TotalAmount").val());
			$("#Unpaid").val(gt - parseFloat($("#Balance").val()));
		}else{
			$("#Balance").val($("#Balance").attr("data-balance"));
			$("#Unpaid").val(gt - parseFloat($("#Balance").val()));
		}
		$("#Paid").attr("max", $("#Unpaid").val());
	}
	
$('#mainForm').submit(function (e) {
	if(!$("#myModal").hasClass("in")){
		e.preventDefault();
		$("#myModal").modal('show');
	}
});

$(document).ready(function() {
	$('#myModal').on('shown.bs.modal', function () {
		$('#HandedTo').focus();
		$('[name="CustomerID"]').trigger("change");
	})  
	$(document).on('click', '.checkout-button', function()
	{
		var valid = true;
		if($(".cart-form input[name='CylinderID[]'").filter(function() {return !!this.value;}).length == 0)
		{
			valid = false;
		}
		else
		{
			$(".cart-form input").each(function(){
				if($(this).valid() == false)
				{
					valid = false;
					$(this).valid();
				}
			});
		}
			if(valid == true){
				$("#myModal").modal();
				if(parseFloat($("#Balance").attr("data-balance")) > parseFloat($("#TotalAmount").val())){
					$("#Balance").val($("#TotalAmount").val());
				}else{
					$("#Balance").val(parseFloat($("#Balance").attr("data-balance")));
				}
				gettotal();
			}
	});
	$(document).on('keyup', '.SalePrice', function() {
		var parEl = $(this).closest("tr");
		var cylWeight = parseFloat(parEl.find(".CylinderTierWeight").text());
		var newCylWeight = parseFloat(parEl.find(".CurrentCylinderWeight").val());
		var newGasWeight = newCylWeight - cylWeight;
		var newSalePrice = parseFloat(parEl.find(".SalePrice").val());
		parEl.find(".CurrentGasRate").val(((newSalePrice) / newGasWeight).toFixed(2));
		parEl.find(".CurrentCylinderGasWeight").text(newGasWeight.toFixed(2));
		gettotal();
	});
	$(document).on('keyup', '.CurrentGasRate', function() {
		var parEl = $(this).closest("tr");
		var cylWeight = parseFloat(parEl.find(".CylinderTierWeight").text());
		var newCylWeight = parseFloat(parEl.find(".CurrentCylinderWeight").val());
		var newGasWeight = newCylWeight - cylWeight;
		parEl.find(".SalePrice").val(((newGasWeight) * parEl.find(".CurrentGasRate").val()).toFixed(2));
		parEl.find(".CurrentCylinderGasWeight").text(newGasWeight.toFixed(2));
		gettotal();
	});
	$(document).on('keyup', '.CurrentCylinderWeight', function() {
		var parEl = $(this).closest("tr");
		var cylWeight = parseFloat(parEl.find(".CylinderTierWeight").text());
		var newCylWeight = parseFloat(parEl.find(".CurrentCylinderWeight").val());
		var newGasWeight = newCylWeight - cylWeight;
		parEl.find(".SalePrice").val(((newGasWeight) * parEl.find(".CurrentGasRate").val()).toFixed(2));
		parEl.find(".CurrentCylinderGasWeight").text(newGasWeight.toFixed(2));
		gettotal();
	});
});

	$("#AddItemButton").click(function() {
		var j=0, q=0;
		$('.cart_table input[name="CylinderID[]"]').each(function(){
			if($(this).val() == $("#CylinderID").val())
			{
				j = 1;
				gettotal();
				calculateWeights();
			}
			q = q+1;
		});
		if(j!=1)
		{
			var gasWeight = parseFloat($("[name='CylinderID'] option:selected").data('weight')) - parseFloat($("[name='CylinderID'] option:selected").data('tierweight'));
			$(".cart_table").append('<tr class="DivCartCylinder'+$("[name='CylinderID']").val()+'">');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td style="width:5%"><input type="hidden" name="CylinderID[]" value="'+$("[name='CylinderID']").val()+'" /><span class="SerialNo" >'+$("[name='CylinderID']").val()+'</span></td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><span id="CylinderCartName'+i+'" >'+$("[name='CylinderID'] option:selected").text()+'</span></td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><input type="hidden" name="CylinderWeight[]" required="" value="' + $("[name='CylinderID'] option:selected").data('tierweight') + '" /><span class="CylinderTierWeight" id="CylinderTierWeight'+i+'">'+$("[name='CylinderID'] option:selected").data('tierweight')+'</span>KG</td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><span id="CylinderGasWeight'+i+'">'+$("[name='CylinderID'] option:selected").data('weight')+'</span>KG</td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td>'+gasWeight.toFixed(2)+'KG</td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><input type="number" min="'+$("[name='CylinderID'] option:selected").data('tierweight')+'" name="CurrentCylinderWeight[]" class="CurrentCylinderWeight CurrentCylinderWeight'+i+'" required="" value="' + $("[name='CylinderID'] option:selected").data('weight').toFixed(2) + '" /></td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><span class="CurrentCylinderGasWeight" id="CurrentCylinderGasWeight'+i+'" >'+gasWeight.toFixed(2)+'</span>KG</td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><input type="number" class="CurrentGasRate CurrentGasRate'+i+'" value="' + (parseFloat($("[name='CylinderID'] option:selected").data('price')) / gasWeight).toFixed(2) + '" /></td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><input type="number" name="SalePrice[]" class="SalePrice SalePrice'+i+'" required="" value="' + ($("[name='CylinderID'] option:selected").data('price')).toFixed(2) + '" /></td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><div class="btn-group"><a class="btn btn-danger btn-xs dropdown-toggle"><i  onclick="deletethisrow(\'.DivCartCylinder'+$("[name='CylinderID']").val()+'\');" class="fa fa-times"></i></a></div></td>');
			$(".cart_table").append('</tr>');
			i = i + 1;
			gettotal();
			calculateWeights();
		}
		$("#BarCode").val('');
		$("#BarCode").focus();
		return false;
	});
	function deletethisrow(a) {
		$(a).remove();
		gettotal();
		calculateWeights();
	}
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

 //       CKEDITOR.replace('Description');
        //bootstrap WYSIHTML5 - text editor
//        $(".Description").wysihtml5();

		});


	$(document).ready(function(){
		if($("#NewOldCustomer").prop('checked') == true) <!-- FOR NEW Customer -->
		{
			$("#CustomerID").slideUp();
			$("[name='CustomerID']").prop("required", false);
			$("#CustomerName").slideDown();
			$("#SFile").slideDown();
		}
		else 									<!-- FOR OLD Customer -->
		{
			$("#CustomerID").prop("required", true);
			$("#CustomerName").slideUp();
			$("#CustomerID").slideDown();
			$("#SFile").slideUp();
		}
		$("#NewOldCustomer").change(function () {
			if($("#NewOldCustomer").prop('checked') == true) <!-- FOR NEW Customer -->
			{
				$("#CustomerID").slideUp();
				$("#CustomerName").slideDown();
				$("#SFile").slideDown();
				$("[name='CustomerName']").val('Anonymous');
				$("[name='Number']").val('');
				$("[name='Balance']").val(0);
				$("[name='Balance']").attr("data-balance", 0);
				$("[name='Address']").val('');
				$("[name='Email']").val('');
				$("[name='Remarks']").val('');
			}
			else 									<!-- FOR OLD Customer -->
			{
				$("#CustomerName").slideUp();
				$("#CustomerID").slideDown();
				$("#SFile").slideUp();
				$("[name='CustomerID']").val('');
				$("[name='CustomerID']").trigger("change");
			}
			gettotal();
		});
		$("[name='CustomerID']").change(function () {
			if($("[name='CustomerID']").val() != "0" || $("[name='CustomerID']").val() != ""){
				$.ajax({			
					url: 'get_customer_details.php?ID='+$("[name='CustomerID']").val(),
					success: function(data, status) {
						var result = JSON.parse(data);
						$("[name='CustomerName']").val(result.Name);
						$("[name='Number']").val(result.Number);
						$("[name='Address']").val(result.Address);
						$("[name='Balance']").val(parseFloat(result.Balance));
						$("[name='Balance']").val(parseFloat(result.Balance));
						$("[name='Balance']").attr("data-balance", result.Balance);
						$("[name='Email']").val(result.Email);
						$("[name='Remarks']").val(result.Remarks);
						$("#SImage").html('<img src="<?php echo DIR_USER_IMAGES; ?>'+result.Image+'" width="100" height="100">');
						if(parseFloat($("#Balance").attr("data-balance")) > parseFloat($("#TotalAmount").val())){
							$("#Balance").val($("#TotalAmount").val());
						}else{
							$("#Balance").val($("#Balance").attr("data-balance"));
						}
						gettotal();
						},
					error: function (xhr, textStatus, errorThrown) {
						alert(xhr.responseText);
					}
				});
			}
		});		
	});

	$(document).ready(function(){
		$("#barcodesubmit").submit(function () {
			$("#CylinderID option").each(function(){
				  $(this).removeAttr("selected");
			});
			$("#CylinderID option").each(function(){
			  if ($(this).attr("BarCode") == $("#BarCode").val())
			  {
				  $("#CylinderID").val($(this).val());
					$("#AddItemButton").click();
			  }
			});
			return false;
		});
	});
		
	$(document).load(function() { $("#BarCode").focus(); });

    </script>
</body>
</html>