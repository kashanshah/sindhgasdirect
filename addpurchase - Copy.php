<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
get_right(array(1, 3));

	$ID = "";
	$msg = "";
	
// FOR CYLINDER 
		// foreach($_POST as $key => $value)
		// {
			// $_SESSION["cart_customer"][$$key]=$value;
		// }
	$BarCode = "";
	$OldBarCode = "";
	$CategoryID="";
	$CylinderID = 0;
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
	$NewOldCustomer = 1;
	$CustomerName = "Anonymous";
	$CustomerID=0;
	$SImage = "user.jpg";
	$NIC = "";
	$Number = "";
	$Address = "";
	$Remarks = "";
	$Email = "";

// FOR Amount
	$Paid = 0;
	$TotalDiscount = 0;
	$TotalAmount = 0;
	$BilledAmount = 0;
	$Note = "";
	
	$Print = ((isset($_COOKIE["PrintSlipsByDefault"]) && ctype_digit($_COOKIE["PrintSlipsByDefault"])) ? 1 : 0);
	
if(isset($_POST['addsale']) && $_POST['addsale']=='Save changes')
{
	$msg = "";
	foreach($_POST as $key => $value)
	{
		$$key=$value;
	}
	$_COOKIE["PrintSlipsByDefault"] = $Print;
//	if(!isset($_POST["CusomerID"])) $NewOldCustomer = 0;
	if(CAPTCHA_VERIFICATION == 1) { if(!isset($_POST["captcha"]) || $_POST["captcha"]=="" || $_SESSION["code"]!=$_POST["captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Incorrect Captcha Code</div>'; }
	else if(!isset($_POST["TotalAmount"])) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter Correct Total Amount</div>';
	else if(!isset($_POST["Paid"])) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter Correct Amount Paying</div>';
	else if((isset($_POST["CustomerName"]) && $_POST["CustomerName"] == "") && (isset($_POST["CustomerID"]) && ($_POST["CustomerID"] == "" || $_POST["CustomerID"] == "0"))) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Select a Customer</div>';
	else if(!isset($CylinderID) && empty($CylinderID)) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Select a cylinder.</div>';

	if($msg == "")
	{
		$query2 = ($NewOldCustomer == "1" ? 'INSERT INTO ' : 'UPDATE ').' users SET DateModified=NOW(),
				'.($NewOldCustomer == "1" ? 'Name ="'.($CustomerName == '' ? 'Anonymous' : $CustomerName).'", DateAdded="NOW", ' : '').'
				NIC = "'.dbinput($NIC).'",
				Number = "'.dbinput($Number).'",
				Address = "'.dbinput($Address).'",
				Email = "'.dbinput($Email).'",
				Remarks = "'.dbinput($Remarks).'",
				PerformedBy = "'.(int)$_SESSION["ID"].'"
				'.($NewOldCustomer == "0" ? ' WHERE ID='.$CustomerID : ' ');
//				echo $query2; exit();
		mysql_query($query2) or die (mysql_error());
		if($NewOldCustomer == 1)
		{
			$CID = mysql_insert_id();
			if(isset($_FILES["SFile"]) && $_FILES["SFile"]['name'] != "")
			{
				$tempName2 = $_FILES["SFile"]['tmp_name'];
				$realName2 = $CID.".".$ext2;
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
						Only two queries executed. Sale record not added.
						</div>';
				}
			}
		}
		else
		{
			$CID = $CustomerID;
		}
		$_SESSION["msg"]='<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				Only two queries executed. Sale record not added.
				</div>';
	}
	
	if($msg == "")
	{
		$query3 = "INSERT INTO sales SET DateAdded = NOW(),
				CustomerID='".(int)$CID."',
				Total='".(float)($BilledAmount)."',
				Discount='".(float)$TotalDiscount."',
				Unpaid='".(float)($BilledAmount - $TotalDiscount - $Paid)."',
				Paid='".(float)$Paid."',
				PerformedBy = '".(int)$_SESSION["ID"]."',
				Note='".dbinput($Note)."'
				";
				
		mysql_query($query3) or die(mysql_error());
		$SID = mysql_insert_id();
		$query4 = "INSERT INTO sales_amount SET DateAdded=NOW(),
				PerformedBy = '".(int)$_SESSION["ID"]."',
				SaleID=".$SID.",
				Paid='".(float)$Paid."'";
		mysql_query($query4) or die(mysql_error());
		$IID = mysql_insert_id();
		for($i = 0; $i<count($CylinderID); $i ++)
		{
			$te = mysql_query("SELECT RetailPrice FROM cylinders WHERE ID='".(int)$CylinderID[$i]."'") or die(mysql_error());
			if(mysql_num_rows($te) > 0)
			{
				$FinalPrice = mysql_result($te, 0, 0);
				mysql_query("INSERT INTO sales_details SET DateAdded = NOW(), SaleID='".(int)$SID."',
					CylinderID='".(int)$CylinderID[$i]."',
					Price='".$FinalPrice."',
					Discount='".($CylinderDiscount[$i])."',
					Quantity='".$CylinderQuantity[$i]."',
					PerformedBy = '".(int)$_SESSION["ID"]."',
					Total='".$FinalPrice * $CylinderQuantity[$i]."'
					") or die(mysql_error());
				$query4 = "UPDATE cylinders SET 
						Stock = (Stock-".(int)$CylinderQuantity[$i].")
						WHERE ID='".(int)$CylinderID[$i]."'";
				mysql_query($query4) or die(mysql_error());
			}
		}
		
		$msg='<div class="alert alert-success alert-dismissable">
			<i class="fa fa-check"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			Sale has been added!
			</div>';
		if($Print == "1")
		{
			echo '<script>window.open("printsaleslip.php?ID='.$IID.'", "_blank"); </script>';
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
    <title><?php echo SITE_TITLE; ?>- Point Of Sales</title>
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
            Point Of Sales
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="sales.php"><i class="fa fa-cart-arrow-down"></i> Sales</a></li>
            <li class="active">Point Of Sales</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <!-- /.box -->
              <div class="box ">
                <div class="box-header">
                      <div class="btn-group-right">
                       <a style="float:right;margin-right:15px;" type="button" href="addsale.php" class="btn btn-group-vertical btn-info">Reset</a>
                       <a style="float:right;margin-right:15px;" type="button" class="btn btn-group-vertical btn-danger" href="sales.php" >Back</a>
                       <button style="float:right;margin-right:15px;" type="button" class="checkout-button btn btn-primary btn-lg">
							Checkout
						</button>
                      </div>
				</div>
			  </div>
<!--
				<form id="cart_update" action="cart_update.php" class="form-horizontal" method="post" enctype="multipart/form-data"> -->
<?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
              <div class="col-md-6">
              <div class="box box-default">
				<div class="box-header with-border">
				  <h3 class="box-title">Select Cylinder</h3>
				  <div class="box-tools pull-right">
<!--					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> -->
				  </div>
				</div>
                <div class="box-body">
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Bar Code</label>
						<div class="col-md-8">
							<form id="barcodesubmit">
							<input autofocus type="text" class="form-control" value="<?php echo $BarCode; ?>" name="BarCode" id="BarCode">
							</form>
						</div>
					</div>
                    <div class="form-group">
					<label class="col-md-3 control-label" for="example-text-input">Cylinder</label>
						<div class="col-md-8">
							<select name="CylinderID" id="CylinderID" class="form-control">
								<?php
									$r = mysql_query("SELECT ID, Name, RetailPrice, WholePrice, BarCode FROM cylinders ") or die(mysql_error());
									$n = mysql_num_rows($r);
									if($n == 0)
									{
										echo '<option value="0">No Cylinder Added</option>';
									}
									else
									{
										while($Rs = mysql_fetch_assoc($r)) { ?>
										<option price="<?php echo $Rs["RetailPrice"]; ?>" wholeprice="<?php echo $Rs["WholePrice"]; ?>" BarCode="<?php echo $Rs["BarCode"]; ?>" value="<?php echo $Rs['ID']; ?>" <?php if($CylinderID==$Rs['ID']) { echo 'Selected=""'; } ?>><?php echo $Rs['Name']; ?></option>
										<?php }
									}
							?>
							</select>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Quantity</label>
						<div class="col-md-8">
							<input type="number" class="form-control" value="<?php echo $Quantity;?>" placeholder="Enter Quantity" name="Quantity" id="Quantity">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input"></label>
						<div class="col-md-8">
							<input type="hidden" name="return_url" value="<?php echo $current_url; ?>" />
							<input style="float:right;margin-right:15px;" type="button" id="AddItemButton" class="btn btn-group-vertical btn-success" value="Add" />
							<input type="hidden" name="type" value="Add" id="AddToCart"/>
						</div>
					</div>
<!--
				</form>
-->
				</div>
			  </div>
				</div><!-- /.box-body -->
				<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="form-horizontal cart-form" method="post" enctype="multipart/form-data">
              <div class="col-md-6">
              <!-- SPACE FOR CART -->
              <div class="box box-default">
				<div class="box-header with-border">
				  <h3 class="box-title">Cylinder Information</h3>
				</div>
                <div class="box-body">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
						  <tr>
							<th>S No.</th>
							<th>Name</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Discount</th>
							<th>Total</th>
							<th><a class="btn btn-danger dropdown-toggle" href="update_cart_delete.php?ID=all&url=<?php echo $current_url; ?>">Clear All</a></th>
						  </tr>
						</thead>
						<tbody class="cart_table">
						</tbody>
					  </table>
					  <table class="table table-bordered table-striped">
						<tr class="DivTotal">
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th class="btn-success">Total</th>
							<th class="btn-success"><span class="CartGrandTotal">0</span></th>
						</tr>
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
			<input type="submit" name="addsale" value="Save changes" class="btn btn-primary pull-right" />
			<h4 class="modal-title" id="myModalLabel">Check Out</h4>
		  </div>
		<div class="modal-body">
					<div class="box box-body">
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Billed Amount</label>
							<div class="col-md-8">
								<input type="number" class="form-control" placeholder="Billed Amount" readonly="" name="BilledAmount" value="<?php echo $BilledAmount; ?>" id="BilledAmount">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Total Discount</label>
							<div class="col-md-8">
								<input type="number" class="form-control" placeholder="Enter the Total Discount Amount" readonly="" value="<?php echo $TotalDiscount; ?>" name="TotalDiscount" id="TotalDiscount">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Payable Amount</label>
							<div class="col-md-8">
								<input type="number" class="form-control" placeholder="Enter the Total Payable Amount" readonly="" name="TotalAmount" value="<?php echo $TotalAmount; ?>" id="TotalAmount">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Amount Paying</label>
							<div class="col-md-8">
								<input type="number" class="form-control" placeholder="Enter the initial amount paying" value="" required="" name="Paid" id="Paid">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Note</label>
							<div class="col-md-8">
								<textarea class="form-control" name="Note"><?php echo stripcslashes($Note);?></textarea>
							</div>
						</div>
					  <div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Print Slip?</label>
							<div class="col-md-6">
							  <input type="radio" name="Print" value="1" <?php echo ($Print == "1" ? 'checked=""' : '') ?>> Yes &nbsp;&nbsp;&nbsp;&nbsp;
							  <input type="radio" name="Print" value="0" <?php echo ($Print == "0" ? 'checked=""' : '') ?>> No
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
							<option value="0"></option>
							<?php
								$r = mysql_query("SELECT ID, Name FROM users ") or die(mysql_error());
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
					<label class="col-md-3 control-label" for="example-text-input">NIC</label>
					<div class="col-md-8">
						<input type="text" class="form-control" value="<?php echo $NIC;?>" placeholder="Enter NIC Number" name="NIC" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label" for="example-text-input">Address</label>
					<div class="col-md-8">
						<input type="text" class="form-control" value="<?php echo $Number;?>" placeholder="Enter Address" name="Number">
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
	
	function gettotalbilled()
	{
		var gt =0;
		$('.CylinderQuantity').each(function(){
			gt = gt + (parseInt($(this).val()) * (parseInt($(this).parent().parent().find('.CylinderCartPrice').text())));
		});
		$("#BilledAmount").val(gt);
		
	}
	function gettotal()
	{
		var gt =0;
		$('.CylinderCartSubTotal').each(function(){
			gt = gt + parseInt($(this).text());
		});
		$(".DivTotal .CartGrandTotal").text(gt);
		$("#TotalAmount").val(gt);
		
	}
	function gettotaldiscount()
	{
		var gt =0;
		$('.CylinderDiscount').each(function(){
			gt = gt + (parseInt($(this).val()) * (parseInt($(this).parent().parent().find('.CylinderQuantity').val())));
		});
		$("#TotalDiscount").val(gt);
		
	}
$(document).ready(function() {
	$('#myModal').on('shown.bs.modal', function () {
		$('#Paid').focus();
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
			if(valid == true)
				$("#myModal").modal();
	});
	$(document).on('change', '.CylinderQuantity', function() { 
		$(this).parent().parent().find('.CylinderCartSubTotal').text(parseInt($(this).val()) * (parseInt($(this).parent().parent().find('.CylinderCartPrice').text()) - parseInt($(this).parent().parent().find('.CylinderDiscount').val())));
		gettotal();
		gettotalbilled();
		gettotaldiscount();
	});
	$(document).on('change', '.CylinderDiscount', function() { 
		$(this).parent().parent().find('.CylinderCartSubTotal').text(parseInt($(this).parent().parent().find('.CylinderQuantity').val()) * (parseInt($(this).parent().parent().find('.CylinderCartPrice').text()) - parseInt($(this).parent().parent().find('.CylinderDiscount').val())));
		gettotal();
		gettotalbilled();
		gettotaldiscount();
	});
});

	$("#AddItemButton").click(function() {
		var j=0, q=0;
		$('.cart_table input[name="CylinderID[]"]').each(function(){
			if($(this).val() == $("#CylinderID").val())
			{
				j = 1;
				$('.CylinderQuantity'+(q)+'').val(parseInt($('.CylinderQuantity'+(q)+'').val()) + parseInt($("#Quantity").val()));
				$('.CylinderCartSubTotal'+(q)+'').text(parseInt($('.CylinderQuantity'+(q)+'').val()) * (parseInt($('.CylinderCartPrice'+(q)+'').text()) - parseInt($('.CylinderDiscount'+(q)+'').val())));
				gettotal();
				gettotalbilled();
				gettotaldiscount();
			}
			q = q+1;
		});
		if(j!=1)
		{
			$(".cart_table").append('<tr class="DivCartCylinder"><td style="width:5%"><input type="hidden" name="CylinderID[]" value="'+$("[name='CylinderID']").val()+'" /><span class="SerialNo" >'+$("[name='CylinderID']").val()+'</span></td><td><span class="CylinderCartName CylinderCartName'+i+'" >'+$("[name='CylinderID'] option:selected").text()+'</span></td><td><span class="CylinderCartPrice CylinderCartPrice'+i+'" >'+$("[name='CylinderID'] option:selected").attr("Price")+'</span></td><td><input type="number" name="CylinderQuantity[]" class="CylinderQuantity CylinderQuantity'+i+'" required="" value="'+$("#Quantity").val()+'" /></td><td><input type="number" name="CylinderDiscount[]" class="CylinderDiscount CylinderDiscount'+i+'" required="" <?php echo ($_SESSION["RoleID"] == ROLE_ID_ADMIN ? '' : 'max="\'+parseInt(parseInt($("[name=\'CylinderID\'] option:selected").attr("Price")) - parseInt($("[name=\'CylinderID\'] option:selected").attr("wholeprice")))+\'"'); ?> value="0" /></td><td><span class="CylinderCartSubTotal CylinderCartSubTotal'+i+'" >'+$("#Quantity").val() * $("[name='CylinderID'] option:selected").attr("Price")+'</span></td><td><div class="btn-group"><a class="btn btn-danger dropdown-toggle" onclick="deletethisrow(this);">Delete</a></div></td></tr>');
			i = i + 1;
			gettotal();
			gettotalbilled();
			gettotaldiscount();
		}
		$("#BarCode").val('');
		$("#BarCode").focus();
		return false;
	});
	function deletethisrow(a) {
		$(a).closest(".DivCartCylinder").remove();
		gettotal();
		gettotalbilled();
		gettotaldiscount();
	}
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

 //       CKEDITOR.replace('Description');
        //bootstrap WYSIHTML5 - text editor
//        $(".Description").wysihtml5();
	$( "#Quantity" ).change(function() {
		var a = $("#Quantity").val() * $("#Price").val();
		$("#TotalAmount").val(a);
	});

	$( "#Quantity" ).keyup(function() {
		var a = $("#Quantity").val() * $("#Price").val();
		$("#TotalAmount").val(a);
	});
	$( "#Price" ).change(function() {
		var a = $("#Quantity").val() * $("#Price").val();
		$("#TotalAmount").val(a);
	});
	$( "#Price" ).keyup(function() {
		var a = $("#Quantity").val() * $("#Price").val();
		$("#TotalAmount").val(a);
	});


		});

	$(document).ready(function(){
		if($("#NewOldCustomer").prop('checked') == true) <!-- FOR NEW Customer -->
		{
			$("#CustomerID").slideUp();
			$("#CustomerName").slideDown();
			$("#SFile").slideDown();
		}
		else 									<!-- FOR OLD Customer -->
		{
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
					$("[name='CustomerName']").val('');
					$("[name='NIC']").val('');
					$("[name='Number']").val('');
					$("[name='Address']").val('');
					$("[name='Email']").val('');
					$("[name='Remarks']").val('');
				}
				else 									<!-- FOR OLD Customer -->
				{
					$("#CustomerName").slideUp();
					$("#CustomerID").slideDown();
					$("#SFile").slideUp();
				}
			});
		});


		$("[name='CustomerID']").change(function () {
			$.ajax({			
					url: 'get_customer_details.php?ID='+$("[name='CustomerID']").val(),
					success: function(data, status) {
//						var d =json_decode(data);
						var result = [];

						a = data.split('HERESPLITHERE'); 
						while(a[0]) {
							result.push(a.splice(0,1));
						}
//						alert(data);
//						$("[name='CustomerName']").val(result[1]);
						$("[name='NIC']").val(result[2]);
						$("[name='Number']").val(result[3]);
						$("[name='Address']").val(result[4]);
						$("[name='Email']").val(result[5]);
						$("[name='Remarks']").val(result[6]);
						$("#SImage").html('<img src="<?php echo DIR_USER_IMAGES; ?>'+result[1]+'" width="100" height="100">');
						},
					error: function (xhr, textStatus, errorThrown) {
						alert(xhr.responseText);
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
					$("#Quantity").val('1');
					var a = $("#Quantity").val() * $("#Price").val();
					$("#TotalAmount").val(a);
					$("#AddItemButton").click();
			  }
			});
			return false;
		});
		});
		
		$(document).ready(function(){
		$("[name='CylinderID']").change(function () {
			var a = $("#Quantity").val() * $("#Price").val();
			$("#TotalAmount").val(a);
		});
		});
		
		
		
		
		<!-- FOR CUSTOMER -->
		
	$(document).ready(function(){
		$("[name='CustomerID']").change(function () {
			$.ajax({			
					url: 'get_customer_details.php?ID='+$("[name='CustomerID']").val(),
					success: function(data, status) {
//						var d =json_decode(data);
						var result = [];

						a = data.split('HERESPLITHERE'); 
						while(a[0]) {
							result.push(a.splice(0,1));
						}
//						alert(data);
//						$("[name='CustomerName']").val(result[1]);
						$("[name='NIC']").val(result[2]);
						$("[name='Number']").val(result[3]);
						$("[name='Address']").val(result[4]);
						$("[name='Email']").val(result[5]);
						$("[name='Remarks']").val(result[6]);
						$("#SImage").html('<img src="<?php echo DIR_USER_IMAGES; ?>'+result[1]+'" width="100" height="100">');
						},
					error: function (xhr, textStatus, errorThrown) {
						alert(xhr.responseText);
					}
			});
		});
		});
		
$(".resetall").click(function() {
    $(this).closest('form').find("input[type=text], textarea").val("");
});
		

				$(document).load(function() { $("#BarCode").focus(); });

    </script>
</body>
</html>